<?php
require_once __DIR__ . '/../includes/config.php';
require_admin();

use App\Core\View;
use App\Models\NewsEvent;

$page_title = 'Manage News & Events';

$message = '';
$edit_item = null;
$edit_id = (int) ($_GET['edit'] ?? 0);
if ($edit_id > 0) {
    $edit_item = NewsEvent::find($edit_id);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        verify_csrf_token($_POST['csrf_token'] ?? '');
        $action = (string) ($_POST['action'] ?? 'create');
        $id = (int) ($_POST['id'] ?? 0);

        if ($action === 'delete') {
            if (!$id) {
                throw new Exception('Invalid record id.');
            }
            NewsEvent::delete($id);
            $message = '<div class="alert alert-success alert-dismissible">News item deleted successfully.</div>';
        } else {
            $title = trim($_POST['title'] ?? '');
            $date = trim($_POST['event_date'] ?? '');
            $category = trim($_POST['category'] ?? '');
            $excerpt = trim($_POST['excerpt'] ?? '');
            $content = trim($_POST['content'] ?? '');
            $is_published = isset($_POST['is_published']) && (int) $_POST['is_published'] === 1 ? 1 : 0;

            if ($title === '' || $date === '' || $category === '' || $excerpt === '') {
                throw new Exception('Title, date, category, and excerpt are required.');
            }

            $data = [
                'title' => $title,
                'event_date' => $date,
                'category' => $category,
                'excerpt' => $excerpt,
                'content' => $content,
                'is_published' => $is_published,
            ];

            if ($action === 'update' && $id) {
                NewsEvent::update($id, $data);
                $edit_item = null;
                $message = '<div class="alert alert-success alert-dismissible">News item updated successfully.</div>';
            } else {
                NewsEvent::create($data);
                $message = '<div class="alert alert-success alert-dismissible">News item added successfully.</div>';
            }
        }
    } catch (Exception $e) {
        $message = '<div class="alert alert-error">' . e($e->getMessage()) . '</div>';
    }
}

$items = NewsEvent::all('event_date DESC, id DESC');
$csrf_token = csrf_token();

View::renderAdmin('admin/crud', [
    'page_title' => $page_title,
    'message' => $message,
    'csrf_token' => $csrf_token,
    'active' => 'news',
    'heading' => 'Manage News & Events',
    'subtitle' => 'News and events shown on the site — add, edit, publish, or remove them here.',
    'form_title' => 'Add News Item',
    'form_title_edit' => 'Edit News Item',
    'submit_text' => 'Save News',
    'submit_edit_text' => 'Update News',
    'list_title' => 'Existing News',
    'item_label' => 'news item',
    'edit_item' => $edit_item,
    'fields' => [
        ['name' => 'title', 'label' => 'Title', 'type' => 'text'],
        ['name' => 'event_date', 'label' => 'Date', 'type' => 'date'],
        ['name' => 'category', 'label' => 'Category', 'type' => 'text'],
        ['name' => 'excerpt', 'label' => 'Excerpt', 'type' => 'textarea', 'rows' => 3],
        ['name' => 'content', 'label' => 'Full Content (optional)', 'type' => 'textarea', 'rows' => 5, 'optional' => true],
        ['name' => 'is_published', 'label' => 'Status', 'type' => 'select', 'options' => [1 => 'Published (visible)', 0 => 'Draft (hidden)'], 'default' => 1],
    ],
    'columns' => [
        ['key' => 'title', 'label' => 'Title'],
        ['key' => 'event_date', 'label' => 'Date'],
        ['key' => 'category', 'label' => 'Category'],
        ['key' => 'excerpt', 'label' => 'Excerpt', 'truncate' => 55],
        ['key' => 'is_published', 'label' => 'Status', 'badge_map' => [1 => 'active', 0 => 'inactive'], 'label_map' => [1 => 'Published', 0 => 'Draft']],
    ],
    'items' => $items,
]);
