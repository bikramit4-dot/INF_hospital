<?php
require_once __DIR__ . '/../includes/config.php';
require_admin();

use App\Core\View;
use App\Models\Department;

$page_title = 'Manage Departments';

$message = '';
$edit_item = null;
$edit_id = (int) ($_GET['edit'] ?? 0);
if ($edit_id > 0) {
    $edit_item = Department::find($edit_id);
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
            $old = Department::find($id);
            if (!empty($old['image_url']) && str_starts_with($old['image_url'], 'uploads/departments/')) {
                @unlink(dirname(__DIR__) . '/' . $old['image_url']);
            }
            Department::delete($id);
            $message = '<div class="alert alert-success alert-dismissible">Department deleted successfully.</div>';
        } else {
            $name = trim($_POST['name'] ?? '');
            $desc = trim($_POST['desc'] ?? '');
            if ($name === '' || $desc === '') {
                throw new Exception('Both name and description are required.');
            }

            $data = ['name' => $name, 'description' => $desc];

            // Optional image upload (replaces the current image when editing)
            $new_image = null;
            if (!empty($_FILES['image']['name'])) {
                if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
                    throw new Exception('Image upload failed. Please try again.');
                }
                $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif'], true)) {
                    throw new Exception('Image must be a JPG, PNG, WebP or GIF file.');
                }
                if ((int) $_FILES['image']['size'] > 2 * 1024 * 1024) {
                    throw new Exception('Image must be 2MB or smaller.');
                }
                if (@getimagesize($_FILES['image']['tmp_name']) === false) {
                    throw new Exception('The uploaded file is not a valid image.');
                }
                $dir = dirname(__DIR__) . '/uploads/departments';
                if (!is_dir($dir) && !mkdir($dir, 0777, true) && !is_dir($dir)) {
                    throw new Exception('Could not create the uploads directory.');
                }
                $filename = 'dept_' . bin2hex(random_bytes(8)) . '.' . $ext;
                if (!move_uploaded_file($_FILES['image']['tmp_name'], $dir . '/' . $filename)) {
                    throw new Exception('Could not save the uploaded image.');
                }
                $new_image = 'uploads/departments/' . $filename;
            }

            if ($action === 'update' && $id) {
                if (!empty($_POST['remove_image'])) {
                    $old = Department::find($id);
                    if (!empty($old['image_url']) && str_starts_with($old['image_url'], 'uploads/departments/')) {
                        @unlink(dirname(__DIR__) . '/' . $old['image_url']);
                    }
                    $data['image_url'] = null;
                } elseif ($new_image !== null) {
                    $old = Department::find($id);
                    if (!empty($old['image_url']) && str_starts_with($old['image_url'], 'uploads/departments/')) {
                        @unlink(dirname(__DIR__) . '/' . $old['image_url']);
                    }
                    $data['image_url'] = $new_image;
                }
                Department::update($id, $data);
                $edit_item = null;
                $message = '<div class="alert alert-success alert-dismissible">Department updated successfully.</div>';
            } else {
                if ($new_image !== null) {
                    $data['image_url'] = $new_image;
                }
                Department::create($data);
                $message = '<div class="alert alert-success alert-dismissible">Department added successfully.</div>';
            }
        }
    } catch (Exception $e) {
        $message = '<div class="alert alert-error">' . e($e->getMessage()) . '</div>';
    }
}

$items = Department::all('id');
$csrf_token = csrf_token();

View::renderAdmin('admin/crud', [
    'page_title' => $page_title,
    'message' => $message,
    'csrf_token' => $csrf_token,
    'active' => 'departments',
    'heading' => 'Manage Departments',
    'subtitle' => 'Departments appear across the website — add, edit, or remove them here.',
    'form_title' => 'Add Department',
    'form_title_edit' => 'Edit Department',
    'submit_text' => 'Save Department',
    'submit_edit_text' => 'Update Department',
    'list_title' => 'Existing Departments',
    'item_label' => 'department',
    'edit_item' => $edit_item,
    'fields' => array_merge(
        $edit_item && !empty($edit_item['image_url'])
            ? [['name' => 'remove_image', 'label' => 'Remove current image', 'type' => 'checkbox']]
            : [],
        [
        ['name' => 'name', 'label' => 'Department Name', 'type' => 'text'],
        ['name' => 'desc', 'col' => 'description', 'label' => 'Description', 'type' => 'textarea', 'rows' => 4],
        ['name' => 'image', 'label' => 'Image', 'type' => 'file', 'optional' => true, 'col' => 'image_url', 'accept' => 'image/*', 'hint' => 'JPG, PNG, WebP or GIF — max 2MB. Leave empty to keep the current image.'],
        ]
    ),
    'columns' => [
        ['key' => 'image_url', 'label' => 'Image', 'type' => 'image'],
        ['key' => 'name', 'label' => 'Name'],
        ['key' => 'description', 'label' => 'Description', 'truncate' => 70],
    ],
    'items' => $items,
]);
