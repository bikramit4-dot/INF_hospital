<?php
namespace App\Models;

use App\Core\Model;

class Department extends Model
{
    protected static string $table = 'departments';
    protected static string $primaryKey = 'id';

    /**
     * Get department with doctor count.
     */
    public static function allWithDoctorCount(): array
    {
        $db = self::getDb();
        $sql = 'SELECT d.*, (SELECT COUNT(*) FROM doctors WHERE department_id = d.id) AS doctor_count
                FROM departments d ORDER BY d.id';
        return $db->fetchAll($sql);
    }
}