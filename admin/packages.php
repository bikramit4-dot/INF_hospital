<?php
require_once __DIR__ . '/../includes/config.php';
require_admin();

use App\Core\View;
use App\Models\HealthPackage;

$page_title = 'Manage Health Packages';

$message = '';
$edit_item = null;
$edit_id = (int) ($_GET['edit'] ?? 0);
if ($edit_id > 0) {
    $edit_item = HealthPackage::find($edit_id);
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
            HealthPackage::delete($id);
            $message = '<div class="alert alert-success alert-dismissible">Package deleted successfully.</div>';
        } else {
            $name = trim($_POST['name'] ?? '');
            $price = trim($_POST['price'] ?? '');
            $includes = trim($_POST['includes_text'] ?? '');
            $is_active = isset($_POST['is_active']) && (int) $_POST['is_active'] === 1 ? 1 : 0;

            if ($name === '' || $price === '' || $includes === '') {
                throw new Exception('Name, price, and includes are required.');
            }

            $data = [
                'name' => $name,
                'price' => $price,
                'includes_text' => $includes,
                'is_active' => $is_active,
            ];

            if ($action === 'update' && $id) {
                HealthPackage::update($id, $data);
                $edit_item = null;
                $message = '<div class="alert alert-success alert-dismissible">Package updated successfully.</div>';
            } else {
                HealthPackage::create($data);
                $message = '<div class="alert alert-success alert-dismissible">Package added successfully.</div>';
            }
        }
    } catch (Exception $e) {
        $message = '<div class="alert alert-error">' . e($e->getMessage()) . '</div>';
    }
}

$items = HealthPackage::all('id');
$csrf_token = csrf_token();

View::renderAdmin('admin/crud', [
    'page_title' => $page_title,
    'message' => $message,
    'csrf_token' => $csrf_token,
    'active' => 'packages',
    'heading' => 'Manage Health Packages',
    'subtitle' => 'Health checkup packages shown to visitors — add, edit, or remove them here.',
    'form_title' => 'Add Package',
    'form_title_edit' => 'Edit Package',
    'submit_text' => 'Save Package',
    'submit_edit_text' => 'Update Package',
    'list_title' => 'Existing Packages',
    'item_label' => 'package',
    'edit_item' => $edit_item,
    'fields' => [
        ['name' => 'name', 'label' => 'Package Name', 'type' => 'text'],
        ['name' => 'price', 'label' => 'Price', 'type' => 'text', 'hint' => 'e.g. NPR 2,500'],
        ['name' => 'includes_text', 'label' => 'Includes', 'type' => 'textarea', 'rows' => 4],
        ['name' => 'is_active', 'label' => 'Status', 'type' => 'select', 'options' => [1 => 'Active (visible)', 0 => 'Inactive (hidden)'], 'default' => 1],
    ],
    'columns' => [
        ['key' => 'name', 'label' => 'Name'],
        ['key' => 'price', 'label' => 'Price'],
        ['key' => 'includes_text', 'label' => 'Includes', 'truncate' => 55],
        ['key' => 'is_active', 'label' => 'Status', 'badge_map' => [1 => 'active', 0 => 'inactive'], 'label_map' => [1 => 'Active', 0 => 'Inactive']],
    ],
    'items' => $items,
]);
