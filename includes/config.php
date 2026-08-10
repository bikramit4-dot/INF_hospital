<?php
// ==========================================================
// GLOBAL SITE CONFIGURATION
// Home Hospital - Secure admin-managed content storage
// ==========================================================
// ----------------------------------------------------------
// Error handling - never expose errors to visitors in production.
// Set the APP_DEBUG environment variable to 1 during development.
// ----------------------------------------------------------
error_reporting(E_ALL);
ini_set('log_errors', '1');
ini_set('display_errors', empty(getenv('APP_DEBUG')) ? '0' : '1');

// ----------------------------------------------------------
// Session hardening
// ----------------------------------------------------------
session_name('hospital_session');
ini_set('session.use_only_cookies', '1');
ini_set('session.cookie_httponly', '1');
ini_set('session.use_strict_mode', '1');
ini_set('session.cookie_samesite', 'Lax');
if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
    ini_set('session.cookie_secure', '1');
}
session_start();

if (!defined('SITE_NAME')) {
    define('SITE_NAME', 'Home Hospital');
}
define('SITE_TAGLINE', 'Compassionate Care, Advanced Medicine');
define('SITE_PHONE', '+977-61-000000');
define('SITE_EMERGENCY', '+977-61-911911');
define('SITE_EMAIL', 'info@homehospital.com');
define('SITE_ADDRESS', 'Pokhara, Gandaki Pradesh, Nepal');

// ----------------------------------------------------------
// Database configuration (defaults: XAMPP MySQL -> database 'hospital')
// Override via environment variables or includes/db-config.php
// ----------------------------------------------------------
$__dbConfig = require __DIR__ . '/db-config.php';
define('DB_DRIVER', $__dbConfig['driver']);
define('DB_HOST', $__dbConfig['host']);
define('DB_PORT', $__dbConfig['port']);
define('DB_NAME', $__dbConfig['name']);
define('DB_USER', $__dbConfig['user']);
define('DB_PASS', $__dbConfig['pass']);
define('DB_PATH', $__dbConfig['path']); // SQLite fallback only

// Log PHP errors to a file inside the (web-blocked) storage directory.
if (empty(getenv('APP_DEBUG'))) {
    ini_set('error_log', dirname(DB_PATH) . '/php-errors.log');
}

// ----------------------------------------------------------
// Security headers (CSP, clickjacking, MIME sniffing, referrer, ...)
// ----------------------------------------------------------
function send_security_headers() {
    if (headers_sent()) {
        return;
    }
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Permissions-Policy: camera=(), microphone=(), geolocation=()');
    header('Content-Security-Policy: '
        . "default-src 'self'; "
        . "script-src 'self'; "
        . "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; "
        . "font-src 'self' https://fonts.gstatic.com; "
        . "img-src 'self' data:; "
        . "frame-src https://www.google.com; "
        . "connect-src 'self'; "
        . "base-uri 'self'; "
        . "form-action 'self'; "
        . "object-src 'none'; "
        . "frame-ancestors 'self'");
    if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
        header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
    }
}
send_security_headers();

function get_db() {
    return \App\Core\Database::getInstance()->getConnection();
}

function init_db(PDO $pdo) {
    // Schema is managed by database/migrate.php.
    // This function is only called when the DB file exists but is empty
    // (e.g. on a fresh install before the migration runs).
    // Tables are created via schema.sql, not here.
    // The legacy seed data is now handled by database/migrate.php.
}

function csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verify_csrf_token($token) {
    if (!hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
        throw new Exception('Invalid CSRF token.');
    }
}

// Shortcut for HTML-escaping output.
function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

// ----------------------------------------------------------
// Editable page content
// Values are stored in the page_content table (admin panel -> Pages)
// and fall back to the defaults defined in includes/page-content-registry.php
// when no custom value has been saved. Results are cached per request.
// ----------------------------------------------------------
function content(string $page, string $section, ?string $default = null): string
{
    static $cache = [];
    static $registry = null;
    $key = $page . "\x1F" . $section;
    if (array_key_exists($key, $cache)) {
        return $cache[$key];
    }
    $value = \App\Models\PageContent::get($page, $section);
    if ($value === '') {
        if ($default === null) {
            if ($registry === null) {
                $registry = require __DIR__ . '/page-content-registry.php';
            }
            $default = $registry['defaults'][$key] ?? '';
        }
        $value = (string) $default;
    }
    $cache[$key] = $value;
    return $value;
}

