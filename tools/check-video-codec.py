#!/usr/bin/env python3
"""Scan an MP4 for known codec FourCCs to report video/audio codecs."""
import sys

KNOWN = [b'avc1', b'avc3', b'hvc1', b'hev1', b'vp09', b'av01', b'mp4a', b'ac-3', b'ec-3', b'Opus', b'jpeg']

def main(path):
    data = open(path, 'rb').read()
    found = {}
    for fourcc in KNOWN:
        idx = data.find(fourcc)
        if idx != -1:
            # find all occurrences, dedupe
            positions = []
            start = 0
            while True:
                i = data.find(fourcc, start)
                if i == -1:
                    break
                positions.append(i)
                start = i + 1
            found[fourcc.decode()] = positions
    if not found:
        print("No known codec FourCCs found")
        return
    for codec, positions in found.items():
        print(f"{codec}: {len(positions)} occurrence(s), first at byte {positions[0]}")
    # guess
    if any(c in found for c in ('hvc1', 'hev1')):
        print(">>> Video codec: HEVC / H.265  (NOT supported in many browsers)")
    elif 'avc1' in found or 'avc3' in found:
        print(">>> Video codec: AVC / H.264  (widely supported)")

if __name__ == '__main__':
    main(sys.argv[1])
