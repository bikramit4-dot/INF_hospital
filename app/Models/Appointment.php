<?php
namespace App\Models;

use App\Core\Model;

class Appointment extends Model
{
    protected static string $table = 'appointments';
    protected static string $primaryKey = 'id';

    /**
     * Generate a unique booking reference.
     */
    public static function generateBookingRef(): string
    {
        return 'HH' . date('Ymd') . random_int(1000, 9999);
    }

    /**
     * Find by booking reference.
     */
    public static function findByBookingRef(string $ref): ?array
    {
        return self::firstWhere('booking_ref = :ref', [':ref' => $ref]);
    }

    /**
     * Get appointments with related data.
     */
    public static function allWithRelations(array $where = [], string $orderBy = 'a.created_at DESC'): array
    {
        $db = new static();
        $sql = 'SELECT a.*, doc.name AS doctor_name, dep.name AS department_name
                FROM appointments a
                JOIN doctors doc ON a.doctor_id = doc.id
                JOIN departments dep ON a.department_id = dep.id';

        $params = [];
        if (!empty($where)) {
            $conditions = [];
            foreach ($where as $col => $val) {
                $conditions[] = "a.{$col} = :{$col}";
                $params[":{$col}"] = $val;
            }
            $sql .= ' WHERE ' . implode(' AND ', $conditions);
        }

        $sql .= ' ORDER BY ' . $orderBy;
        return $db->getDb()->fetchAll($sql, $params);
    }

    /**
     * Paginate appointments (optionally filtered by search query).
     * Returns ['items', 'total', 'page', 'perPage', 'lastPage'].
     */
    public static function paginateSearch(string $q = '', int $page = 1, int $perPage = 15, string $orderBy = 'a.created_at DESC'): array
    {
        $db = new static();
        $where = '';
        $params = [];
        if ($q !== '') {
            $where = 'WHERE a.patient_name LIKE :q
                   OR a.booking_ref LIKE :q
                   OR a.patient_phone LIKE :q
                   OR a.patient_email LIKE :q
                   OR doc.name LIKE :q
                   OR dep.name LIKE :q';
            $params[':q'] = '%' . $q . '%';
        }

        $total = (int) $db->getDb()->fetchColumn(
            'SELECT COUNT(*)
             FROM appointments a
             JOIN doctors doc ON a.doctor_id = doc.id
             JOIN departments dep ON a.department_id = dep.id ' . $where,
            $params
        );

        $lastPage = max(1, (int) ceil($total / $perPage));
        $page = min(max(1, $page), $lastPage);
        $offset = ($page - 1) * $perPage;

        $items = $db->getDb()->fetchAll(
            'SELECT a.*, doc.name AS doctor_name, dep.name AS department_name
             FROM appointments a
             JOIN doctors doc ON a.doctor_id = doc.id
             JOIN departments dep ON a.department_id = dep.id ' . $where . '
             ORDER BY ' . $orderBy . ' LIMIT ' . (int) $perPage . ' OFFSET ' . (int) $offset,
            $params
        );

        return [
            'items' => $items,
            'total' => $total,
            'page' => $page,
            'perPage' => $perPage,
            'lastPage' => $lastPage,
        ];
    }
}