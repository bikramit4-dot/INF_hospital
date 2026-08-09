<?php
require_once __DIR__ . '/includes/config.php';

use App\Core\View;
use App\Models\Contact;

$page_title = "Contact Us";

$success = false;
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contact_submit'])) {
    try {
        verify_csrf_token($_POST['csrf_token'] ?? '');
    } catch (Exception $e) {
        $errors[] = $e->getMessage();
    }

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (!$errors) {
        if ($name === '' || $email === '' || $message === '') {
            $errors[] = "Please fill in all required fields.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Please enter a valid email address.";
        } else {
            Contact::create([
                'name' => $name,
                'email' => $email,
                'subject' => $subject,
                'message' => $message,
            ]);
            $success = true;
        }
    }
}

$csrf_token = csrf_token();
View::render('pages/contact', compact('page_title', 'success', 'errors', 'csrf_token', 'nav_menu'));