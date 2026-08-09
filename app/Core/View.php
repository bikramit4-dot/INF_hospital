<?php
namespace App\Core;

/**
 * Simple PHP template renderer.
 *
 * Views are plain PHP files in app/Views/ that receive extracted variables.
 * Layouts are optional wrappers (header + footer).
 */
class View
{
    /**
     * Render a view file with data.
     *
     * @param string $view  Path relative to Views dir, e.g. "pages/index" or "admin/dashboard"
     * @param array  $data  Variables to extract into the template scope
     * @param string $layout Optional layout name (e.g. "main" to use layouts/main-header.php + layouts/main-footer.php)
     */
    public static function render(string $view, array $data = [], string $layout = 'main'): void
    {
        $viewPath = __DIR__ . '/../Views/' . $view . '.php';
        if (!file_exists($viewPath)) {
            throw new \RuntimeException("View not found: {$viewPath}");
        }

        // Extract data so templates can use $page_title, $doctors, etc.
        extract($data);

        // Render header layout if requested
        if ($layout) {
            $headerPath = __DIR__ . '/../Views/layouts/' . $layout . '-header.php';
            if (file_exists($headerPath)) {
                require $headerPath;
            }
        }

        // Render the main view content
        require $viewPath;

        // Render footer layout if requested
        if ($layout) {
            $footerPath = __DIR__ . '/../Views/layouts/' . $layout . '-footer.php';
            if (file_exists($footerPath)) {
                require $footerPath;
            }
        }
    }

    /**
     * Render a view without a layout (for AJAX, API, or inline content).
     */
    public static function renderPartial(string $view, array $data = []): void
    {
        $viewPath = __DIR__ . '/../Views/' . $view . '.php';
        if (!file_exists($viewPath)) {
            throw new \RuntimeException("View not found: {$viewPath}");
        }
        extract($data);
        require $viewPath;
    }

    /**
     * Render an admin page view.
     */
    public static function renderAdmin(string $view, array $data = []): void
    {
        self::render($view, $data, 'admin');
    }
}