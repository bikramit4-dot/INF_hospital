<?php
/**
 * Database Migration Runner (MySQL / MariaDB)
 *
 * Usage:  php database/migrate.php
 *
 * 1. Connects to MySQL using the settings in includes/db-config.php
 *    (override any value with DB_* environment variables).
 * 2. Creates the database if it does not exist.
 * 3. Drops all application tables (safe to re-run).
 * 4. Applies database/schema.mysql.sql (schema + seed data).
 * 5. Regenerates the admin password with a random value and writes it to
 *    storage/admin-password.txt.
 */

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit("This script can only be run from the command line.\n");
}

$config = require __DIR__ . '/../includes/db-config.php';

if ($config['driver'] !== 'mysql') {
    exit("database/migrate.php targets MySQL. Set DB_DRIVER=mysql in the environment or edit includes/db-config.php.\n");
}

try {
    $dsn = 'mysql:host=' . $config['host'] . ';port=' . $config['port'] . ';charset=utf8mb4';
    $pdo = new PDO($dsn, $config['user'], $config['pass'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
    exit("Cannot connect to MySQL at {$config['host']}:{$config['port']} — " . $e->getMessage() . "\n");
}

// 1. Create the database if it does not exist
$db = $config['name'];
$pdo->exec("CREATE DATABASE IF NOT EXISTS `{$db}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
$pdo->exec("USE `{$db}`");
echo "Database '{$db}' ready.\n";

// 2. Drop existing tables (child first so FK constraints do not block)
$tables = [
    'lab_report_results', 'lab_reports', 'career_applications', 'online_consultations',
    'contacts', 'appointments', 'patients', 'team_members', 'services',
    'news_events', 'health_packages', 'doctors', 'departments', 'login_attempts', 'page_content', 'admins',
];
$pdo->exec('SET FOREIGN_KEY_CHECKS = 0');
foreach ($tables as $t) {
    $pdo->exec("DROP TABLE IF EXISTS `{$t}`");
}
$pdo->exec('SET FOREIGN_KEY_CHECKS = 1');
echo "Existing tables dropped.\n";

// 3. Apply schema + seed data from the importable SQL file
$sqlFile = __DIR__ . '/schema.mysql.sql';
$sql = file_get_contents($sqlFile);
if ($sql === false) {
    exit("ERROR: could not read {$sqlFile}\n");
}

// The database was already created above, so strip the file's
// CREATE DATABASE / USE / SET NAMES preamble before executing.
$sql = preg_replace('/CREATE DATABASE IF NOT EXISTS `?[a-zA-Z0-9_]+`?.*?;/is', '', $sql, 1);
$sql = preg_replace('/^\\s*USE `?[a-zA-Z0-9_]+`?\\s*;/m', '', $sql, 1);
$sql = preg_replace('/^\\s*SET NAMES .*?;/m', '', $sql, 1);

$pdo->exec($sql);
echo "Schema + seed data applied from schema.mysql.sql.\n";

// 4. Regenerate the admin password with a random value (overrides the
//    placeholder password baked into the SQL file for phpMyAdmin imports).
$tempPassword = bin2hex(random_bytes(9)); // 18 characters
$stmt = $pdo->prepare('UPDATE admins SET password_hash = :hash WHERE username = :username');
$stmt->execute([
    ':hash' => password_hash($tempPassword, PASSWORD_BCRYPT, ['cost' => 12]),
    ':username' => 'admin',
]);

$pwFile = dirname(__DIR__) . '/storage/admin-password.txt';
@file_put_contents($pwFile,
    "Home Hospital - Admin login (auto-generated)\n"
    . "Username: admin\n"
    . "Password: " . $tempPassword . "\n"
    . "Please log in at admin/login.php and change this password immediately.\n");
echo "Admin password regenerated -> storage/admin-password.txt\n";

echo "\nMigration completed successfully.\n";
