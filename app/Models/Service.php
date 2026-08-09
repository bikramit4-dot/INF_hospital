<?php
namespace App\Models;

use App\Core\Model;

class Service extends Model
{
    protected static string $table = 'services';
    protected static string $primaryKey = 'id';

    public static function allActive(): array
    {
        return self::where('is_active = 1', [], 'sort_order');
    }

    public static function findBySlug(string $slug): ?array
    {
        return self::firstWhere('slug = :slug', [':slug' => $slug]);
    }
}