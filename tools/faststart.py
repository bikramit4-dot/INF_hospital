#!/usr/bin/env python3
"""qt-faststart equivalent: relocate the moov atom to the front of an MP4 and
adjust stco/co64 chunk offsets so media data stays at valid absolute offsets."""
import struct, sys

def parse_boxes(data, start=0, end=None):
    if end is None:
        end = len(data)
    pos = start
    boxes = []
    while pos + 8 <= end:
        size = struct.unpack('>I', data[pos:pos+4])[0]
        typ = data[pos+4:pos+8].decode('latin1')
        hdr = 8
        if size == 1:
            size = struct.unpack('>Q', data[pos+8:pos+16])[0]
            hdr = 16
        elif size == 0:
            size = end - pos
        if size < hdr or pos + size > end:
            break
        boxes.append((typ, pos, size, hdr))
        pos += size
    return boxes

def adjust_offsets(moov, delta):
    d = bytearray(moov)
    def walk(start, end):
        pos = start
        while pos + 8 <= end:
            size = struct.unpack('>I', d[pos:pos+4])[0]
            typ = d[pos+4:pos+8].decode('latin1')
            hdr = 8
            if size == 1:
                size = struct.unpack('>Q', d[pos+8:pos+16])[0]
                hdr = 16
            elif size == 0:
                size = end - pos
            if size < hdr or pos + size > end:
                break
            if typ == 'stco':
                count = struct.unpack('>I', d[pos+hdr+4:pos+hdr+8])[0]
                base = pos + hdr + 8
                for i in range(count):
                    off = struct.unpack('>I', d[base+i*4:base+i*4+4])[0]
                    struct.pack_into('>I', d, base+i*4, off + delta)
            elif typ == 'co64':
                count = struct.unpack('>I', d[pos+hdr+4:pos+hdr+8])[0]
                base = pos + hdr + 8
                for i in range(count):
                    off = struct.unpack('>Q', d[base+i*8:base+i*8+8])[0]
                    struct.pack_into('>Q', d, base+i*8, off + delta)
            else:
                walk(pos+hdr, pos+size)
            pos += size
    walk(0, len(d))
    return bytes(d)

def main(inpath, outpath):
    data = open(inpath, 'rb').read()
    boxes = parse_boxes(data)
    types = [b[0] for b in boxes]
    if not types or types[0] != 'ftyp':
        print('ERROR: ftyp box not first'); sys.exit(1)
    if 'moov' not in types or 'mdat' not in types:
        print('ERROR: missing moov/mdat'); sys.exit(1)
    if types.index('moov') < types.index('mdat'):
        print('already faststart; copying')
        open(outpath, 'wb').write(data)
        return

    ftyp = data[boxes[0][1]:boxes[0][1]+boxes[0][2]]
    moov = data[boxes[types.index('moov')][1]:boxes[types.index('moov')][1]+boxes[types.index('moov')][2]]
    old_mdat_pos = boxes[types.index('mdat')][1]

    # boxes before mdat in the original file (e.g. free) keep their relative order
    pre_mdat_len = sum(s for t, p, s, h in boxes if p < old_mdat_pos and t not in ('ftyp', 'moov'))
    new_mdat_pos = len(ftyp) + len(moov) + pre_mdat_len
    delta = new_mdat_pos - old_mdat_pos

    if delta:
        moov = adjust_offsets(moov, delta)

    out = bytearray()
    out += ftyp
    out += moov
    for t, p, s, h in boxes:
        if t in ('ftyp', 'moov'):
            continue
        out += data[p:p+s]
    open(outpath, 'wb').write(bytes(out))
    print(f'OK: wrote {outpath} (delta={delta}, {len(out)} bytes)')

if __name__ == '__main__':
    if len(sys.argv) != 3:
        print('usage: faststart.py <in.mp4> <out.mp4>'); sys.exit(1)
    main(sys.argv[1], sys.argv[2])
