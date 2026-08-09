<?php
namespace App\Models;

use App\Core\Model;

class OnlineConsultation extends Model
{
    protected static string $table = 'online_consultations';
    protected static string $primaryKey = 'id';

    public static function pendingCount(): int
    {
        return self::count('status = :status', [':status' => 'pending']);
    }

    /**
     * Paginate consultations (optionally filtered by search query).
     * Returns ['items', 'total', 'page', 'perPage', 'lastPage'].
     */
    public static function paginateSearch(string $q = '', int $page = 1, int $perPage = 15, string $orderBy = 'oc.created_at DESC'): array
    {
        $db = new static();
        $where = '';
        $params = [];
        if ($q !== '') {
            $where = 'WHERE oc.name LIKE :q
                   OR oc.email LIKE :q
                   OR oc.phone LIKE :q
                   OR oc.issue LIKE :q
                   OR dep.name LIKE :q';
            $params[':q'] = '%' . $q . '%';
        }

        $total = (int) $db->getDb()->fetchColumn(
            'SELECT COUNT(*)
             FROM online_consultations oc
             LEFT JOIN departments dep ON oc.department_id = dep.id ' . $where,
            $params
        );

        $lastPage = max(1, (int) ceil($total / $perPage));
        $page = min(max(1, $page), $lastPage);
        $offset = ($page - 1) * $perPage;

        $items = $db->getDb()->fetchAll(
            'SELECT oc.*, dep.name AS department_name
             FROM online_consultations oc
             LEFT JOIN departments dep ON oc.department_id = dep.id ' . $where . '
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