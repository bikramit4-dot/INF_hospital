#!/usr/bin/env python3
"""Prefix 'pages/' onto every internal page link (files now live in /pages/)."""
import re
import glob
import os

FILES = (
    glob.glob('app/Views/pages/*.php')
    + ['app/Views/layouts/main-header.php', 'app/Views/layouts/main-footer.php']
    + ['includes/header.php', 'includes/footer.php']
)

# site_url('X.php...') -> site_url('pages/X.php...')  (literal page links)
lit_re = re.compile(r"site_url\('([^']*\.php[^']*)'")
def lit_sub(m):
    return "site_url('pages/{0}')".format(m.group(1))

# dynamic nav links
dyn = [
    ("site_url($item['link'])", "site_url('pages/' . $item['link'])"),
    ("site_url($clink)", "site_url('pages/' . $clink)"),
]

for f in FILES:
    if not os.path.exists(f):
        continue
    s = open(f, encoding='utf-8').read()
    orig = s
    s = lit_re.sub(lit_sub, s)
    for old, new in dyn:
        s = s.replace(old, new)
    if s != orig:
        open(f, 'w', encoding='utf-8').write(s)
        print('updated', f)
print('done')
