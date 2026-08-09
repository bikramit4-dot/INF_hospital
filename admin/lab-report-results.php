<?php
require_once __DIR__ . '/../includes/config.php';
require_admin();

use App\Core\View;
use App\Models\LabReport;

$report_id = (int) ($_GET['id'] ?? 0);
$report = $report_id > 0 ? LabReport::find($report_id) : null;

if (!$report) {
    header('Location: lab-reports.php');
    exit;
}

$page_title = 'Results — ' . $report['report_id'];
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        verify_csrf_token($_POST['csrf_token'] ?? '');
        $action = (string) ($_POST['action'] ?? 'add');
        $result_id = (int) ($_POST['id'] ?? 0);

        if ($action === 'delete') {
            if (!$result_id) {
                throw new Exception('Invalid result id.');
            }
            if (!LabReport::deleteResult($report_id, $result_id)) {
                throw new Exception('Result not found for this report.');
            }
            $message = '<div class="alert alert-success alert-dismissible">Result removed.</div>';
        } else {
            $parameter_name = trim($_POST['parameter_name'] ?? '');
            $result_value = trim($_POST['result_value'] ?? '');
            $reference_range = trim($_POST['reference_range'] ?? '');
            if ($parameter_name === '' || $result_value === '') {
                throw new Exception('Parameter name and result value are required.');
            }
            LabReport::addResult($report_id, [
                'parameter_name' => $parameter_name,
                'result_value' => $result_value,
                'reference_range' => $reference_range,
                'is_abnormal' => !empty($_POST['is_abnormal']) ? 1 : 0,
                'sort_order' => (int) ($_POST['sort_order'] ?? 0),
            ]);
            $message = '<div class="alert alert-success alert-dismissible">Result added.</div>';
        }
    } catch (Exception $e) {
        $message = '<div class="alert alert-error">' . e($e->getMessage()) . '</div>';
    }
}

$items = LabReport::getResults($report_id);
$csrf_token = csrf_token();

View::renderAdmin('admin/lab-report-results', [
    'page_title' => $page_title,
    'active' => 'lab-reports',
    'message' => $message,
    'csrf_token' => $csrf_token,
    'report' => $report,
    'items' => $items,
]);
