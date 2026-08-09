import AVFoundation
import Foundation

// Usage: swift compress-video.swift <input.mp4> <output.mp4>
// Re-encodes the video to H.264, max 1920px wide (preserving aspect ratio),
// no audio track, ~3 Mbps average bitrate -> web-friendly background loop.

let args = CommandLine.arguments
guard args.count >= 3 else {
    print("usage: swift compress-video.swift <input> <output>")
    exit(1)
}
let inputURL = URL(fileURLWithPath: args[1])
let outputURL = URL(fileURLWithPath: args[2])

let asset = AVURLAsset(url: inputURL)
guard let videoTrack = asset.tracks(withMediaType: .video).first else {
    print("ERROR: no video track found")
    exit(1)
}

// Account for any rotation in the source
let naturalSize = videoTrack.naturalSize
let preferred = videoTrack.preferredTransform
let rotated = naturalSize.applying(preferred)
let srcWidth = abs(rotated.width)
let srcHeight = abs(rotated.height)

let targetWidth: CGFloat = 1920
let scale = targetWidth / srcWidth
let targetSize = CGSize(width: targetWidth, height: srcHeight * scale)

let fps = videoTrack.nominalFrameRate
let frameDuration = CMTime(value: 1, timescale: max(1, Int32(round(fps))))

// --- Video composition to scale frames ---
let composition = AVMutableVideoComposition()
composition.renderSize = targetSize
composition.frameDuration = frameDuration

let instruction = AVMutableVideoCompositionLayerInstruction(assetTrack: videoTrack)
let transform = preferred.concatenating(CGAffineTransform(scaleX: scale, y: scale))
instruction.setTransform(transform, at: .zero)

let compInstruction = AVMutableVideoCompositionInstruction()
compInstruction.timeRange = CMTimeRange(start: .zero, duration: asset.duration)
compInstruction.layerInstructions = [instruction]
composition.instructions = [compInstruction]

// --- Reader ---
guard let reader = try? AVAssetReader(asset: asset) else {
    print("ERROR: cannot create reader")
    exit(1)
}
let readerOutput = AVAssetReaderVideoCompositionOutput(
    videoTracks: [videoTrack],
    videoSettings: [
        kCVPixelBufferPixelFormatTypeKey as String: kCVPixelFormatType_32BGRA
    ]
)
readerOutput.videoComposition = composition
readerOutput.alwaysCopiesSampleData = false
reader.add(readerOutput)

// --- Writer ---
guard let writer = try? AVAssetWriter(outputURL: outputURL, fileType: .mp4) else {
    print("ERROR: cannot create writer")
    exit(1)
}
let writerInput = AVAssetWriterInput(mediaType: .video, outputSettings: [
    AVVideoCodecKey: AVVideoCodecType.h264,
    AVVideoWidthKey: Int(targetSize.width),
    AVVideoHeightKey: Int(targetSize.height),
    AVVideoCompressionPropertiesKey: [
        AVVideoAverageBitRateKey: 3_000_000,
        AVVideoMaxKeyFrameIntervalKey: 60,
        AVVideoProfileLevelKey: AVVideoProfileLevelH264HighAutoLevel,
    ],
])
writerInput.expectsMediaDataInRealTime = false
writer.add(writerInput)

let adaptor = AVAssetWriterInputPixelBufferAdaptor(
    assetWriterInput: writerInput,
    sourcePixelBufferAttributes: [
        kCVPixelBufferPixelFormatTypeKey as String: kCVPixelFormatType_32BGRA
    ]
)

// --- Transcode loop ---
writer.startWriting()
writer.startSession(atSourceTime: .zero)
reader.startReading()

var frames = 0
while reader.status == .reading, let sample = readerOutput.copyNextSampleBuffer() {
    guard let pixelBuffer = CMSampleBufferGetImageBuffer(sample) else { continue }
    let pts = CMSampleBufferGetPresentationTimeStamp(sample)
    var appended = false
    var attempts = 0
    while !appended && attempts < 100 {
        if writerInput.isReadyForMoreMediaData {
            appended = adaptor.append(pixelBuffer, withPresentationTime: pts)
        } else {
            Thread.sleep(forTimeInterval: 0.02)
        }
        attempts += 1
    }
    frames += appended ? 1 : 0
}
writerInput.markAsFinished()

let semaphore = DispatchSemaphore(value: 0)
writer.finishWriting { semaphore.signal() }
semaphore.wait()

let size = (try? FileManager.default.attributesOfItem(atPath: args[2])[.size] as? Int) ?? 0
print("done: frames=\(frames) status=\(writer.status.rawValue) error=\(writer.error?.localizedDescription ?? "none")")
print("output=\(args[2]) size=\(size) bytes (\(size / 1024 / 1024) MB) target=\(Int(targetSize.width))x\(Int(targetSize.height)) fps=\(Int(fps))")
if writer.status != .completed { exit(1) }
