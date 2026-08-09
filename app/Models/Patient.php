<?php
namespace App\Models;

use App\Core\Model;

class Patient extends Model
{
    protected static string $table = 'patients';
    protected static string $primaryKey = 'id';

    public static function findByEmail(string $email): ?array
    {
        return self::firstWhere('email = :email', [':email' => $email]);
    }

    public static function findByPhone(string $phone): ?array
    {
        return self::firstWhere('phone = :phone', [':phone' => $phone]);
    }
}