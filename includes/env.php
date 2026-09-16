<?php
/**
 * Jednoduché načítanie premenných z .env súboru (bez závislostí / composeru).
 * Hodnoty sa nastavia len ak už nie sú definované v prostredí.
 */

declare(strict_types=1);

function loadEnv(string $path): void
{
    static $loaded = false;
    if ($loaded || !is_file($path)) {
        return;
    }
    $loaded = true;

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if ($lines === false) {
        return;
    }

    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#')) {
            continue;
        }
        if (!str_contains($line, '=')) {
            continue;
        }
        [$key, $value] = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value);
        // Odstráni prípadné úvodzovky okolo hodnoty
        if (strlen($value) >= 2 && (
            ($value[0] === '"' && $value[-1] === '"') ||
            ($value[0] === "'" && $value[-1] === "'")
        )) {
            $value = substr($value, 1, -1);
        }
        if ($key === '') {
            continue;
        }
        if (getenv($key) === false) {
            putenv("{$key}={$value}");
        }
        $_ENV[$key] = $_ENV[$key] ?? $value;
    }
}

loadEnv(__DIR__ . '/../.env');

/** Vráti hodnotu env premennej alebo default. */
function envVal(string $key, string $default = ''): string
{
    $value = getenv($key);
    if ($value === false) {
        $value = $_ENV[$key] ?? null;
    }
    return $value === null || $value === false ? $default : (string) $value;
}
