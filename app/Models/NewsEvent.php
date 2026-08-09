<?php
namespace App\Models;

use App\Core\Model;

class NewsEvent extends Model
{
    protected static string $table = 'news_events';
    protected static string $primaryKey = 'id';

    public static function allPublished(): array
    {
        return self::where('is_published = 1', [], 'event_date DESC');
    }
}