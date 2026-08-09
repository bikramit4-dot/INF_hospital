<?php
require_once __DIR__ . '/../includes/config.php';

use App\Core\View;
use App\Models\Admin;
use App\Models\LoginAttempt;

if (is_admin_logged_in()) {
    header('Location: index.php');
    exit;
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ip = client_ip();

    if (LoginAttempt::isThrottled($ip)) {
        $message = '<div class="alert alert-error">Too many failed login attempts. Please try again later.</div>';
    } else {
        try {
            verify_csrf_token($_POST['csrf_token'] ?? '');
        } catch (Exception $e) {
            $message = '<div class="alert alert-error">' . e($e->getMessage()) . '</div>';
        }

        if ($message === '') {
            $username = trim($_POST['username'] ?? '');
            $password = (string)($_POST['password'] ?? '');

            if ($username === '' || $password === '') {
                LoginAttempt::record($ip, $username, false);
                $message = '<div class="alert alert-error">Please enter both username and password.</div>';
            } else {
                $admin = Admin::findByUsername($username);

                $valid = $admin ? Admin::verifyPassword($admin, $password) : password_verify($password, DEFAULT_ADMIN_PASSWORD_HASH);

                if ($valid) {
                    LoginAttempt::record($ip, $username, true);
                    session_regenerate_id(true);
                    $_SESSION['admin_logged_in'] = true;
                    $_SESSION['admin_user'] = $username;
                    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

                    if ($admin && Admin::isUsingDefaultPassword($admin)) {
                        header('Location: change-password.php?forced=1');
                    } else {
                        header('Location: index.php');
                    }
                    exit;
                }

                LoginAttempt::record($ip, $username, false);
                $message = '<div class="alert alert-error">Invalid credentials.</div>';
            }
        }
    }
}

$page_title = 'Admin Login';
$csrf_token = csrf_token();
View::renderPartial('admin/login', compact('page_title', 'message', 'csrf_token'));