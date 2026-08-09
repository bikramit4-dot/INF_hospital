<?php
require_once __DIR__ . '/../includes/config.php';
require_admin();

use App\Core\View;
use App\Models\LabReport;

$page_title = 'Manage Lab Reports';

$message = '';
$edit_item = null;
$edit_id = (int) ($_GET['edit'] ?? 0);
if ($edit_id > 0) {
    $edit_item = LabReport::find($edit_id);
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
            LabReport::delete($id);
            $message = '<div class="alert alert-success alert-dismissible">Lab report deleted.</div>';
        } else {
            $report_id = trim($_POST['report_id'] ?? '');
            $patient_name = trim($_POST['patient_name'] ?? '');
            $patient_phone = trim($_POST['patient_phone'] ?? '');
            $test_name = trim($_POST['test_name'] ?? '');
            $report_date = trim($_POST['report_date'] ?? '');
            $status = trim($_POST['status'] ?? 'pending');
            $notes = trim($_POST['notes'] ?? '');

            if ($report_id === '' || $patient_name === '' || $patient_phone === '' || $test_name === '' || $report_date === '') {
                throw new Exception('Report ID, patient name, phone, test name, and date are required.');
            }
            if (!in_array($status, ['pending', 'verified', 'rejected'], true)) {
                $status = 'pending';
            }

            $data = [
                'report_id' => $report_id,
                'patient_name' => $patient_name,
                'patient_phone' => $patient_phone,
                'test_name' => $test_name,
                'report_date' => $report_date,
                'status' => $status,
                'notes' => $notes,
            ];

            if ($action === 'update' && $id) {
                $dup = LabReport::firstWhere('report_id = :rid AND id != :id', [':rid' => $report_id, ':id' => $id]);
                if ($dup) {
                    throw new Exception('Another report already uses this Report ID.');
                }
                LabReport::update($id, $data);
                $edit_item = null;
                $message = '<div class="alert alert-success alert-dismissible">Lab report updated successfully.</div>';
            } else {
                if (LabReport::findByReportId($report_id)) {
                    throw new Exception('A report with this Report ID already exists.');
                }
                LabReport::create($data);
                $message = '<div class="alert alert-success alert-dismissible">Lab report added successfully.</div>';
            }
        }
    } catch (Exception $e) {
        $message = '<div class="alert alert-error">' . e($e->getMessage()) . '</div>';
    }
}

$items = LabReport::all('report_date DESC, id DESC');
$csrf_token = csrf_token();

View::renderAdmin('admin/crud', [
    'page_title' => $page_title,
    'message' => $message,
    'csrf_token' => $csrf_token,
    'active' => 'lab-reports',
    'heading' => 'Manage Lab Reports',
    'subtitle' => 'Reports patients look up on the Lab Report page. Add results for each report after creating it.',
    'form_title' => 'Add Lab Report',
    'form_title_edit' => 'Edit Lab Report',
    'submit_text' => 'Save Report',
    'submit_edit_text' => 'Update Report',
    'list_title' => 'All Lab Reports',
    'item_label' => 'lab report',
    'edit_item' => $edit_item,
    'row_links' => [
        ['label' => 'Results', 'href' => 'lab-report-results.php?id=%d'],
    ],
    'fields' => [
        ['name' => 'report_id', 'label' => 'Report ID', 'type' => 'text', 'hint' => 'Unique ID patients use to look up the report, e.g. HH-LAB-1001'],
        ['name' => 'patient_name', 'label' => 'Patient Name', 'type' => 'text'],
        ['name' => 'patient_phone', 'label' => 'Patient Phone', 'type' => 'text'],
        ['name' => 'test_name', 'label' => 'Test Name', 'type' => 'text'],
        ['name' => 'report_date', 'label' => 'Report Date', 'type' => 'date'],
        ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => ['pending' => 'Pending', 'verified' => 'Verified', 'rejected' => 'Rejected'], 'default' => 'pending'],
        ['name' => 'notes', 'label' => 'Notes (optional)', 'type' => 'textarea', 'rows' => 3, 'optional' => true],
    ],
    'columns' => [
        ['key' => 'report_id', 'label' => 'Report ID'],
        ['key' => 'patient_name', 'label' => 'Patient'],
        ['key' => 'test_name', 'label' => 'Test'],
        ['key' => 'report_date', 'label' => 'Date'],
        ['key' => 'status', 'label' => 'Status', 'badge_map' => ['pending' => 'pending', 'Verified' => 'confirmed', 'verified' => 'confirmed', 'Rejected' => 'cancelled', 'rejected' => 'cancelled'], 'label_map' => ['pending' => 'Pending', 'Verified' => 'Verified', 'verified' => 'Verified', 'Rejected' => 'Rejected', 'rejected' => 'Rejected']],
    ],
    'items' => $items,
]);
