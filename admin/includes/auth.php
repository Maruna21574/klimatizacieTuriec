<?php
/**
 * Prihlasovanie do admin rozhrania (session-based).
 */

declare(strict_types=1);

require_once __DIR__ . '/../../includes/db.php';

function adminSessionStart(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_name('klimaturiec_admin');
        session_set_cookie_params([
            'lifetime' => 0,
            'path' => '/',
            'httponly' => true,
            'samesite' => 'Lax',
            'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
        ]);
        session_start();
    }
}

function isAdminLoggedIn(): bool
{
    adminSessionStart();
    return !empty($_SESSION['admin_id']);
}

/** Presmeruje na login, ak používateľ nie je prihlásený. Zavolať na začiatku každej chránenej stránky. */
function requireAdminLogin(): void
{
    adminSessionStart();
    if (empty($_SESSION['admin_id'])) {
        header('Location: login.php');
        exit;
    }
}

function attemptAdminLogin(string $username, string $password): bool
{
    adminSessionStart();
    $pdo = db();
    if ($pdo === null) {
        return false;
    }

    $stmt = $pdo->prepare('SELECT id, password_hash FROM admin_users WHERE username = ?');
    $stmt->execute([$username]);
    $row = $stmt->fetch();

    if ($row && password_verify($password, $row['password_hash'])) {
        session_regenerate_id(true);
        $_SESSION['admin_id'] = (int) $row['id'];
        $_SESSION['admin_username'] = $username;
        return true;
    }

    // Malé oneskorenie proti hrubému hádaniu hesla.
    usleep(300000);
    return false;
}

function adminLogout(): void
{
    adminSessionStart();
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }
    session_destroy();
}

function currentAdminUsername(): string
{
    adminSessionStart();
    return (string) ($_SESSION['admin_username'] ?? '');
}

function currentAdminId(): int
{
    adminSessionStart();
    return (int) ($_SESSION['admin_id'] ?? 0);
}

/** Uloží krátku hlásku, ktorá sa zobrazí po redirecte (flash message). */
function setFlash(string $message, string $type = 'success'): void
{
    adminSessionStart();
    $_SESSION['flash'] = ['message' => $message, 'type' => $type];
}

function getFlash(): ?array
{
    adminSessionStart();
    if (empty($_SESSION['flash'])) {
        return null;
    }
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
    return $flash;
}
