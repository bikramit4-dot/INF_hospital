<?php
require_once __DIR__ . '/../includes/config.php';
require_admin();

use App\Core\View;
use App\Models\Appointment;

$page_title = 'Appointments';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        verify_csrf_token($_POST['csrf_token'] ?? '');
        $id = (int) ($_POST['id'] ?? 0);
        $action = (string) ($_POST['action'] ?? '');

        if (!$id || !in_array($action, ['confirmed', 'cancelled', 'delete'], true)) {
            throw new Exception('Invalid request.');
        }

        if ($action === 'delete') {
            Appointment::delete($id);
            $message = '<div class="alert alert-success alert-dismissible">Appointment deleted.</div>';
        } else {
            Appointment::update($id, ['status' => $action]);
            $message = '<div class="alert alert-success alert-dismissible">Appointment marked as ' . e($action) . '.</div>';
        }
    } catch (Exception $e) {
        $message = '<div class="alert alert-error">' . e($e->getMessage()) . '</div>';
    }
}

$q = trim((string) ($_GET['q'] ?? ''));
$page = max(1, (int) ($_GET['page'] ?? 1));
$result = Appointment::paginateSearch($q, $page, 15);
$items = $result['items'];
$pagination = $result;
$csrf_token = csrf_token();

View::renderAdmin('admin/records', [
    'page_title' => $page_title,
    'active' => 'appointments',
    'message' => $message,
    'heading' => 'Appointments',
    'subtitle' => 'Review and manage patient appointment requests.',
    'list_title' => 'All Appointment Requests',
    'searchable' => true,
    'q' => $q,
    'search_placeholder' => 'Search name, ref, phone…',
    'badge_field' => 'status',
    'badge_map' => [
        'pending' => 'pending',
        'confirmed' => 'confirmed',
        'cancelled' => 'cancelled',
    ],
    'empty_icon' => 'calendar',
    'empty_text' => 'No appointment requests yet.',
    'columns' => [
        ['key' => 'booking_ref', 'label' => 'Ref'],
        ['key' => 'patient_name', 'label' => 'Patient'],
        ['key' => 'department_name', 'label' => 'Department'],
        ['key' => 'doctor_name', 'label' => 'Doctor'],
        ['key' => 'appointment_date', 'label' => 'Date'],
        ['key' => 'appointment_time', 'label' => 'Time'],
        ['key' => 'status', 'label' => 'Status'],
        ['key' => 'created_at', 'label' => 'Submitted'],
    ],
    'actions' => [
        ['value' => 'confirmed', 'label' => 'Confirm', 'hide_when' => ['confirmed'], 'class' => 'btn-success', 'confirm' => 'Confirm this appointment?'],
        ['value' => 'cancelled', 'label' => 'Cancel', 'hide_when' => ['cancelled'], 'class' => 'btn-danger', 'confirm' => 'Cancel this appointment?'],
    ],
    'allow_delete' => true,
    'items' => $items,
    'pagination' => $pagination,
]);
