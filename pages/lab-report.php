<?php
require_once __DIR__ . '/../includes/config.php';

use App\Core\View;
use App\Models\LabReport;

$page_title = "Lab Report";

$lookup_result = null;
$lookup_error = '';
$recent_reports = LabReport::all('report_date DESC');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['lookup_submit'])) {
    try {
        verify_csrf_token($_POST['csrf_token'] ?? '');
    } catch (Exception $e) {
        $lookup_error = $e->getMessage();
    }

    $report_id = strtoupper(trim($_POST['report_id'] ?? ''));
    $phone = trim($_POST['phone'] ?? '');

    if ($lookup_error === '' && rate_limited('lab_lookup', 10, 600)) {
        $lookup_error = "Too many report lookups. Please try again later.";
    }

    if ($lookup_error === '') {
        if ($report_id === '' || $phone === '') {
            $lookup_error = "Please enter both Report ID and registered phone number.";
        } elseif (!preg_match('/^[A-Z0-9-]{4,40}$/', $report_id)) {
            $lookup_error = "Please enter a valid Report ID.";
        } elseif (!preg_match('/^[0-9+\-\s]{7,20}$/', $phone)) {
            $lookup_error = "Please enter a valid phone number.";
        } else {
            $lookup_result = LabReport::lookup($report_id, $phone);
            if (!$lookup_result) {
                $lookup_error = "No matching report found. Please check your Report ID and phone number.";
            }
        }
    }
}

$csrf_token = csrf_token();
View::render('pages/lab-report', compact(
    'page_title', 'lookup_result', 'lookup_error', 'recent_reports', 'csrf_token', 'nav_menu'
));