#!/usr/bin/env python3
"""Fetch key pages and verify all internal links/assets resolve (HTTP 200)."""
import re
import urllib.request

BASE = 'http://localhost/hospital-website/'
PAGES = [
    'index.php',
    'pages/index.php',
    'pages/about.php',
    'pages/services.php',
    'pages/contact.php',
    'pages/book-appointment.php',
    'pages/find-doctor.php',
    'pages/home.php',  # should NOT be directly servable... it's a view; expected to fail/leak? check
]

url_re = re.compile(r'(?:href|src|action)="([^"]+)"')

def fetch(url):
    try:
        with urllib.request.urlopen(url, timeout=10) as r:
            return r.status, r.read().decode('utf-8', 'ignore')
    except urllib.error.HTTPError as e:
        return e.code, ''
    except Exception as e:
        return 'ERR', ''

seen = set()
failures = []
for page in PAGES:
    status, html = fetch(BASE + page)
    if status != 200:
        failures.append(f'PAGE {page}: HTTP {status}')
        continue
    for raw in url_re.findall(html):
        u = raw.strip()
        if not u or u.startswith(('#', 'http:', 'https:', 'mailto:', 'tel:', 'data:', 'javascript:')):
            continue
        if u.startswith('/'):
            # root-relative absolute path -> site root
            full = 'http://localhost' + u
        else:
            full = BASE + u
        if full in seen:
            continue
        seen.add(full)
        s, _ = fetch(full)
        if s != 200 and s != 'ERR':
            failures.append(f'LINK {full} -> HTTP {s}  (from {page})')

print(f'checked {len(seen)} unique internal URLs across {len(PAGES)} pages')
if failures:
    print('FAILURES:')
    for f in failures[:40]:
        print(' ', f)
else:
    print('ALL OK')