// Same as content(), but splits the value into trimmed, non-empty lines
// (handy for bullet lists stored one-per-line).
function content_lines(string $page, string $section, ?string $default = null): array
{
    $lines = preg_split('/\r?\n/', content($page, $section, $default));
    $lines = array_map('trim', $lines);
    return array_values(array_filter($lines, fn($l) => $l !== ''));
}

// Build a site-root-relative URL for asset paths stored in the database
// (e.g. "images/services/emergency.jpg"). Works from any page, including
// the /admin/ folder, and returns absolute URLs unchanged.
function site_url(string $path): string
{
    if ($path === '' || preg_match('#^(https?:)?//#i', $path) || strpos($path, '/') === 0) {
        return $path;
    }
    static $base = null;
    if ($base === null) {
        $docRoot = str_replace('\\', '/', rtrim($_SERVER['DOCUMENT_ROOT'] ?? '', '/'));
        $appRoot = str_replace('\\', '/', dirname(__DIR__)); // site root (includes/ is one level down)
        if ($docRoot !== '' && strpos($appRoot, $docRoot) === 0) {
            $base = '/' . ltrim(substr($appRoot, strlen($docRoot)), '/');
        } else {
            $base = ''; // cannot determine the base; fall back to a plain relative path
        }
        if ($base !== '') {
            $base = ($base === '/') ? '/' : rtrim($base, '/') . '/';
        }
    }
    if ($base === '') {
        return $path;
    }
    return $base . $path;
}

// Hash of the legacy default admin password shipped with earlier versions.
// Used to detect an unchanged default password and force a change on login.
define('DEFAULT_ADMIN_PASSWORD_HASH', '$2y$12$7Ru6CntbgHgfLFdgvisbjessAUQesMtG9a9PCC/UCrg32w8TezhKC');

// ----------------------------------------------------------
// Login brute-force protection (per source IP, stored in the database)
// ----------------------------------------------------------
const LOGIN_MAX_ATTEMPTS = 5;
const LOGIN_WINDOW_SECONDS = 900; // 15 minutes

function client_ip() {
    // Only trust REMOTE_ADDR for security decisions.
    return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
}

function is_login_throttled() {
    $pdo = get_db();
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM login_attempts WHERE ip = :ip AND success = 0 AND attempted_at > :since');
    $stmt->execute([':ip' => client_ip(), ':since' => time() - LOGIN_WINDOW_SECONDS]);
    return (int)$stmt->fetchColumn() >= LOGIN_MAX_ATTEMPTS;
}

function record_login_attempt($username, $success) {
    $pdo = get_db();
    $stmt = $pdo->prepare('INSERT INTO login_attempts (ip, username, attempted_at, success) VALUES (:ip, :username, :t, :success)');
    $stmt->execute([
        ':ip' => client_ip(),
        ':username' => mb_substr($username, 0, 64),
        ':t' => time(),
        ':success' => $success ? 1 : 0,
    ]);
}

// ----------------------------------------------------------
// Simple per-session rate limiter for public forms (e.g. lab report lookups)
// ----------------------------------------------------------
function rate_limited($action, $max = 10, $window = 600) {
    $now = time();
    $key = 'rl_' . $action;
    $times = $_SESSION[$key] ?? [];
    if (!is_array($times)) {
        $times = [];
    }
    $times = array_values(array_filter($times, function ($t) use ($now, $window) {
        return is_int($t) && ($now - $t) < $window;
    }));
    if (count($times) >= $max) {
        $_SESSION[$key] = $times;
        return true;
    }
    $times[] = $now;
    $_SESSION[$key] = $times;
    return false;
}

