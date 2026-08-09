<?php
/**
 * Router for the PHP built-in server.
 *
 * Run with:  php -S localhost:8000 router.php
 *
 * .htaccess rules are ignored by the built-in server, so this router
 * mirrors the same protections: it blocks direct requests to sensitive
 * files and directories.
 */

$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';

$blockedPrefixes = ['/storage/', '/includes/', '/tools/', '/.git/'];
foreach ($blockedPrefixes as $prefix) {
    if (strpos($path, $prefix) === 0) {
        http_response_code(403);
        exit('Forbidden');
    }
}

$basename = basename($path);
if (strpos($basename, '.ht') === 0) {
    http_response_code(403);
    exit('Forbidden');
}

if (preg_match('/\.(sqlite|sqlite3|db|db3|log|bak|ini)$/i', $path)) {
    http_response_code(403);
    exit('Forbidden');
}

// Let the built-in server handle the request normally.
return false;
