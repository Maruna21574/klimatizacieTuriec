<?php
/**
 * PDO pripojenie k databáze pre CMS/CRM (texty, kalkulačka, galéria).
 *
 * Web musí fungovať aj keď je DB dočasne nedostupná - preto db() vracia
 * null namiesto vyhodenia výnimky a všetky miesta, ktoré ju používajú,
 * majú pripravený fallback na pôvodný pevný obsah.
 */

declare(strict_types=1);

require_once __DIR__ . '/env.php';

function db(): ?PDO
{
    static $pdo = null;
    static $failed = false;

    if ($pdo instanceof PDO) {
        return $pdo;
    }
    if ($failed) {
        return null;
    }

    $host = envVal('DB_HOST', '127.0.0.1');
    $port = envVal('DB_PORT', '3306');
    $name = envVal('DB_NAME', '');
    $user = envVal('DB_USER', 'root');
    $pass = envVal('DB_PASS', '');

    if ($name === '') {
        $failed = true;
        return null;
    }

    $dsn = "mysql:host={$host};port={$port};dbname={$name};charset=utf8mb4";

    try {
        $pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
        return $pdo;
    } catch (PDOException $e) {
        $failed = true;
        error_log('[matrotech] DB pripojenie zlyhalo: ' . $e->getMessage());
        return null;
    }
}
