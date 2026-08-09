<?php
namespace App\Models;

use App\Core\Model;

class TeamMember extends Model
{
    protected static string $table = 'team_members';
    protected static string $primaryKey = 'id';

    public static function allActive(): array
    {
        return self::where('is_active = 1', [], 'sort_order');
    }
}