<?php
require_once __DIR__ . '/../includes/config.php';
require_admin();

use App\Core\View;
use App\Models\Service;

$page_title = 'Manage Services';

$message = '';
$edit_item = null;
$edit_id = (int) ($_GET['edit'] ?? 0);
if ($edit_id > 0) {
    $edit_item = Service::find($edit_id);
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
            Service::delete($id);
            $message = '<div class="alert alert-success alert-dismissible">Service deleted successfully.</div>';
        } else {
            $slug = trim($_POST['slug'] ?? '');
            $icon = trim($_POST['icon'] ?? '🚑');
            $title = trim($_POST['title'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $image_url = trim($_POST['image_url'] ?? '');
            $sort_order = (int) ($_POST['sort_order'] ?? 0);
            $is_active = isset($_POST['is_active']) && (int) $_POST['is_active'] === 1 ? 1 : 0;

            if ($slug === '' || $title === '' || $description === '') {
                throw new Exception('Slug, title, and description are required.');
            }
            $slug = strtolower(preg_replace('/[^a-z0-9-]+/', '-', $slug));

            $data = [
                'slug' => $slug,
                'icon' => $icon,
                'title' => $title,
                'description' => $description,
                'image_url' => $image_url,
                'sort_order' => $sort_order,
                'is_active' => $is_active,
            ];

            if ($action === 'update' && $id) {
                $existing = Service::find($id);
                $dup = Service::firstWhere('slug = :slug AND id != :id', [':slug' => $slug, ':id' => $id]);
                if ($dup) {
                    throw new Exception('Another service already uses this slug.');
                }
                Service::update($id, $data);
                $edit_item = null;
                $message = '<div class="alert alert-success alert-dismissible">Service updated successfully.</div>';
            } else {
                if (Service::findBySlug($slug)) {
                    throw new Exception('A service with this slug already exists.');
                }
                Service::create($data);
                $message = '<div class="alert alert-success alert-dismissible">Service added successfully.</div>';
            }
        }
    } catch (Exception $e) {
        $message = '<div class="alert alert-error">' . e($e->getMessage()) . '</div>';
    }
}

$items = Service::all('sort_order, id');
$csrf_token = csrf_token();

View::renderAdmin('admin/crud', [
    'page_title' => $page_title,
    'message' => $message,
    'csrf_token' => $csrf_token,
    'active' => 'services',
    'heading' => 'Manage Services',
    'subtitle' => 'The services shown on the Services page — add, edit, reorder, or remove them here.',
    'form_title' => 'Add Service',
    'form_title_edit' => 'Edit Service',
    'submit_text' => 'Save Service',
    'submit_edit_text' => 'Update Service',
    'list_title' => 'Existing Services',
    'item_label' => 'service',
    'edit_item' => $edit_item,
    'fields' => [
        ['name' => 'title', 'label' => 'Service Title', 'type' => 'text'],
        ['name' => 'slug', 'label' => 'Slug', 'type' => 'text', 'hint' => 'URL anchor, e.g. emergency, opd, radiology. Auto-normalized.'],
        ['name' => 'icon', 'label' => 'Icon (emoji)', 'type' => 'text', 'optional' => true, 'hint' => 'Optional emoji, e.g. 🚑'],
        ['name' => 'description', 'label' => 'Description', 'type' => 'textarea', 'rows' => 4],
        ['name' => 'image_url', 'label' => 'Image URL (optional)', 'type' => 'text', 'optional' => true, 'hint' => 'Banner image for the home page slider. Use a site-relative path (e.g. images/services/x.jpg). Leave blank to show the emoji icon on a themed banner.'],
        ['name' => 'sort_order', 'label' => 'Sort Order', 'type' => 'number', 'default' => 0],
        ['name' => 'is_active', 'label' => 'Status', 'type' => 'select', 'options' => [1 => 'Active (visible)', 0 => 'Inactive (hidden)'], 'default' => 1],
    ],
    'columns' => [
        ['key' => 'sort_order', 'label' => 'Order'],
        ['key' => 'image_url', 'label' => 'Image', 'type' => 'image'],
        ['key' => 'title', 'label' => 'Title'],
        ['key' => 'slug', 'label' => 'Slug'],
        ['key' => 'description', 'label' => 'Description', 'truncate' => 60],
        ['key' => 'is_active', 'label' => 'Status', 'badge_map' => [1 => 'active', 0 => 'inactive'], 'label_map' => [1 => 'Active', 0 => 'Inactive']],
    ],
    'items' => $items,
]);
