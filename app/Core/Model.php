<?php
namespace App\Core;

use PDO;

/**
 * Base Model — provides common CRUD helpers.
 *
 * Subclasses override $table, $primaryKey, and optionally $fillable.
 */
abstract class Model
{
    protected static string $table;
    protected static string $primaryKey = 'id';
    protected static array $fillable = [];

    protected Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /** Return the Database instance (for raw queries). */
    public function getDb(): Database
    {
        return $this->db;
    }

    /** Return the table name. */
    public static function tableName(): string
    {
        return static::$table;
    }

    /** Return the primary key column name. */
    public static function primaryKey(): string
    {
        return static::$primaryKey;
    }

    /** Find a record by its primary key. */
    public static function find(int|string $id): ?array
    {
        $db = Database::getInstance();
        return $db->fetchOne(
            'SELECT * FROM ' . static::$table . ' WHERE ' . static::$primaryKey . ' = :id LIMIT 1',
            [':id' => $id]
        );
    }

    /** Fetch all records (with optional ORDER BY). */
    public static function all(string $orderBy = ''): array
    {
        $sql = 'SELECT * FROM ' . static::$table;
        if ($orderBy) {
            $sql .= ' ORDER BY ' . $orderBy;
        }
        return Database::getInstance()->fetchAll($sql);
    }

    /** Fetch records matching a WHERE clause. */
    public static function where(string $where, array $params = [], string $orderBy = ''): array
    {
        $sql = 'SELECT * FROM ' . static::$table . ' WHERE ' . $where;
        if ($orderBy) {
            $sql .= ' ORDER BY ' . $orderBy;
        }
        return Database::getInstance()->fetchAll($sql, $params);
    }

    /** Fetch the first record matching a WHERE clause. */
    public static function firstWhere(string $where, array $params = []): ?array
    {
        $sql = 'SELECT * FROM ' . static::$table . ' WHERE ' . $where . ' LIMIT 1';
        return Database::getInstance()->fetchOne($sql, $params);
    }

    /** Count records (with optional WHERE). */
    public static function count(string $where = '', array $params = []): int
    {
        $sql = 'SELECT COUNT(*) FROM ' . static::$table;
        if ($where) {
            $sql .= ' WHERE ' . $where;
        }
        return (int) Database::getInstance()->fetchColumn($sql, $params);
    }

    /** Insert a record and return the new ID. */
    public static function create(array $data): string
    {
        $db = Database::getInstance();
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_map(fn($c) => ':' . $c, array_keys($data)));
        $sql = 'INSERT INTO ' . static::$table . " ({$columns}) VALUES ({$placeholders})";
        $db->execute($sql, $data);
        return $db->lastInsertId();
    }

    /** Update a record by primary key. Returns row count. */
    public static function update(int|string $id, array $data): int
    {
        $db = Database::getInstance();
        $sets = implode(', ', array_map(fn($c) => "{$c} = :{$c}", array_keys($data)));
        $data[':pk'] = $id;
        $sql = 'UPDATE ' . static::$table . " SET {$sets} WHERE " . static::$primaryKey . ' = :pk';
        return $db->execute($sql, $data);
    }

    /** Delete a record by primary key. Returns row count. */
    public static function delete(int|string $id): int
    {
        $db = Database::getInstance();
        return $db->execute(
            'DELETE FROM ' . static::$table . ' WHERE ' . static::$primaryKey . ' = :id',
            [':id' => $id]
        );
    }

    /** Paginate results. */
    public static function paginate(int $page = 1, int $perPage = 10, string $where = '', array $params = [], string $orderBy = ''): array
    {
        $offset = ($page - 1) * $perPage;
        $total = static::count($where, $params);
        $sql = 'SELECT * FROM ' . static::$table;
        if ($where) {
            $sql .= ' WHERE ' . $where;
        }
        if ($orderBy) {
            $sql .= ' ORDER BY ' . $orderBy;
        }
        $sql .= ' LIMIT ' . (int)$perPage . ' OFFSET ' . (int)$offset;
        $items = Database::getInstance()->fetchAll($sql, $params);
        return [
            'items' => $items,
            'total' => $total,
            'page' => $page,
            'perPage' => $perPage,
            'lastPage' => max(1, (int)ceil($total / $perPage)),
        ];
    }
}