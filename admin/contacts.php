<?php
require_once __DIR__ . '/../includes/config.php';
require_admin();

use App\Core\View;
use App\Models\Contact;

$page_title = 'Contact Messages';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        verify_csrf_token($_POST['csrf_token'] ?? '');
        $id = (int) ($_POST['id'] ?? 0);
        $action = (string) ($_POST['action'] ?? '');

        if (!$id || !in_array($action, ['read', 'delete'], true)) {
            throw new Exception('Invalid request.');
        }

        if ($action === 'delete') {
            Contact::delete($id);
            $message = '<div class="alert alert-success alert-dismissible">Message deleted.</div>';
        } else {
            Contact::update($id, ['is_read' => 1]);
            $message = '<div class="alert alert-success alert-dismissible">Message marked as read.</div>';
        }
    } catch (Exception $e) {
        $message = '<div class="alert alert-error">' . e($e->getMessage()) . '</div>';
    }
}

$q = trim((string) ($_GET['q'] ?? ''));
$page = max(1, (int) ($_GET['page'] ?? 1));
$result = Contact::paginateSearch($q, $page, 15);
$items = $result['items'];
$pagination = $result;
$csrf_token = csrf_token();

View::renderAdmin('admin/records', [
    'page_title' => $page_title,
    'active' => 'contacts',
    'message' => $message,
    'heading' => 'Contact Messages',
    'subtitle' => 'Messages submitted through the website contact form.',
    'list_title' => 'All Messages',
    'searchable' => true,
    'q' => $q,
    'search_placeholder' => 'Search name, email, subject…',
    'badge_field' => 'is_read',
    'badge_map' => [
        0 => 'unread',
        1 => 'read',
    ],
    'empty_icon' => 'mail',
    'empty_text' => 'No contact messages yet.',
    'columns' => [
        ['key' => 'name', 'label' => 'Name'],
        ['key' => 'email', 'label' => 'Email'],
        ['key' => 'subject', 'label' => 'Subject'],
        ['key' => 'message', 'label' => 'Message', 'truncate' => 60],
        ['key' => 'is_read', 'label' => 'Status'],
        ['key' => 'created_at', 'label' => 'Received'],
    ],
    'actions' => [
        ['value' => 'read', 'label' => 'Mark read', 'hide_when' => [1], 'class' => 'btn-ghost', 'confirm' => 'Mark this message as read?'],
    ],
    'allow_delete' => true,
    'csrf_token' => $csrf_token,
    'items' => $items,
    'pagination' => $pagination,
]);
