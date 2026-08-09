<?php
require_once __DIR__ . '/../includes/config.php';
require_admin();

use App\Core\View;
use App\Models\Department;
use App\Models\Doctor;

$page_title = 'Manage Doctors';

$message = '';
$edit_item = null;
$edit_id = (int) ($_GET['edit'] ?? 0);
if ($edit_id > 0) {
    $edit_item = Doctor::find($edit_id);
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
            $old = Doctor::find($id);
            if (!empty($old['photo_url']) && str_starts_with($old['photo_url'], 'uploads/doctors/')) {
                @unlink(dirname(__DIR__) . '/' . $old['photo_url']);
            }
            Doctor::delete($id);
            $message = '<div class="alert alert-success alert-dismissible">Doctor deleted successfully.</div>';
        } else {
            $name = trim($_POST['name'] ?? '');
            $dept_id = (int) trim($_POST['department_id'] ?? '');
            $specialty = trim($_POST['specialty'] ?? '');
            $exp = trim($_POST['experience'] ?? '');
            $days = trim($_POST['days'] ?? '');
            $time = trim($_POST['time_slot'] ?? '');

            if ($name === '' || $dept_id === 0 || $specialty === '' || $exp === '' || $days === '' || $time === '') {
                throw new Exception('All doctor fields are required.');
            }
            if (!Department::find($dept_id)) {
                throw new Exception('The selected department does not exist.');
            }

            $data = [
                'name' => $name,
                'department_id' => $dept_id,
                'specialty' => $specialty,
                'experience' => $exp,
                'days' => $days,
                'time_slot' => $time,
            ];

            // Optional photo upload (replaces the current photo when editing)
            $new_photo = null;
            if (!empty($_FILES['photo']['name'])) {
                if ($_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
                    throw new Exception('Photo upload failed. Please try again.');
                }
                $ext = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
                if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif'], true)) {
                    throw new Exception('Photo must be a JPG, PNG, WebP or GIF image.');
                }
                if ((int) $_FILES['photo']['size'] > 2 * 1024 * 1024) {
                    throw new Exception('Photo must be 2MB or smaller.');
                }
                if (@getimagesize($_FILES['photo']['tmp_name']) === false) {
                    throw new Exception('The uploaded file is not a valid image.');
                }
                $dir = dirname(__DIR__) . '/uploads/doctors';
                if (!is_dir($dir) && !mkdir($dir, 0777, true) && !is_dir($dir)) {
                    throw new Exception('Could not create the uploads directory.');
                }
                $filename = 'doc_' . bin2hex(random_bytes(8)) . '.' . $ext;
                if (!move_uploaded_file($_FILES['photo']['tmp_name'], $dir . '/' . $filename)) {
                    throw new Exception('Could not save the uploaded photo.');
                }
                $new_photo = 'uploads/doctors/' . $filename;
            }

            if ($action === 'update' && $id) {
                if (!empty($_POST['remove_photo'])) {
                    $old = Doctor::find($id);
                    if (!empty($old['photo_url']) && str_starts_with($old['photo_url'], 'uploads/doctors/')) {
                        @unlink(dirname(__DIR__) . '/' . $old['photo_url']);
                    }
                    $data['photo_url'] = null;
                } elseif ($new_photo !== null) {
                    $old = Doctor::find($id);
                    if (!empty($old['photo_url']) && str_starts_with($old['photo_url'], 'uploads/doctors/')) {
                        @unlink(dirname(__DIR__) . '/' . $old['photo_url']);
                    }
                    $data['photo_url'] = $new_photo;
                }
                Doctor::update($id, $data);
                $edit_item = null;
                $message = '<div class="alert alert-success alert-dismissible">Doctor updated successfully.</div>';
            } else {
                if ($new_photo !== null) {
                    $data['photo_url'] = $new_photo;
                }
                Doctor::create($data);
                $message = '<div class="alert alert-success alert-dismissible">Doctor added successfully.</div>';
            }
        }
    } catch (Exception $e) {
        $message = '<div class="alert alert-error">' . e($e->getMessage()) . '</div>';
    }
}

$items = Doctor::allWithDepartment();
$departments = Department::all('name');
$department_options = ['' => '— Select a department —'];
foreach ($departments as $dept) {
    $department_options[$dept['id']] = $dept['name'];
}
$csrf_token = csrf_token();

View::renderAdmin('admin/crud', [
    'page_title' => $page_title,
    'message' => $message,
    'csrf_token' => $csrf_token,
    'active' => 'doctors',
    'heading' => 'Manage Doctors',
    'subtitle' => 'Doctors are listed on the site with their schedules — add, edit, or remove them here.',
    'form_title' => 'Add Doctor',
    'form_title_edit' => 'Edit Doctor',
    'submit_text' => 'Save Doctor',
    'submit_edit_text' => 'Update Doctor',
    'list_title' => 'Existing Doctors',
    'item_label' => 'doctor',
    'edit_item' => $edit_item,
    'fields' => array_merge(
        $edit_item && !empty($edit_item['photo_url'])
            ? [['name' => 'remove_photo', 'label' => 'Remove current photo', 'type' => 'checkbox']]
            : [],
        [
        ['name' => 'photo', 'label' => 'Photo', 'type' => 'file', 'optional' => true, 'col' => 'photo_url', 'accept' => 'image/*', 'hint' => 'JPG, PNG, WebP or GIF — max 2MB. Leave empty to keep the current photo.'],
        ['name' => 'name', 'label' => 'Doctor Name', 'type' => 'text'],
        ['name' => 'department_id', 'label' => 'Department', 'type' => 'select', 'options' => $department_options],
        ['name' => 'specialty', 'label' => 'Specialty', 'type' => 'text'],
        ['name' => 'experience', 'label' => 'Experience', 'type' => 'text'],
        ['name' => 'days', 'label' => 'Available Days', 'type' => 'text'],
        ['name' => 'time_slot', 'label' => 'Time Slot', 'type' => 'text'],
        ]
    ),
    'columns' => [
        ['key' => 'photo_url', 'label' => 'Photo', 'type' => 'image'],
        ['key' => 'name', 'label' => 'Name'],
        ['key' => 'department_name', 'label' => 'Department'],
        ['key' => 'specialty', 'label' => 'Specialty'],
        ['key' => 'experience', 'label' => 'Experience'],
        ['key' => 'days', 'label' => 'Days'],
        ['key' => 'time_slot', 'label' => 'Time'],
    ],
    'items' => $items,
]);
