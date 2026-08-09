<?php
namespace App\Models;

use App\Core\Model;

class Contact extends Model
{
    protected static string $table = 'contacts';
    protected static string $primaryKey = 'id';

    public static function unreadCount(): int
    {
        return self::count('is_read = 0');
    }

    /**
     * Paginate messages (optionally filtered by search query).
     * Returns ['items', 'total', 'page', 'perPage', 'lastPage'].
     */
    public static function paginateSearch(string $q = '', int $page = 1, int $perPage = 15, string $orderBy = 'created_at DESC'): array
    {
        $where = $q !== '' ? 'name LIKE :q OR email LIKE :q OR subject LIKE :q OR message LIKE :q' : '';
        $params = $q !== '' ? [':q' => '%' . $q . '%'] : [];
        return self::paginate($page, $perPage, $where, $params, $orderBy);
    }
}