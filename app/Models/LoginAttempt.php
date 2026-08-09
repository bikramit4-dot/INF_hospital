<?php
namespace App\Models;

use App\Core\Model;

class LoginAttempt extends Model
{
    protected static string $table = 'login_attempts';
    protected static string $primaryKey = 'id';

    const MAX_ATTEMPTS = 5;
    const WINDOW_SECONDS = 900; // 15 minutes

    /**
     * Check if the given IP is currently throttled.
     */
    public static function isThrottled(string $ip): bool
    {
        $count = self::count(
            'ip = :ip AND success = 0 AND attempted_at > :since',
            [':ip' => $ip, ':since' => time() - self::WINDOW_SECONDS]
        );
        return $count >= self::MAX_ATTEMPTS;
    }

    /**
     * Record a login attempt.
     */
    public static function record(string $ip, string $username, bool $success): void
    {
        self::create([
            'ip' => $ip,
            'username' => mb_substr($username, 0, 64),
            'attempted_at' => time(),
            'success' => $success ? 1 : 0,
        ]);
    }

    /**
     * Clean up old records.
     */
    public static function cleanUp(): void
    {
        $db = new static();
        $db->getDb()->execute(
            'DELETE FROM login_attempts WHERE attempted_at < :cutoff',
            [':cutoff' => time() - (self::WINDOW_SECONDS * 2)]
        );
    }
}