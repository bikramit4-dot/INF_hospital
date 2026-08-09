<?php
require_once __DIR__ . '/../includes/config.php';

use App\Core\View;
use App\Models\CareerApplication;

$page_title = "Careers";

$success = false;
$errors = [];
$openings = [
    ['title' => 'Staff Nurse (ICU)', 'dept' => 'Nursing', 'type' => 'Full-time'],
    ['title' => 'Radiology Technician', 'dept' => 'Radiology', 'type' => 'Full-time'],
    ['title' => 'Consultant Cardiologist', 'dept' => 'Cardiology', 'type' => 'Full-time'],
    ['title' => 'Lab Technician', 'dept' => 'Laboratory', 'type' => 'Full-time'],
    ['title' => 'Front Desk Receptionist', 'dept' => 'Administration', 'type' => 'Full-time'],
    ['title' => 'Pharmacist', 'dept' => 'Pharmacy', 'type' => 'Full-time'],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['apply_submit'])) {
    try {
        verify_csrf_token($_POST['csrf_token'] ?? '');
    } catch (Exception $e) {
        $errors[] = $e->getMessage();
    }

    $name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $position = trim($_POST['position'] ?? '');
    $cover_letter = trim($_POST['cover_letter'] ?? '');

    if (!$errors) {
        if ($name === '' || $email === '' || $position === '') {
            $errors[] = "Please fill in all required fields.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Please enter a valid email address.";
        } else {
            CareerApplication::create([
                'full_name' => $name,
                'email' => $email,
                'phone' => $phone,
                'position' => $position,
                'cover_letter' => $cover_letter,
                'status' => 'pending',
            ]);
            $success = true;
        }
    }
}

$csrf_token = csrf_token();
View::render('pages/careers', compact('page_title', 'success', 'errors', 'openings', 'csrf_token', 'nav_menu'));