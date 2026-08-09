<?php
namespace App\Models;

use App\Core\Model;

class HealthPackage extends Model
{
    protected static string $table = 'health_packages';
    protected static string $primaryKey = 'id';

    public static function allActive(): array
    {
        return self::where('is_active = 1', [], 'id');
    }
}