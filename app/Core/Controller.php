<?php
namespace App\Core;

/**
 * Base Controller — all page controllers extend this.
 */
abstract class Controller
{
    protected Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    // ------------------------------------------------------------------
    // Output helpers
    // ------------------------------------------------------------------

    /**
     * HTML-escape a string.
     */
    public static function e(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Render a view with the main layout.
     */
    protected function render(string $view, array $data = []): void
    {
        View::render($view, $data, 'main');
    }

    /**
     * Render an admin view with the admin layout.
     */
    protected function renderAdmin(string $view, array $data = []): void
    {
        View::render($view, $data, 'admin');
    }

    /**
     * Render a partial view (no layout).
     */
    protected function renderPartial(string $view, array $data = []): void
    {
        View::renderPartial($view, $data);
    }

    // ------------------------------------------------------------------
    // Redirect helpers
    // ------------------------------------------------------------------

    /**
     * Redirect to a URL.
     */
    protected function redirect(string $url): void
    {
        header('Location: ' . $url);
        exit;
    }

    /**
     * Redirect with a flash message stored in the session.
     */
    protected function redirectWith(string $url, string $message, string $type = 'success'): void
    {
        $_SESSION['flash'] = ['type' => $type, 'message' => $message];
        $this->redirect($url);
    }

    // ------------------------------------------------------------------
    // CSRF helpers
    // ------------------------------------------------------------------

    /**
     * Get or generate a CSRF token.
     */
    protected function csrfToken(): string
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    /**
     * Verify the submitted CSRF token. Throws on failure.
     */
    protected function verifyCsrfToken(string $token): void
    {
        if (!hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
            throw new \RuntimeException('Invalid CSRF token.');
        }
    }

    // ------------------------------------------------------------------
    // Auth helpers
    // ------------------------------------------------------------------

    /**
     * Check if the admin is logged in.
     */
    protected function isAdminLoggedIn(): bool
    {
        return !empty($_SESSION['admin_logged_in']) && !empty($_SESSION['admin_user']);
    }

    /**
     * Require admin login; redirect to login page if not authenticated.
     */
    protected function requireAdmin(): void
    {
        if (!$this->isAdminLoggedIn()) {
            $this->redirect('login.php');
        }
    }

    // ------------------------------------------------------------------
    // Input helpers
    // ------------------------------------------------------------------

    /**
     * Get a POST value safely.
     */
    protected function post(string $key, mixed $default = ''): string
    {
        return trim((string)($_POST[$key] ?? $default));
    }

    /**
     * Get a GET value safely.
     */
    protected function get(string $key, mixed $default = ''): string
    {
        return trim((string)($_GET[$key] ?? $default));
    }
}