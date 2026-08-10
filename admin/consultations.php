<?php
require_once __DIR__ . '/../includes/config.php';
require_admin();

use App\Core\View;
use App\Models\OnlineConsultation;

$page_title = 'Online Consultations';
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
            OnlineConsultation::delete($id);
            $message = '<div class="alert alert-success alert-dismissible">Consultation deleted.</div>';
        } else {
            OnlineConsultation::update($id, ['status' => 'reviewed']);
            $message = '<div class="alert alert-success alert-dismissible">Consultation marked as reviewed.</div>';
        }
    } catch (Exception $e) {
        $message = '<div class="alert alert-error">' . e($e->getMessage()) . '</div>';
    }
}

$q = trim((string) ($_GET['q'] ?? ''));
$page = max(1, (int) ($_GET['page'] ?? 1));
$result = OnlineConsultation::paginateSearch($q, $page, 15);
$items = $result['items'];
$pagination = $result;
$csrf_token = csrf_token();

View::renderAdmin('admin/records', [
    'page_title' => $page_title,
    'active' => 'consultations',
    'message' => $message,
    'heading' => 'Online Consultations',
    'subtitle' => 'Video and phone consultation requests from patients.',
    'list_title' => 'All Consultation Requests',
    'searchable' => true,
    'q' => $q,
    'search_placeholder' => 'Search name, email, issue…',
    'badge_field' => 'status',
    'badge_map' => [
        'pending' => 'pending',
        'reviewed' => 'reviewed',
    ],
    'empty_icon' => 'video',
    'empty_text' => 'No consultation requests yet.',
    'columns' => [
        ['key' => 'name', 'label' => 'Patient'],
        ['key' => 'email', 'label' => 'Email'],
        ['key' => 'phone', 'label' => 'Phone'],
        ['key' => 'department_name', 'label' => 'Department'],
        ['key' => 'issue', 'label' => 'Issue', 'truncate' => 50],
        ['key' => 'status', 'label' => 'Status'],
        ['key' => 'created_at', 'label' => 'Submitted'],
    ],
    'actions' => [
        ['value' => 'reviewed', 'label' => 'Mark reviewed', 'hide_when' => ['reviewed'], 'class' => 'btn-ghost', 'confirm' => 'Mark this consultation as reviewed?'],
    ],
    'allow_delete' => true,
    'csrf_token' => $csrf_token,
    'items' => $items,
    'pagination' => $pagination,
]);
