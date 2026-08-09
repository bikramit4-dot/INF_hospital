<?php
namespace App\Core;

use PDO;
use PDOException;

/**
 * Database singleton — wraps PDO for SQLite.
 */
class Database
{
    private static ?Database $instance = null;
    private PDO $pdo;

    private function __construct()
    {
        // Driver is chosen in includes/db-config.php (default: mysql).
        $driver = defined('DB_DRIVER') ? DB_DRIVER : 'mysql';

        if ($driver === 'mysql') {
            $dsn = 'mysql:host=' . (defined('DB_HOST') ? DB_HOST : '127.0.0.1')
                . ';port=' . (defined('DB_PORT') ? DB_PORT : '3306')
                . ';dbname=' . (defined('DB_NAME') ? DB_NAME : 'hospital')
                . ';charset=utf8mb4';
            $this->pdo = new PDO($dsn, defined('DB_USER') ? DB_USER : 'root', defined('DB_PASS') ? DB_PASS : '');
        } else {
            // SQLite fallback
            $dbPath = defined('DB_PATH') ? DB_PATH : __DIR__ . '/../../storage/hospital.sqlite';
            $dir = dirname($dbPath);
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }
            $this->pdo = new PDO('sqlite:' . $dbPath);
            $this->pdo->exec('PRAGMA foreign_keys = ON;');
        }

        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection(): PDO
    {
        return $this->pdo;
    }

    /**
     * Convenience: fetch all rows.
     */
    public function fetchAll(string $sql, array $params = []): array
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Convenience: fetch a single row.
     */
    public function fetchOne(string $sql, array $params = []): ?array
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    /**
     * Convenience: fetch a single column value.
     */
    public function fetchColumn(string $sql, array $params = []): mixed
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn();
    }

    /**
     * Convenience: execute a write statement (INSERT/UPDATE/DELETE).
     */
    public function execute(string $sql, array $params = []): int
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->rowCount();
    }

    /**
     * Returns the last inserted row ID.
     */
    public function lastInsertId(): string
    {
        return $this->pdo->lastInsertId();
    }

    /**
     * Run a transaction.
     */
    public function transaction(callable $callback): mixed
    {
        $this->pdo->beginTransaction();
        try {
            $result = $callback($this);
            $this->pdo->commit();
            return $result;
        } catch (\Throwable $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }
}