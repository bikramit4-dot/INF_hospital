#!/usr/bin/env python3
"""Convert relative internal links/assets to root-relative site_url() calls.

Prepares the app for moving public entry pages into a pages/ subfolder:
every internal href/src/action becomes root-relative via site_url(), so the
same view renders correctly from any URL depth.
"""
import re
import glob

FILES = (
    glob.glob('app/Views/pages/*.php')
    + ['app/Views/layouts/main-header.php', 'app/Views/layouts/main-footer.php']
    + ['includes/header.php', 'includes/footer.php']
)

def wrap(url):
    return "<?php echo e(site_url('{}')); ?>".format(url)

# Internal page links (skip any URL that embeds PHP - handled manually)
href_re = re.compile(r'href="([a-zA-Z0-9?=&._-]*\.php[^"]*)"')
def href_sub(m):
    url = m.group(1)
    if '<?' in url:
        return m.group(0)
    return 'href="{}"'.format(wrap(url))

# Form actions
action_re = re.compile(r'action="([a-zA-Z0-9?=&._#-]*\.php[^"]*)"')
def action_sub(m):
    url = m.group(1)
    if '<?' in url:
        return m.group(0)
    return 'action="{}"'.format(wrap(url))

# images / js / css assets
img_re = re.compile(r'src="(images/[^"]+)"')
js_re = re.compile(r'src="(js/[^"]+)"')
css_re = re.compile(r'href="(css/[^"]+)"')

NAV_OLD = "href=\"<?php echo e($item['link']); ?>\""
NAV_NEW = "href=\"<?php echo e(site_url($item['link'])); ?>\""

for f in FILES:
    if not __import__('os').path.exists(f):
        continue
    s = open(f, encoding='utf-8').read()
    orig = s
    s = href_re.sub(href_sub, s)
    s = action_re.sub(action_sub, s)
    s = img_re.sub(lambda m: 'src="{}"'.format(wrap(m.group(1))), s)
    s = js_re.sub(lambda m: 'src="{}"'.format(wrap(m.group(1))), s)
    s = css_re.sub(lambda m: 'href="{}"'.format(wrap(m.group(1))), s)
    s = s.replace(NAV_OLD, NAV_NEW)
    if s != orig:
        open(f, 'w', encoding='utf-8').write(s)
        print('updated', f)
print('done')