function is_admin_logged_in() {
    return !empty($_SESSION['admin_logged_in']) && !empty($_SESSION['admin_user']);
}

function require_admin() {
    if (!is_admin_logged_in()) {
        header('Location: login.php');
        exit;
    }
}

// ----------------------------------------------------------
// PSR-4 compatible autoloader for the app/ namespace
// ----------------------------------------------------------
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $baseDir = __DIR__ . '/../app/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

use App\Models\Department;
use App\Models\Doctor;
use App\Models\HealthPackage;
use App\Models\NewsEvent;
use App\Models\Service;
use App\Models\TeamMember;

// ----------------------------------------------------------
// Load site data from the database via Models
// ----------------------------------------------------------
function load_site_content() {
    $departments = Department::all('id');
    $doctors = Doctor::allWithDepartment();
    $health_packages = HealthPackage::allActive();
    $news_events = NewsEvent::allPublished();
    return compact('departments', 'doctors', 'health_packages', 'news_events');
}

$site_content = load_site_content();
$departments = $site_content['departments'];
$doctors = $site_content['doctors'];
$health_packages = $site_content['health_packages'];
$news_events = $site_content['news_events'];

// Simple nav structure used to build header menus
$nav_menu = [
    'Home' => [
        'link' => 'index.php',
        'children' => [
            'About Us' => 'about.php',
            'Mission & Vision' => 'mission-vision.php',
            'Management Team' => 'management-team.php',
            'Departments' => 'departments.php',
            'Medical Technology' => 'medical-technology.php',
            'Patient Care & Safety' => 'patient-care-safety.php',
            'Health Packages' => 'health-packages.php',
            'Research & Education' => 'research-education.php',
            'Careers' => 'careers.php',
            'News & Events' => 'news-events.php',
            'Contact Us' => 'contact.php',
        ]
    ],
    'Our Services' => [
        'link' => 'services.php',
        'children' => [
            'Emergency Services' => 'services.php#emergency',
            'Outpatient Services (OPD)' => 'services.php#opd',
            'Inpatient Services (IPD)' => 'services.php#ipd',
            'Pharmacy' => 'services.php#pharmacy',
            'Diagnostic Services' => 'services.php#diagnostic',
            'Laboratory Services' => 'services.php#laboratory',
            'Radiology & Imaging' => 'services.php#radiology',
            'Ambulance Services' => 'services.php#ambulance',
            'Preventive Healthcare' => 'services.php#preventive',
            'Patient Rooms' => 'services.php#patient-rooms',
        ]
    ],
    'Find a Doctor' => [
        'link' => 'find-doctor.php',
        'children' => [
            'Search by Name' => 'find-doctor.php?by=name',
            'Search by Department' => 'find-doctor.php?by=department',
            'Search by Specialty' => 'find-doctor.php?by=specialty',
            'Doctor Schedule' => 'doctor-schedule.php',
            'Online Consultation' => 'online-consultation.php',
            'Book Appointment' => 'book-appointment.php',
        ]
    ],
    'International Patients' => [
        'link' => 'international-patients.php',
        'children' => [
            'International Patient Services' => 'international-patients.php#services',
            'Medical Packages' => 'international-patients.php#packages',
            'Visa Assistance' => 'international-patients.php#visa',
            'Travel Support' => 'international-patients.php#travel',
            'Accommodation' => 'international-patients.php#accommodation',
            'Interpreter Services' => 'international-patients.php#interpreter',
            'Insurance Information' => 'international-patients.php#insurance',
        ]
    ],
    'Lab Report' => [
        'link' => 'lab-report.php',
        'children' => [
            'View Reports' => 'lab-report.php#view',
            'Download Reports' => 'lab-report.php#download',
            'Test Results' => 'lab-report.php#results',
            'Diagnostic Reports' => 'lab-report.php#diagnostic',
            'Report History' => 'lab-report.php#history',
            'Online Verification' => 'lab-report.php#verify',
        ]
    ],
    'News and Events' => [
        'link' => 'news-events.php',
        'children' => []
    ],
];
