<?php
/**
 * CLI skript: vytvorí databázové tabuľky (ak neexistujú) a naplní ich
 * pôvodným obsahom webu + vytvorí prvého admin používateľa.
 *
 * Spustenie:  php database/seed.php
 *
 * Bezpečné spúšťať opakovane - texty/nastavenia sa dopĺňajú len ak v DB
 * ešte neexistujú (existujúce úpravy z admin rozhrania sa NEPREPÍŠU).
 * Admin účet sa vytvorí len ak v tabuľke admin_users ešte žiadny nie je.
 */

declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit('Tento skript sa spúšťa len z príkazového riadku (CLI).');
}

require_once __DIR__ . '/../includes/db.php';

$pdo = db();
if ($pdo === null) {
    fwrite(STDERR, "Nepodarilo sa pripojiť na databázu. Skontroluj .env súbor (DB_HOST, DB_NAME, DB_USER, DB_PASS).\n");
    exit(1);
}

echo "Pripojené k databáze.\n";

// 1) Schéma -----------------------------------------------------------
$schema = file_get_contents(__DIR__ . '/schema.sql');
if ($schema === false) {
    fwrite(STDERR, "Nepodarilo sa načítať schema.sql\n");
    exit(1);
}
foreach (array_filter(array_map('trim', explode(';', $schema))) as $stmt) {
    $pdo->exec($stmt);
}
echo "Schéma vytvorená/skontrolovaná.\n";

// 2) Admin používateľ ---------------------------------------------------
$count = (int) $pdo->query('SELECT COUNT(*) FROM admin_users')->fetchColumn();
if ($count === 0) {
    $username = 'admin';
    $password = bin2hex(random_bytes(5)); // 10-znakové náhodné heslo
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare('INSERT INTO admin_users (username, password_hash) VALUES (?, ?)');
    $stmt->execute([$username, $hash]);
    echo "\n=========================================================\n";
    echo " Vytvorený admin účet:\n";
    echo "   meno:  {$username}\n";
    echo "   heslo: {$password}\n";
    echo " Po prvom prihlásení si heslo zmeň v admin/change-password.php\n";
    echo "=========================================================\n\n";
} else {
    echo "Admin účet už existuje, preskakujem.\n";
}

// 3) Texty stránok (page_content) ---------------------------------------
require_once __DIR__ . '/../includes/content.php';

$insPage = $pdo->prepare('INSERT IGNORE INTO page_content (page_slug, block_key, content_value) VALUES (?, ?, ?)');
$pageCount = 0;
foreach (pageContentRegistry() as $pageSlug => $page) {
    foreach ($page['blocks'] as $key => $def) {
        $insPage->execute([$pageSlug, $key, $def['default']]);
        $pageCount += $insPage->rowCount();
    }
}
echo "Texty stránok: doplnených {$pageCount} nových blokov (existujúce sa nemenili).\n";

// 4) Nastavenia kalkulačky ------------------------------------------------
$insCalc = $pdo->prepare('INSERT IGNORE INTO calculator_settings (setting_key, setting_value) VALUES (?, ?)');
$calcCount = 0;
foreach (calcSettingsRegistry() as $field) {
    $insCalc->execute([$field['key'], $field['default']]);
    $calcCount += $insCalc->rowCount();
}
echo "Kalkulačka: doplnených {$calcCount} nových nastavení.\n";

// 5) Firemné nastavenia (site_settings) ------------------------------------
require_once __DIR__ . '/../includes/config.php';

$defaults = [
    'phone_display' => PHONE_DISPLAY,
    'phone_tel' => PHONE_TEL,
    'email' => EMAIL_ADDR,
    'region' => SITE_REGION,
    'facebook_url' => FACEBOOK_URL,
    'instagram_url' => INSTAGRAM_URL,
    'google_reviews_url' => GOOGLE_REVIEWS_URL,
    'google_maps_embed' => GOOGLE_MAPS_EMBED,
    'opening_hours' => 'Po – Ne: 7:00 – 20:00',
];
$insSetting = $pdo->prepare('INSERT IGNORE INTO site_settings (setting_key, setting_value) VALUES (?, ?)');
$settingCount = 0;
foreach ($defaults as $key => $value) {
    $insSetting->execute([$key, $value]);
    $settingCount += $insSetting->rowCount();
}
echo "Firemné nastavenia: doplnených {$settingCount} nových položiek.\n";

// 6) Galéria ---------------------------------------------------------------
$galleryCount = (int) $pdo->query('SELECT COUNT(*) FROM gallery_images')->fetchColumn();
if ($galleryCount === 0) {
    $insGallery = $pdo->prepare('INSERT INTO gallery_images (filename, category, category_label, title, description, sort_order) VALUES (?, ?, ?, ?, ?, ?)');
    $order = 0;
    foreach (galleryItemsDefault() as $item) {
        $insGallery->execute([$item['file'], $item['category'], $item['categoryLabel'], $item['title'], $item['desc'], $order]);
        $order += 10;
    }
    echo 'Galéria: vložených ' . count(galleryItemsDefault()) . " pôvodných fotiek.\n";
} else {
    echo "Galéria už obsahuje záznamy, preskakujem.\n";
}

// 7) Značky ------------------------------------------------------------------
$brandCount = (int) $pdo->query('SELECT COUNT(*) FROM brands')->fetchColumn();
if ($brandCount === 0) {
    $insBrand = $pdo->prepare('INSERT INTO brands (name, sort_order) VALUES (?, ?)');
    $order = 0;
    foreach (brandListDefault() as $brand) {
        $insBrand->execute([$brand['name'], $order]);
        $order += 10;
    }
    echo 'Značky: vložených ' . count(brandListDefault()) . " položiek.\n";
} else {
    echo "Značky už existujú, preskakujem.\n";
}

// 8) Obce ---------------------------------------------------------------------
$townCount = (int) $pdo->query('SELECT COUNT(*) FROM service_towns')->fetchColumn();
if ($townCount === 0) {
    $insTown = $pdo->prepare('INSERT INTO service_towns (name, sort_order) VALUES (?, ?)');
    $order = 0;
    foreach (serviceTownsDefault() as $town) {
        $insTown->execute([$town, $order]);
        $order += 10;
    }
    echo 'Obce: vložených ' . count(serviceTownsDefault()) . " položiek.\n";
} else {
    echo "Obce už existujú, preskakujem.\n";
}

echo "\nHotovo. Admin je dostupný na /admin/\n";
