<?php
namespace App\Models;

use App\Core\Model;

class Doctor extends Model
{
    protected static string $table = 'doctors';
    protected static string $primaryKey = 'id';

    /**
     * Get all doctors with their department name.
     */
    public static function allWithDepartment(string $orderBy = 'doc.id'): array
    {
        $db = new static();
        return $db->getDb()->fetchAll(
            'SELECT doc.*, dep.name AS department_name, dep.icon AS department_icon
             FROM doctors doc
             JOIN departments dep ON doc.department_id = dep.id
             ORDER BY ' . $orderBy
        );
    }

    /**
     * Find a doctor by ID with department name.
     */
    public static function findWithDepartment(int $id): ?array
    {
        $db = new static();
        return $db->getDb()->fetchOne(
            'SELECT doc.*, dep.name AS department_name, dep.icon AS department_icon
             FROM doctors doc
             JOIN departments dep ON doc.department_id = dep.id
             WHERE doc.id = :id LIMIT 1',
            [':id' => $id]
        );
    }

    /**
     * Search doctors by name, specialty, or department.
     */
    public static function search(string $by, string $q, ?int $deptId = null): array
    {
        $db = new static();
        $sql = 'SELECT doc.*, dep.name AS department_name, dep.icon AS department_icon
                FROM doctors doc
                JOIN departments dep ON doc.department_id = dep.id WHERE ';
        $params = [];

        if ($by === 'department' && $deptId) {
            $sql .= 'doc.department_id = :dept_id';
            $params[':dept_id'] = $deptId;
        } elseif ($by === 'specialty' && $q !== '') {
            $sql .= 'doc.specialty LIKE :q';
            $params[':q'] = '%' . $q . '%';
        } else {
            $sql .= 'doc.name LIKE :q';
            $params[':q'] = '%' . $q . '%';
        }

        $sql .= ' ORDER BY doc.id';
        return $db->getDb()->fetchAll($sql, $params);
    }
}