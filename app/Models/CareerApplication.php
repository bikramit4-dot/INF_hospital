<?php
namespace App\Models;

use App\Core\Model;

class CareerApplication extends Model
{
    protected static string $table = 'career_applications';
    protected static string $primaryKey = 'id';

    public static function pendingCount(): int
    {
        return self::count('status = :status', [':status' => 'pending']);
    }

    /**
     * Paginate applications (optionally filtered by search query).
     * Returns ['items', 'total', 'page', 'perPage', 'lastPage'].
     */
    public static function paginateSearch(string $q = '', int $page = 1, int $perPage = 15, string $orderBy = 'created_at DESC'): array
    {
        $where = $q !== '' ? 'full_name LIKE :q OR email LIKE :q OR phone LIKE :q OR position LIKE :q' : '';
        $params = $q !== '' ? [':q' => '%' . $q . '%'] : [];
        return self::paginate($page, $perPage, $where, $params, $orderBy);
    }
}