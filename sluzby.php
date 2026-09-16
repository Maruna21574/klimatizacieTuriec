<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$activePage = 'sluzby';
$pageTitle = cms('sluzby', 'seo_title');
$pageDescription = cms('sluzby', 'seo_description');

require_once __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
    <canvas class="hero-grid-canvas" aria-hidden="true"></canvas>
    <div class="container">
        <h1><?= cms('sluzby', 'hero_title') ?></h1>
        <p><?= cms('sluzby', 'hero_lead') ?></p>
    </div>
</section>

<section class="section" id="montaz">
    <div class="container service-detail">
        <div class="service-detail__text reveal">
            <span class="service-detail__icon"><?= icon('snowflake') ?></span>
            <h2><?= cms('sluzby', 'montaz_title') ?></h2>
            <p><?= cms('sluzby', 'montaz_desc') ?></p>
            <ul class="check-list">
                <li><?= icon('check') ?> <?= cms('sluzby', 'montaz_li_1') ?></li>
                <li><?= icon('check') ?> <?= cms('sluzby', 'montaz_li_2') ?></li>
                <li><?= icon('check') ?> <?= cms('sluzby', 'montaz_li_3') ?></li>
                <li><?= icon('check') ?> <?= cms('sluzby', 'montaz_li_4') ?></li>
            </ul>
        </div>
        <div class="service-detail__media reveal">
            <img src="assets/img/gallery/realizacia-01.jpg" alt="Montáž vonkajšej jednotky klimatizácie na fasáde domu" loading="lazy" width="560" height="420">
        </div>
    </div>
</section>

<section class="section section--alt" id="servis">
    <div class="container service-detail service-detail--reverse">
        <div class="service-detail__media reveal">
            <img src="assets/img/gallery/realizacia-07.jpg" alt="Servis a kontrola klimatizácie technikom" loading="lazy" width="560" height="420">
        </div>
        <div class="service-detail__text reveal">
            <span class="service-detail__icon"><?= icon('tool') ?></span>
            <h2><?= cms('sluzby', 'servis_title') ?></h2>
            <p><?= cms('sluzby', 'servis_desc') ?></p>
            <ul class="check-list">
                <li><?= icon('check') ?> <?= cms('sluzby', 'servis_li_1') ?></li>
                <li><?= icon('check') ?> <?= cms('sluzby', 'servis_li_2') ?></li>
                <li><?= icon('check') ?> <?= cms('sluzby', 'servis_li_3') ?></li>
                <li><?= icon('check') ?> <?= cms('sluzby', 'servis_li_4') ?></li>
            </ul>
        </div>
    </div>
</section>

<section class="section" id="diagnostika">
    <div class="container service-detail">
        <div class="service-detail__text reveal">
            <span class="service-detail__icon"><?= icon('gauge') ?></span>
            <h2><?= cms('sluzby', 'diagnostika_title') ?></h2>
            <p><?= cms('sluzby', 'diagnostika_desc') ?></p>
            <ul class="check-list">
                <li><?= icon('check') ?> <?= cms('sluzby', 'diagnostika_li_1') ?></li>
                <li><?= icon('check') ?> <?= cms('sluzby', 'diagnostika_li_2') ?></li>
                <li><?= icon('check') ?> <?= cms('sluzby', 'diagnostika_li_3') ?></li>
                <li><?= icon('check') ?> <?= cms('sluzby', 'diagnostika_li_4') ?></li>
            </ul>
        </div>
        <div class="service-detail__media reveal">
            <img src="assets/img/gallery/realizacia-04.jpg" alt="Meranie tlaku chladiva digitálnymi manometrami" loading="lazy" width="560" height="420">
        </div>
    </div>
</section>

<section class="section section--alt" id="poradenstvo">
    <div class="container service-detail service-detail--reverse">
        <div class="service-detail__media reveal">
            <img src="assets/img/gallery/realizacia-03.jpg" alt="Poradenstvo pri výbere klimatizácie" loading="lazy" width="560" height="420">
        </div>
        <div class="service-detail__text reveal">
            <span class="service-detail__icon"><?= icon('leaf') ?></span>
            <h2><?= cms('sluzby', 'poradenstvo_title') ?></h2>
            <p><?= cms('sluzby', 'poradenstvo_desc') ?></p>
            <ul class="check-list">
                <li><?= icon('check') ?> <?= cms('sluzby', 'poradenstvo_li_1') ?></li>
                <li><?= icon('check') ?> <?= cms('sluzby', 'poradenstvo_li_2') ?></li>
                <li><?= icon('check') ?> <?= cms('sluzby', 'poradenstvo_li_3') ?></li>
                <li><?= icon('check') ?> <?= cms('sluzby', 'poradenstvo_li_4') ?></li>
            </ul>
        </div>
    </div>
</section>

<section class="section brands">
    <div class="container">
        <div class="section__head reveal">
            <span class="section__kicker"><?= cms('sluzby', 'brands_kicker') ?></span>
            <h2><?= cms('sluzby', 'brands_title') ?></h2>
        </div>
        <div class="brands__row reveal">
            <?php foreach (brandList() as $b): ?>
            <span class="brands__item"><?= e($b['name']) ?></span>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
