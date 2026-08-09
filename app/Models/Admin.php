<?php
namespace App\Models;

use App\Core\Model;

class Admin extends Model
{
    protected static string $table = 'admins';
    protected static string $primaryKey = 'id';

    /**
     * Find an admin by username.
     */
    public static function findByUsername(string $username): ?array
    {
        return self::firstWhere('username = :username', [':username' => $username]);
    }

    /**
     * Verify a password against the stored hash.
     */
    public static function verifyPassword(array $admin, string $password): bool
    {
        return password_verify($password, $admin['password_hash']);
    }

    /**
     * Update the password hash for an admin.
     */
    public static function updatePassword(int $id, string $newPassword): void
    {
        self::update($id, [
            'password_hash' => password_hash($newPassword, PASSWORD_BCRYPT, ['cost' => 12]),
        ]);
    }

    /**
     * Check if the admin is using the legacy default password.
     */
    public static function isUsingDefaultPassword(array $admin): bool
    {
        $defaultHash = defined('DEFAULT_ADMIN_PASSWORD_HASH') ? DEFAULT_ADMIN_PASSWORD_HASH : '';
        return $defaultHash !== '' && hash_equals($defaultHash, $admin['password_hash']);
    }
}