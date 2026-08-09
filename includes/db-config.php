<?php
/**
 * Central database configuration.
 *
 * Used by:
 *   - includes/config.php  (via constants)
 *   - database/migrate.php (CLI migration)
 *
 * Every value can be overridden with an environment variable, which is the
 * recommended way to configure a production server:
 *
 *   DB_DRIVER=mysql DB_HOST=... DB_NAME=... DB_USER=... DB_PASS=... php database/migrate.php
 *
 * @return array
 */
return [
    // 'mysql' (default) or 'sqlite'
    'driver' => getenv('DB_DRIVER') ?: 'mysql',

    // MySQL / MariaDB connection settings (XAMPP defaults)
    'host' => getenv('DB_HOST') ?: '127.0.0.1',
    'port' => getenv('DB_PORT') ?: '3306',
    'name' => getenv('DB_NAME') ?: 'hospital',
    'user' => getenv('DB_USER') ?: 'root',
    'pass' => getenv('DB_PASS') ?: '',

    // Used only when driver = 'sqlite'
    'path' => __DIR__ . '/../storage/hospital.sqlite',
];
