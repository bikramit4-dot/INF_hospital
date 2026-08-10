<?php
namespace App\Models;

use App\Core\Database;
use App\Core\Model;

/**
 * Editable page content (key-value rows per page/section).
 *
 * Managed from the admin panel -> Pages. The public site reads values
 * through the content() helper, which falls back to the defaults defined
 * in includes/page-content-registry.php when a row is empty or missing.
 */
class PageContent extends Model
{
    protected static string $table = 'page_content';

    /**
     * Fetch all custom (non-empty) content for a page in a single query,
     * keyed by section. Rows with empty content are omitted so callers
     * can use array_key_exists() to detect custom values.
     */
    public static function forPage(string $page): array
    {
        $out = [];
        foreach (static::where('page = :p', [':p' => $page]) as $row) {
            if (isset($row['content']) && $row['content'] !== '') {
                $out[$row['section']] = (string) $row['content'];
            }
        }
        return $out;
    }

    /**
     * Fetch every row for a page (including empty ones) keyed by section.
     * Used by the admin editor to tell customized fields apart from defaults.
     */
    public static function allForPage(string $page): array
    {
        $out = [];
        foreach (static::where('page = :p', [':p' => $page]) as $row) {
            $out[$row['section']] = (string) $row['content'];
        }
        return $out;
    }

    /**
     * Delete rows for a page that are empty — keeps the table tidy after
     * saves that blank out previously customized fields (empty = default).
     */
    public static function pruneEmpty(string $page): void
    {
        $db = Database::getInstance();
        $db->execute(
            'DELETE FROM ' . static::$table . ' WHERE page = :p AND (content IS NULL OR content = \'\')',
            [':p' => $page]
        );
    }

    /**
     * Insert or update the content for a page/section.
     * Saving an empty string effectively resets the field to its default.
     */
    public static function upsert(string $page, string $section, string $content): void
    {
        $existing = static::firstWhere('page = :p AND section = :s', [':p' => $page, ':s' => $section]);
        if ($existing) {
            static::update((int) $existing['id'], ['content' => $content]);
        } else {
            static::create(['page' => $page, 'section' => $section, 'content' => $content]);
        }
    }
}
