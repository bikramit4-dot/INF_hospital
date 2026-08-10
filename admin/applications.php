<?php
require_once __DIR__ . '/../includes/config.php';
require_admin();

use App\Core\View;
use App\Models\CareerApplication;

$page_title = 'Job Applications';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        verify_csrf_token($_POST['csrf_token'] ?? '');
        $id = (int) ($_POST['id'] ?? 0);
        $action = (string) ($_POST['action'] ?? '');

        if (!$id || !in_array($action, ['reviewed', 'delete'], true)) {
            throw new Exception('Invalid request.');
        }

        if ($action === 'delete') {
            CareerApplication::delete($id);
            $message = '<div class="alert alert-success alert-dismissible">Application deleted.</div>';
        } else {
            CareerApplication::update($id, ['status' => 'reviewed']);
            $message = '<div class="alert alert-success alert-dismissible">Application marked as reviewed.</div>';
        }
    } catch (Exception $e) {
        $message = '<div class="alert alert-error">' . e($e->getMessage()) . '</div>';
    }
}

$q = trim((string) ($_GET['q'] ?? ''));
$page = max(1, (int) ($_GET['page'] ?? 1));
$result = CareerApplication::paginateSearch($q, $page, 15);
$items = $result['items'];
$pagination = $result;
$csrf_token = csrf_token();

View::renderAdmin('admin/records', [
    'page_title' => $page_title,
    'active' => 'applications',
    'message' => $message,
    'heading' => 'Job Applications',
    'subtitle' => 'Applications submitted through the careers page.',
    'list_title' => 'All Applications',
    'searchable' => true,
    'q' => $q,
    'search_placeholder' => 'Search name, position, email…',
    'badge_field' => 'status',
    'badge_map' => [
        'pending' => 'pending',
        'reviewed' => 'reviewed',
    ],
    'empty_icon' => 'briefcase',
    'empty_text' => 'No job applications yet.',
    'columns' => [
        ['key' => 'full_name', 'label' => 'Name'],
        ['key' => 'position', 'label' => 'Position'],
        ['key' => 'email', 'label' => 'Email'],
        ['key' => 'phone', 'label' => 'Phone'],
        ['key' => 'cover_letter', 'label' => 'Cover Letter', 'truncate' => 50],
        ['key' => 'status', 'label' => 'Status'],
        ['key' => 'created_at', 'label' => 'Applied'],
    ],
    'actions' => [
        ['value' => 'reviewed', 'label' => 'Mark reviewed', 'hide_when' => ['reviewed'], 'class' => 'btn-ghost', 'confirm' => 'Mark this application as reviewed?'],
    ],
    'allow_delete' => true,
    'csrf_token' => $csrf_token,
    'items' => $items,
    'pagination' => $pagination,
]);
