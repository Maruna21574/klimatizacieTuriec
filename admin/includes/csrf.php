<?php
/**
 * CSRF ochrana pre formuláre v admin rozhraní.
 */

declare(strict_types=1);

require_once __DIR__ . '/auth.php';

function csrfToken(): string
{
    adminSessionStart();
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrfField(): string
{
    return '<input type="hidden" name="csrf_token" value="' . e(csrfToken()) . '">';
}

/** Overí CSRF token z $_POST, pri nezhode ukončí request s chybou 400. */
function csrfCheck(): void
{
    adminSessionStart();
    $token = $_POST['csrf_token'] ?? '';
    $expected = $_SESSION['csrf_token'] ?? '';
    if (!is_string($token) || $expected === '' || !hash_equals($expected, $token)) {
        http_response_code(400);
        exit('Neplatná alebo vypršaná požiadavka (CSRF token). Vráť sa späť a skús to znova.');
    }
}
