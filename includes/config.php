<?php
/**
 * Globálna konfigurácia webu Klimatizácie Turiec.
 * Načíta sa na začiatku každej stránky.
 */

declare(strict_types=1);

// --- Firemné údaje ---------------------------------------------------
define('SITE_NAME', 'Klimatizácie Turiec');
define('SITE_FULLNAME', 'Klimatizácie Turiec');
define('SITE_CLAIM', 'Montáž a servis klimatizácií');
define('SITE_REGION', 'Turiec a okolie');
define('SITE_URL', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https://' : 'http://') . ($_SERVER['HTTP_HOST'] ?? 'klimaturiec.sk'));

define('PHONE_DISPLAY', '0907 119 861');
define('PHONE_TEL', '+421907119861');
define('EMAIL_ADDR', 'matrotech@matrotech.sk');

define('FACEBOOK_URL', '');
define('INSTAGRAM_URL', '');
define('GOOGLE_REVIEWS_URL', '');
define('GOOGLE_MAPS_EMBED', 'https://www.google.com/maps?q=Martin,Slovensko&output=embed');

// Obce a mestá v regióne Turiec, kde firma pôsobí
define('SERVICE_TOWNS', ['Martin', 'Vrútky', 'Sučany', 'Turčianske Teplice', 'Kláštor pod Znievom', 'Mošovce', 'Blatnica', 'Necpaly', 'Diaková', 'Belá-Dulice']);

// --- Pomocné funkcie ---------------------------------------------------

/** Bezpečný výstup textu do HTML. */
function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

/**
 * Cesta k assetu s cache-busting parametrom podľa času poslednej zmeny súboru.
 */
function asset(string $path): string
{
    $full = __DIR__ . '/../' . ltrim($path, '/');
    $version = is_file($full) ? filemtime($full) : time();
    return e($path) . '?v=' . $version;
}

/** Vráti 'is-active' triedu, ak sa zhoduje aktuálna stránka. */
function navActive(string $page, ?string $current): string
{
    return $page === $current ? ' is-active' : '';
}

// brandList(), galleryItems(), serviceTowns() a editovateľné texty (cms/setting)
// sú od zavedenia CRM/admin rozhrania v includes/content.php (DB-backed, s fallbackom
// na pôvodné hodnoty vyššie, ak databáza nie je dostupná).
require_once __DIR__ . '/content.php';
