<?php
require_once __DIR__ . '/../includes/config.php';
require_admin();

use App\Core\View;
use App\Models\Admin;

$page_title = 'Change Password';
$pdo = get_db();

$forced = (($_GET['forced'] ?? '') === '1');
$message = '';

$admin = Admin::findByUsername($_SESSION['admin_user']);
$needs_change = $admin && Admin::isUsingDefaultPassword($admin);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        verify_csrf_token($_POST['csrf_token'] ?? '');

        $old = (string)($_POST['current_password'] ?? '');
        $new = (string)($_POST['new_password'] ?? '');
        $confirm = (string)($_POST['confirm_password'] ?? '');

        if (!$admin || !password_verify($old, $admin['password_hash'])) {
            throw new Exception('Current password is incorrect.');
        }
        if (strlen($new) < 10) {
            throw new Exception('New password must be at least 10 characters long.');
        }
        if (!preg_match('/[A-Z]/', $new) || !preg_match('/[a-z]/', $new) || !preg_match('/[0-9]/', $new)) {
            throw new Exception('New password must contain uppercase and lowercase letters and a number.');
        }
        if ($new !== $confirm) {
            throw new Exception('New password and confirmation do not match.');
        }
        if (password_verify($new, $admin['password_hash'])) {
            throw new Exception('New password must be different from the current password.');
        }

        Admin::updatePassword((int)$admin['id'], $new);

        $pwFile = dirname(DB_PATH) . '/admin-password.txt';
        if (is_file($pwFile)) {
            @unlink($pwFile);
        }

        session_regenerate_id(true);
        $message = '<div class="alert alert-success">Password updated successfully.</div>';
        $needs_change = false;
        $forced = false;
    } catch (Exception $e) {
        $message = '<div class="alert alert-error">' . e($e->getMessage()) . '</div>';
    }
}

$csrf_token = csrf_token();
View::renderAdmin('admin/change-password', compact('page_title', 'message', 'forced', 'needs_change', 'csrf_token'));