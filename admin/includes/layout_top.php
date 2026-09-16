<?php
/**
 * Spoločná hlavička admin rozhrania.
 * Očakáva premennú $adminTitle a že requireAdminLogin() už bolo zavolané.
 */

declare(strict_types=1);

$adminTitle = $adminTitle ?? 'Administrácia';
$adminNav = [
    'index.php' => 'Prehľad',
    'content.php' => 'Texty stránok',
    'calculator.php' => 'Kalkulačka',
    'gallery.php' => 'Galéria fotiek',
    'brands.php' => 'Značky',
    'towns.php' => 'Obce',
    'settings.php' => 'Kontakt a nastavenia',
];
$currentScript = basename($_SERVER['SCRIPT_NAME']);
$flash = getFlash();
?>
<!DOCTYPE html>
<html lang="sk">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<title><?= e($adminTitle) ?> – Administrácia Klimatizácie Turiec</title>
<link rel="stylesheet" href="assets/admin.css?v=<?= (int) @filemtime(__DIR__ . '/../assets/admin.css') ?>">
</head>
<body>
<div class="admin-shell">
    <header class="admin-topbar">
        <div class="admin-topbar__brand">Klimatizácie Turiec <span>· administrácia</span></div>
        <nav class="admin-topbar__nav">
            <?php foreach ($adminNav as $href => $label): ?>
            <a href="<?= e($href) ?>" class="<?= $currentScript === $href ? 'is-active' : '' ?>"><?= e($label) ?></a>
            <?php endforeach; ?>
        </nav>
        <div class="admin-topbar__user">
            <span><?= e(currentAdminUsername()) ?></span>
            <a href="change-password.php">Zmeniť heslo</a>
            <a href="logout.php">Odhlásiť sa</a>
        </div>
    </header>
    <main class="admin-main">
        <div class="admin-container">
            <h1><?= e($adminTitle) ?></h1>
            <?php if ($flash): ?>
            <div class="admin-alert admin-alert--<?= e($flash['type']) ?>"><?= e($flash['message']) ?></div>
            <?php endif; ?>
