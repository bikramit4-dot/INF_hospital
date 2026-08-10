<?php
require_once __DIR__ . '/../includes/config.php';
require_admin();

use App\Core\View;
use App\Models\PageContent;

$page_title = 'Edit Pages';

$registry = require __DIR__ . '/../includes/page-content-registry.php';
$content_pages = $registry['pages'];

$page_keys = array_keys($content_pages);
$current = (string) ($_GET['page'] ?? 'home');
if (!in_array($current, $page_keys, true)) {
    $current = 'home';
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        verify_csrf_token($_POST['csrf_token'] ?? '');
        $target = (string) ($_POST['page'] ?? $current);
        if (!isset($content_pages[$target])) {
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
            $message = '<div class="alert alert-success alert-dismissible">Field reset to its default value.</div>';
        } else {
            // Save every field of the current page, skipping unchanged values
            // so the table only grows when content actually changes.
            $stored = PageContent::allForPage($target);
            $saved = 0;
            foreach ($content_pages[$target]['groups'] as $fields) {
                foreach ($fields as $f) {
                    $section = $f['section'];
                    $value = trim((string) ($_POST['c_' . $section] ?? ''));
                    if ($value !== ($stored[$section] ?? '')) {
                        PageContent::upsert($target, $section, $value);
                        $saved++;
                    }
                }
            }
            PageContent::pruneEmpty($target);
            $message = '<div class="alert alert-success alert-dismissible">' . $saved . ' field(s) saved. Changes are live on the website.</div>';
        }
    } catch (Exception $e) {
        $message = '<div class="alert alert-error">' . e($e->getMessage()) . '</div>';
    }
}

// Build the form data for the current page: resolved values (custom or default)
// plus a flag telling the UI whether the field has been customized.
// A single query loads every row for the page, so large editors stay fast.
$custom_rows = PageContent::allForPage($current);
$defaults = $registry['defaults'];

$page_data = [];
$field_count = 0;
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
        $field_count++;
    }
    $page_data[$group_name] = $rows;
}

$csrf_token = csrf_token();

View::renderAdmin('admin/pages', [
    'page_title' => $page_title,
    'message' => $message,
    'csrf_token' => $csrf_token,
    'active' => 'pages',
    'content_pages' => $content_pages,
    'current' => $current,
    'page_data' => $page_data,
    'field_count' => $field_count,
]);
