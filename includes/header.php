<?php
/**
 * Spoločná hlavička (head + topbar + hlavné menu).
 * Očakáva premenné nastavené pred include:
 *   $pageTitle        - <title>
 *   $pageDescription  - meta description
 *   $activePage       - kľúč aktuálnej stránky pre zvýraznenie v menu
 */

declare(strict_types=1);

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/icons.php';
require_once __DIR__ . '/logo.php';

$activePage = $activePage ?? '';
$pageTitle = $pageTitle ?? SITE_NAME . ' – Montáž a servis klimatizácií v Turci';
$pageDescription = $pageDescription ?? 'Profesionálna montáž, servis a čistenie klimatizácií v Martine, Vrútkach a celom Turci. Všetky značky, rýchle termíny, férové ceny.';

$navItems = [
    'domov' => ['label' => 'Domov', 'href' => 'index.php'],
    'o-nas' => ['label' => 'O nás', 'href' => 'o-nas.php'],
    'sluzby' => ['label' => 'Služby', 'href' => 'sluzby.php'],
    'kalkulacka' => ['label' => 'Kalkulačka', 'href' => 'kalkulacka.php'],
    'realizacie' => ['label' => 'Realizácie', 'href' => 'realizacie.php'],
    'kontakt' => ['label' => 'Kontakt', 'href' => 'kontakt.php'],
];
?>
<!DOCTYPE html>
<html lang="sk" class="no-js">
<head>
<script>document.documentElement.classList.replace('no-js', 'js');</script>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($pageTitle) ?></title>
<meta name="description" content="<?= e($pageDescription) ?>">
<meta name="theme-color" content="#0a2650">
<link rel="canonical" href="<?= e(SITE_URL . '/' . basename($_SERVER['PHP_SELF'])) ?>">

<meta property="og:type" content="website">
<meta property="og:site_name" content="<?= e(SITE_NAME) ?>">
<meta property="og:title" content="<?= e($pageTitle) ?>">
<meta property="og:description" content="<?= e($pageDescription) ?>">
<meta property="og:image" content="<?= e(SITE_URL) ?>/assets/img/og-image.jpg">
<meta property="og:locale" content="sk_SK">

<link rel="icon" href="<?= asset('assets/img/favicon-32.png') ?>" sizes="32x32" type="image/png">
<link rel="icon" href="<?= asset('assets/img/favicon-64.png') ?>" sizes="64x64" type="image/png">
<link rel="apple-touch-icon" href="<?= asset('assets/img/apple-touch-icon.png') ?>">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">

<link rel="stylesheet" href="<?= asset('assets/css/style.css') ?>">

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "HVACBusiness",
  "name": "<?= e(SITE_NAME) ?>",
  "telephone": "<?= e(PHONE_TEL) ?>",
  "email": "<?= e(EMAIL_ADDR) ?>",
  "areaServed": "<?= e(SITE_REGION) ?>",
  "address": {
    "@type": "PostalAddress",
    "addressRegion": "Turiec",
    "addressCountry": "SK"
  },
  "url": "<?= e(SITE_URL) ?>"
}
</script>
</head>
<body>
<a class="skip-link" href="#hlavny-obsah">Preskočiť na obsah</a>

<div class="topbar">
    <div class="container">
        <div class="topbar__contact">
            <a href="tel:<?= e(PHONE_TEL) ?>"><?= icon('phone') ?> <?= e(PHONE_DISPLAY) ?></a>
            <a href="mailto:<?= e(EMAIL_ADDR) ?>"><?= icon('mail') ?> <?= e(EMAIL_ADDR) ?></a>
        </div>
        <span class="topbar__tag"><?= icon('pin') ?> Pôsobíme v regióne <?= e(SITE_REGION) ?></span>
    </div>
</div>

<header class="site-header" id="site-header">
    <div class="container">
        <a href="index.php" class="brand" aria-label="<?= e(SITE_NAME) ?> – domov">
            <picture>
                <source srcset="<?= asset('assets/img/logo-nav.webp') ?>" type="image/webp">
                <img src="<?= asset('assets/img/logo-nav.png') ?>" alt="<?= e(SITE_NAME) ?>" class="brand-logo-img" width="480" height="313">
            </picture>
        </a>

        <nav class="main-nav" aria-label="Hlavná navigácia">
            <ul class="main-nav__list">
                <?php foreach ($navItems as $key => $item): ?>
                <li><a class="main-nav__link<?= navActive($key, $activePage) ?>" href="<?= e($item['href']) ?>"<?= $key === $activePage ? ' aria-current="page"' : '' ?>><?= e($item['label']) ?></a></li>
                <?php endforeach; ?>
            </ul>
        </nav>

        <div class="header-actions">
            <a href="kontakt.php" class="btn btn--accent btn--sm"><?= icon('arrow-right') ?> Nezáväzná ponuka</a>
            <button type="button" class="nav-toggle" id="nav-open" aria-label="Otvoriť menu" aria-expanded="false" aria-controls="mobile-nav">
                <?= icon('menu') ?>
            </button>
        </div>
    </div>
</header>

<div class="mobile-nav" id="mobile-nav">
    <div class="mobile-nav__backdrop" data-nav-close></div>
    <div class="mobile-nav__panel" role="dialog" aria-modal="true" aria-label="Mobilné menu">
        <div class="mobile-nav__top">
            <picture>
                <source srcset="<?= asset('assets/img/logo-nav.webp') ?>" type="image/webp">
                <img src="<?= asset('assets/img/logo-nav.png') ?>" alt="<?= e(SITE_NAME) ?>" class="brand-logo-img" width="480" height="313">
            </picture>
            <button type="button" class="mobile-nav__close" id="nav-close" aria-label="Zavrieť menu">
                <?= icon('close') ?>
            </button>
        </div>
        <ul class="mobile-nav__list">
            <?php foreach ($navItems as $key => $item): ?>
            <li><a class="mobile-nav__link<?= navActive($key, $activePage) ?>" href="<?= e($item['href']) ?>"><?= e($item['label']) ?></a></li>
            <?php endforeach; ?>
        </ul>
        <div class="mobile-nav__foot">
            <a href="tel:<?= e(PHONE_TEL) ?>" class="btn btn--outline btn--block"><?= icon('phone') ?> <?= e(PHONE_DISPLAY) ?></a>
            <a href="kontakt.php" class="btn btn--accent btn--block"><?= icon('arrow-right') ?> Nezáväzná ponuka</a>
        </div>
    </div>
</div>

<main id="hlavny-obsah">
