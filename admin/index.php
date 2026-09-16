<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/csrf.php';

requireAdminLogin();

$adminTitle = 'Prehľad';
require_once __DIR__ . '/includes/layout_top.php';
?>

<p class="admin-hint">Vitaj, <?= e(currentAdminUsername()) ?>. Tu môžeš upraviť všetky texty na webe, nastavenia kalkulačky, fotky v galérii a kontaktné údaje.</p>

<div class="admin-grid">
    <a class="admin-tile" href="content.php">
        <strong>Texty stránok</strong>
        <span>Nadpisy, popisy a texty na všetkých stránkach webu</span>
    </a>
    <a class="admin-tile" href="calculator.php">
        <strong>Kalkulačka</strong>
        <span>Koeficienty výpočtu výkonu a ceny montáže podľa veľkosti jednotky</span>
    </a>
    <a class="admin-tile" href="gallery.php">
        <strong>Galéria fotiek</strong>
        <span>Nahrávanie, úprava a mazanie fotiek realizácií</span>
    </a>
    <a class="admin-tile" href="brands.php">
        <strong>Značky</strong>
        <span>Zoznam montovaných značiek klimatizácií</span>
    </a>
    <a class="admin-tile" href="towns.php">
        <strong>Obce</strong>
        <span>Zoznam obcí a miest, kde firma pôsobí</span>
    </a>
    <a class="admin-tile" href="settings.php">
        <strong>Kontakt a nastavenia</strong>
        <span>Telefón, e-mail, sociálne siete, otváracie hodiny, mapa</span>
    </a>
</div>

<?php require_once __DIR__ . '/includes/layout_bottom.php'; ?>
