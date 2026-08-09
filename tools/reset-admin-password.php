<?php
/**
 * CLI tool: reset the admin password to a new random value.
 *
 * Usage (from the project root):
 *   php tools/reset-admin-password.php
 *
 * The new password is printed to the terminal and saved to
 * storage/admin-password.txt (not web-accessible).
 */

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit("This tool can only be run from the command line.\n");
}

require_once __DIR__ . '/../includes/config.php';

$newPassword = bin2hex(random_bytes(9)); // 18 characters

$pdo = get_db();
$stmt = $pdo->prepare('UPDATE admins SET password_hash = :hash WHERE username = :username');
$stmt->execute([
    ':hash' => password_hash($newPassword, PASSWORD_BCRYPT, ['cost' => 12]),
    ':username' => 'admin',
]);

$pwFile = dirname(DB_PATH) . '/admin-password.txt';
@file_put_contents($pwFile,
    "Home Hospital - Admin password reset at " . date('Y-m-d H:i:s') . "\n"
    . "Username: admin\n"
    . "Password: " . $newPassword . "\n"
    . "Please log in at admin/login.php and change this password immediately.\n");

echo "Admin password reset successfully.\n";
echo "Username: admin\n";
echo "Password: " . $newPassword . "\n";
echo "A copy was saved to storage/admin-password.txt (not web-accessible).\n";
echo "Change it after logging in via the admin panel -> Change Password.\n";
