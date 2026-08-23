<?php
/**
 * Globálna konfigurácia webu Klíma Turiec.
 * Načíta sa na začiatku každej stránky.
 */

declare(strict_types=1);

// --- Firemné údaje ---------------------------------------------------
define('SITE_NAME', 'Klíma Turiec');
define('SITE_FULLNAME', 'Klimatizácie Turiec');
define('SITE_CLAIM', 'Montáž a servis klimatizácií');
define('SITE_REGION', 'Turiec a okolie');
define('SITE_URL', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https://' : 'http://') . ($_SERVER['HTTP_HOST'] ?? 'klimaturiec.sk'));

define('PHONE_DISPLAY', '0907 119 861');
define('PHONE_TEL', '+421907119861');
// TODO: uprav na reálny e-mail a doménu firmy pred nasadením na hosting
define('EMAIL_ADDR', 'info@klimaturiec.sk');

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

/**
 * Zoznam značiek klimatizácií, ktoré firma montuje.
 */
function brandList(): array
{
    return [
        ['slug' => 'midea', 'name' => 'Midea'],
        ['slug' => 'viessmann', 'name' => 'Viessmann'],
        ['slug' => 'baxi', 'name' => 'Baxi'],
        ['slug' => 'daikin', 'name' => 'Daikin'],
        ['slug' => 'lg', 'name' => 'LG'],
        ['slug' => 'samsung', 'name' => 'Samsung'],
        ['slug' => 'gree', 'name' => 'Gree'],
        ['slug' => 'toshiba', 'name' => 'Toshiba'],
    ];
}

/**
 * Položky galérie realizácií. Obrázky očakávané v assets/img/gallery/{file}.
 */
function galleryItems(): array
{
    return [
        [
            'file' => 'realizacia-01.jpg',
            'category' => 'rodinne-domy',
            'categoryLabel' => 'Rodinný dom',
            'title' => 'Montáž klimatizácie Baxi na fasáde',
            'desc' => 'Vonkajšia jednotka Baxi na fasáde rodinného domu, čisté vertikálne vedenie potrubia.',
        ],
        [
            'file' => 'realizacia-02.jpg',
            'category' => 'rodinne-domy',
            'categoryLabel' => 'Rodinný dom',
            'title' => 'Klimatizácia Viessmann pod strechou terasy',
            'desc' => 'Montáž vonkajšej jednotky Viessmann pod prístreškom, vrátane zapojenia rozvodov.',
        ],
        [
            'file' => 'realizacia-03.jpg',
            'category' => 'exterier',
            'categoryLabel' => 'Exteriér',
            'title' => 'Klimatizácia Midea pri bazéne',
            'desc' => 'Kompaktné umiestnenie vonkajšej jednotky Midea nad terasou so záhradným bazénom.',
        ],
        [
            'file' => 'realizacia-04.jpg',
            'category' => 'servis',
            'categoryLabel' => 'Servis',
            'title' => 'Zapojenie a tlaková skúška',
            'desc' => 'Odborné elektrické zapojenie a meranie tlaku chladiva digitálnymi manometrami.',
        ],
        [
            'file' => 'realizacia-05.jpg',
            'category' => 'rodinne-domy',
            'categoryLabel' => 'Rodinný dom',
            'title' => 'Montáž klimatizácie na rebríku',
            'desc' => 'Bezpečné uchytenie a zapojenie vonkajšej jednotky Viessmann vo výške.',
        ],
        [
            'file' => 'realizacia-06.jpg',
            'category' => 'rodinne-domy',
            'categoryLabel' => 'Rodinný dom',
            'title' => 'Klimatizácia Midea na rodinnom dome',
            'desc' => 'Nová montáž vonkajšej jednotky Midea pri záhrade a hospodárskej budove.',
        ],
        [
            'file' => 'realizacia-07.jpg',
            'category' => 'servis',
            'categoryLabel' => 'Servis',
            'title' => 'Servis a kontrola klimatizácie technikom',
            'desc' => 'Kontrola zapojenia a nastavenie vonkajšej jednotky po montáži.',
        ],
        [
            'file' => 'realizacia-08.jpg',
            'category' => 'rodinne-domy',
            'categoryLabel' => 'Rodinný dom',
            'title' => 'Čisté vedenie potrubia na poschodovom dome',
            'desc' => 'Estetické vertikálne vedenie chladiva popri fasáde k jednotke Midea.',
        ],
        [
            'file' => 'realizacia-09.jpg',
            'category' => 'rodinne-domy',
            'categoryLabel' => 'Rodinný dom',
            'title' => 'Montáž vo výške v tíme dvoch technikov',
            'desc' => 'Spoločná montáž krytu potrubia popri odkvapovej rúre vo väčšej výške.',
        ],
        [
            'file' => 'realizacia-10.jpg',
            'category' => 'rodinne-domy',
            'categoryLabel' => 'Rodinný dom',
            'title' => 'Montáž klimatizácie pod strechou',
            'desc' => 'Zapojenie vonkajšej jednotky vo výške pri streche rodinného domu.',
        ],
        [
            'file' => 'realizacia-11.jpg',
            'category' => 'rodinne-domy',
            'categoryLabel' => 'Rodinný dom',
            'title' => 'Klimatizácia Midea na staršom rodinnom dome',
            'desc' => 'Nová montáž vonkajšej jednotky Midea na fasáde rodinného domu.',
        ],
    ];
}
