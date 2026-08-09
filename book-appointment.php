<?php
require_once __DIR__ . '/includes/config.php';

use App\Core\View;
use App\Models\Appointment;
use App\Models\Department;
use App\Models\Doctor;

$page_title = "Book an Appointment";

$success = false;
$errors = [];
$booking_ref = '';
$preselect_doctor = (int)($_GET['doctor'] ?? 0);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book_submit'])) {
    try {
        verify_csrf_token($_POST['csrf_token'] ?? '');
    } catch (Exception $e) {
        $errors[] = $e->getMessage();
    }

    $department_id = (int)trim($_POST['department'] ?? '');
    $doctor_id = (int)trim($_POST['doctor'] ?? '');
    $date = trim($_POST['appointment_date'] ?? '');
    $time = trim($_POST['appointment_time'] ?? '');
    $name = trim($_POST['patient_name'] ?? '');
    $age = trim($_POST['age'] ?? '');
    $gender = trim($_POST['gender'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $reason = trim($_POST['reason'] ?? '');

    if (!$errors) {
        if ($department_id === 0 || $doctor_id === 0 || $date === '' || $time === '' || $name === '' || $phone === '') {
            $errors[] = "Please fill in all required fields marked with *.";
        } elseif ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Please enter a valid email address.";
        } else {
            $booking_ref = Appointment::generateBookingRef();
            Appointment::create([
                'booking_ref' => $booking_ref,
                'department_id' => $department_id,
                'doctor_id' => $doctor_id,
                'patient_name' => $name,
                'patient_age' => $age !== '' ? (int)$age : null,
                'patient_gender' => $gender,
                'patient_phone' => $phone,
                'patient_email' => $email,
                'appointment_date' => $date,
                'appointment_time' => $time,
                'reason' => $reason,
                'status' => 'pending',
            ]);
            $success = true;
        }
    }
}

$departments = Department::all('id');
$doctors = Doctor::allWithDepartment();
$csrf_token = csrf_token();

View::render('pages/book-appointment', compact(
    'page_title', 'success', 'errors', 'booking_ref', 'preselect_doctor',
    'departments', 'doctors', 'csrf_token', 'nav_menu'
));