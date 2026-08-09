<?php
require_once __DIR__ . '/../includes/config.php';
require_admin();

use App\Core\View;
use App\Models\TeamMember;

$page_title = 'Manage Team Members';

$message = '';
$edit_item = null;
$edit_id = (int) ($_GET['edit'] ?? 0);
if ($edit_id > 0) {
    $edit_item = TeamMember::find($edit_id);
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
            TeamMember::delete($id);
            $message = '<div class="alert alert-success alert-dismissible">Team member deleted successfully.</div>';
        } else {
            $name = trim($_POST['name'] ?? '');
            $role = trim($_POST['role'] ?? '');
            $photo_url = trim($_POST['photo_url'] ?? '');
            $bio = trim($_POST['bio'] ?? '');
            $sort_order = (int) ($_POST['sort_order'] ?? 0);
            $is_active = isset($_POST['is_active']) && (int) $_POST['is_active'] === 1 ? 1 : 0;

            if ($name === '' || $role === '') {
                throw new Exception('Name and role are required.');
            }

            $data = [
                'name' => $name,
                'role' => $role,
                'photo_url' => $photo_url,
                'bio' => $bio,
                'sort_order' => $sort_order,
                'is_active' => $is_active,
            ];

            if ($action === 'update' && $id) {
                TeamMember::update($id, $data);
                $edit_item = null;
                $message = '<div class="alert alert-success alert-dismissible">Team member updated successfully.</div>';
            } else {
                TeamMember::create($data);
                $message = '<div class="alert alert-success alert-dismissible">Team member added successfully.</div>';
            }
        }
    } catch (Exception $e) {
        $message = '<div class="alert alert-error">' . e($e->getMessage()) . '</div>';
    }
}

$items = TeamMember::all('sort_order, id');
$csrf_token = csrf_token();

View::renderAdmin('admin/crud', [
    'page_title' => $page_title,
    'message' => $message,
    'csrf_token' => $csrf_token,
    'active' => 'team-members',
    'heading' => 'Manage Team Members',
    'subtitle' => 'The leadership team shown on the Management Team page. Members are arranged by Sort Order — lower numbers appear first.',
    'form_title' => 'Add Team Member',
    'form_title_edit' => 'Edit Team Member',
    'submit_text' => 'Save Team Member',
    'submit_edit_text' => 'Update Team Member',
    'list_title' => 'Existing Team Members',
    'item_label' => 'team member',
    'edit_item' => $edit_item,
    'fields' => [
        ['name' => 'name', 'label' => 'Full Name', 'type' => 'text'],
        ['name' => 'role', 'label' => 'Role / Title', 'type' => 'text'],
        ['name' => 'photo_url', 'label' => 'Photo URL (optional)', 'type' => 'text', 'optional' => true],
        ['name' => 'bio', 'label' => 'Short Bio (optional)', 'type' => 'textarea', 'rows' => 3, 'optional' => true],
        ['name' => 'sort_order', 'label' => 'Sort Order', 'type' => 'number', 'default' => 0],
        ['name' => 'is_active', 'label' => 'Status', 'type' => 'select', 'options' => [1 => 'Active (visible)', 0 => 'Inactive (hidden)'], 'default' => 1],
    ],
    'columns' => [
        ['key' => 'sort_order', 'label' => 'Order'],
        ['key' => 'photo_url', 'label' => 'Photo', 'type' => 'image'],
        ['key' => 'name', 'label' => 'Name'],
        ['key' => 'role', 'label' => 'Role'],
        ['key' => 'bio', 'label' => 'Bio'],
        ['key' => 'is_active', 'label' => 'Status', 'badge_map' => [1 => 'active', 0 => 'inactive'], 'label_map' => [1 => 'Active', 0 => 'Inactive']],
    ],
    'table_class' => 'table-compact',
    'items' => $items,
]);
