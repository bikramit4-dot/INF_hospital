<?php
require_once __DIR__ . '/../includes/config.php';

use App\Core\View;
use App\Models\OnlineConsultation;
use App\Models\Department;

$page_title = "Online Consultation";

$success = false;
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['consult_submit'])) {
    try {
        verify_csrf_token($_POST['csrf_token'] ?? '');
    } catch (Exception $e) {
        $errors[] = $e->getMessage();
    }

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $dept_id = (int)trim($_POST['department'] ?? '');
    $issue = trim($_POST['issue'] ?? '');

    if (!$errors) {
        if ($name === '' || $email === '' || $dept_id === 0 || $issue === '') {
            $errors[] = "Please fill in all required fields.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Please enter a valid email address.";
        } else {
            OnlineConsultation::create([
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'department_id' => $dept_id,
                'issue' => $issue,
                'status' => 'pending',
            ]);
            $success = true;
        }
    }
}

$departments = Department::all('id');
$csrf_token = csrf_token();
View::render('pages/online-consultation', compact('page_title', 'success', 'errors', 'departments', 'csrf_token', 'nav_menu'));