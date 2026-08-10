<?php
require_once __DIR__ . '/../includes/config.php';
require_admin();

use App\Core\View;
use App\Models\PageContent;

$page_title = 'Edit Pages';
$active = 'pages';

$registry = require __DIR__ . '/../includes/page-content-registry.php';
$content_pages = $registry['pages'];
$defaults = $registry['defaults'];

// Which page's sections are we editing (if any)?
$current = (string) ($_GET['page'] ?? '');
if ($current !== '' && !isset($content_pages[$current])) {
    $current = '';
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        verify_csrf_token($_POST['csrf_token'] ?? '');
        $target = (string) ($_POST['page'] ?? '');
        if ($target === '' || !isset($content_pages[$target])) {
            throw new Exception('Unknown page.');
        }
        $current = $target;

        $reset_section = (string) ($_POST['reset_section'] ?? '');
        if ($reset_section !== '') {
            // Reset a single field back to its default.
            $found = false;
            foreach ($content_pages[$target]['groups'] as $fields) {
                foreach ($fields as $f) {
                    if ($f['section'] === $reset_section) {
                        $found = true;
                        break 2;
                    }
                }
            }
            if (!$found) {
                throw new Exception('Unknown field.');
            }
            PageContent::upsert($target, $reset_section, '');
            PageContent::pruneEmpty($target);
            $message = '<div class="alert alert-success alert-dismissible">Field reset to its default value.</div>';
        } else {
            // Save the fields of one section (group) of the page.
            $group_name = (string) ($_POST['group'] ?? '');
            $groups = $content_pages[$target]['groups'];
            if ($group_name === '' || !isset($groups[$group_name])) {
                throw new Exception('Unknown section.');
            }

            $stored = PageContent::allForPage($target);
            $saved = 0;
            foreach ($groups[$group_name] as $f) {
                $section = $f['section'];
                $value = trim((string) ($_POST['c_' . $section] ?? ''));
                if ($value !== ($stored[$section] ?? '')) {
                    PageContent::upsert($target, $section, $value);
                    $saved++;
                }
            }
            PageContent::pruneEmpty($target);
            $message = '<div class="alert alert-success alert-dismissible">' . $saved . ' field(s) saved. Changes are live on the website.</div>';
        }
    } catch (Exception $e) {
        $message = '<div class="alert alert-error">' . e($e->getMessage()) . '</div>';
    }
}

$csrf_token = csrf_token();

if ($current === '') {
    // ------------------------------------------------------------
    // GRID MODE — every public page as a card.
    // ------------------------------------------------------------
    $page_cards = [];
    foreach ($content_pages as $key => $pg) {
        $count = 0;
        foreach ($pg['groups'] as $fields) {
            $count += count($fields);
        }
        $page_cards[] = [
            'key' => $key,
            'label' => $pg['label'],
            'icon' => $pg['icon'],
            'url' => $pg['url'],
            'field_count' => $count,
        ];
    }

    View::renderAdmin('admin/pages', [
        'page_title' => $page_title,
        'message' => $message,
        'csrf_token' => $csrf_token,
        'active' => $active,
        'page_cards' => $page_cards,
    ]);
} else {
    // ------------------------------------------------------------
    // EDITOR MODE — the page's sections as editable cards.
    // One query loads every row for the page; defaults come from
    // the registry, so fields show their current live value.
    // ------------------------------------------------------------
    $custom_rows = PageContent::allForPage($current);

    $page_data = [];
    foreach ($content_pages[$current]['groups'] as $group_name => $fields) {
        $rows = [];
        foreach ($fields as $f) {
            $section = $f['section'];
            $raw = $custom_rows[$section] ?? '';
            $is_custom = $raw !== '';
            $rows[] = [
                'section' => $section,
                'label' => $f['label'],
                'type' => $f['type'] ?? 'text',
                'rows' => (int) ($f['rows'] ?? 4),
                'hint' => $f['hint'] ?? '',
                'value' => $is_custom ? $raw : ($defaults[$current . "\x1F" . $section] ?? ''),
                'is_custom' => $is_custom,
            ];
        }
        $page_data[$group_name] = $rows;
    }

    View::renderAdmin('admin/page', [
        'page_title' => $page_title . ' — ' . $content_pages[$current]['label'],
        'message' => $message,
        'csrf_token' => $csrf_token,
        'active' => $active,
        'content_pages' => $content_pages,
        'current' => $current,
        'page_data' => $page_data,
    ]);
}
