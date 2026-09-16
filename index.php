<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$activePage = 'domov';
$pageTitle = cms('index', 'seo_title');
$pageDescription = cms('index', 'seo_description');

require_once __DIR__ . '/includes/header.php';
?>

<section class="hero">
    <div class="hero__bg" aria-hidden="true">
        <canvas class="hero-grid-canvas" aria-hidden="true"></canvas>
    </div>
    <div class="container hero__inner">
        <div class="hero__content reveal">
            <h1><?= cms('index', 'hero_title') ?></h1>
            <p class="hero__lead"><?= cms('index', 'hero_lead') ?></p>
            <div class="hero__actions">
                <a href="kontakt.php" class="btn btn--accent btn--lg"><?= icon('arrow-right') ?> Nezáväzná cenová ponuka</a>
                <a href="tel:<?= e(setting('phone_tel', PHONE_TEL)) ?>" class="btn btn--outline-light btn--lg"><?= icon('phone') ?> <?= e(setting('phone_display', PHONE_DISPLAY)) ?></a>
            </div>
            <ul class="hero__points">
                <li><?= icon('check') ?> <?= cms('index', 'hero_point_1') ?></li>
                <li><?= icon('check') ?> <?= cms('index', 'hero_point_2') ?></li>
                <li><?= icon('check') ?> <?= cms('index', 'hero_point_3') ?></li>
            </ul>
        </div>
        <div class="hero__visual reveal">
            <div class="hero__card hero__card--primary">
                <?= icon('snowflake') ?>
                <div>
                    <strong>Tichá prevádzka</strong>
                    <span>Príjemný spánok</span>
                </div>
            </div>
            <div class="hero__card hero__card--float">
                <?= icon('shield') ?>
                <div>
                    <strong>Záruka</strong>
                    <span>Montáž aj diely</span>
                </div>
            </div>
            <div class="hero__unit" aria-hidden="true">
                <img src="assets/img/gallery/realizacia-01.jpg" alt="" loading="lazy" width="800" height="600">
            </div>
        </div>
    </div>
</section>

<section class="section" id="sluzby-prehlad">
    <div class="container">
        <div class="section__head reveal">
            <span class="section__kicker"><?= cms('index', 'services_kicker') ?></span>
            <h2><?= cms('index', 'services_title') ?></h2>
            <p><?= cms('index', 'services_lead') ?></p>
        </div>
        <div class="service-grid">
            <article class="service-card reveal">
                <span class="service-card__icon"><?= icon('snowflake') ?></span>
                <h3><?= cms('index', 'service_1_title') ?></h3>
                <p><?= cms('index', 'service_1_desc') ?></p>
                <a href="sluzby.php#montaz">Viac o montáži <?= icon('arrow-right') ?></a>
            </article>
            <article class="service-card reveal">
                <span class="service-card__icon"><?= icon('tool') ?></span>
                <h3><?= cms('index', 'service_2_title') ?></h3>
                <p><?= cms('index', 'service_2_desc') ?></p>
                <a href="sluzby.php#servis">Viac o servise <?= icon('arrow-right') ?></a>
            </article>
            <article class="service-card reveal">
                <span class="service-card__icon"><?= icon('gauge') ?></span>
                <h3><?= cms('index', 'service_3_title') ?></h3>
                <p><?= cms('index', 'service_3_desc') ?></p>
                <a href="sluzby.php#diagnostika">Viac o diagnostike <?= icon('arrow-right') ?></a>
            </article>
            <article class="service-card reveal">
                <span class="service-card__icon"><?= icon('leaf') ?></span>
                <h3><?= cms('index', 'service_4_title') ?></h3>
                <p><?= cms('index', 'service_4_desc') ?></p>
                <a href="sluzby.php#poradenstvo">Viac o poradenstve <?= icon('arrow-right') ?></a>
            </article>
        </div>
    </div>
</section>

<section class="section section--alt">
    <div class="container why">
        <div class="why__visual reveal">
            <div class="why__frame">
                <img src="assets/img/gallery/realizacia-01.jpg" alt="Technik montuje klimatizáciu na fasáde rodinného domu" class="why__frame-img" loading="lazy" width="640" height="800">
                <div class="why__badge"><?= icon('star') ?> Overená kvalita</div>
            </div>
        </div>
        <div class="why__content reveal">
            <span class="section__kicker"><?= cms('index', 'why_kicker') ?></span>
            <h2><?= cms('index', 'why_title') ?></h2>
            <div class="why__list">
                <div class="why__item">
                    <span><?= icon('sun') ?></span>
                    <div>
                        <h4><?= cms('index', 'why_1_title') ?></h4>
                        <p><?= cms('index', 'why_1_desc') ?></p>
                    </div>
                </div>
                <div class="why__item">
                    <span><?= icon('shield') ?></span>
                    <div>
                        <h4><?= cms('index', 'why_2_title') ?></h4>
                        <p><?= cms('index', 'why_2_desc') ?></p>
                    </div>
                </div>
                <div class="why__item">
                    <span><?= icon('gauge') ?></span>
                    <div>
                        <h4><?= cms('index', 'why_3_title') ?></h4>
                        <p><?= cms('index', 'why_3_desc') ?></p>
                    </div>
                </div>
                <div class="why__item">
                    <span><?= icon('spark') ?></span>
                    <div>
                        <h4><?= cms('index', 'why_4_title') ?></h4>
                        <p><?= cms('index', 'why_4_desc') ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section__head reveal">
            <span class="section__kicker"><?= cms('index', 'process_kicker') ?></span>
            <h2><?= cms('index', 'process_title') ?></h2>
        </div>
        <div class="process">
            <div class="process__step reveal">
                <span class="process__num">1</span>
                <h3><?= cms('index', 'process_1_title') ?></h3>
                <p><?= cms('index', 'process_1_desc') ?></p>
            </div>
            <div class="process__step reveal">
                <span class="process__num">2</span>
                <h3><?= cms('index', 'process_2_title') ?></h3>
                <p><?= cms('index', 'process_2_desc') ?></p>
            </div>
            <div class="process__step reveal">
                <span class="process__num">3</span>
                <h3><?= cms('index', 'process_3_title') ?></h3>
                <p><?= cms('index', 'process_3_desc') ?></p>
            </div>
            <div class="process__step reveal">
                <span class="process__num">4</span>
                <h3><?= cms('index', 'process_4_title') ?></h3>
                <p><?= cms('index', 'process_4_desc') ?></p>
            </div>
        </div>
    </div>
</section>

<section class="section section--alt brands">
    <div class="container">
        <div class="section__head reveal">
            <span class="section__kicker"><?= cms('index', 'brands_kicker') ?></span>
            <h2><?= cms('index', 'brands_title') ?></h2>
        </div>
        <div class="brands__row reveal">
            <?php foreach (brandList() as $b): ?>
            <span class="brands__item"><?= e($b['name']) ?></span>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section__head section__head--split reveal">
            <div>
                <span class="section__kicker"><?= cms('index', 'gallery_kicker') ?></span>
                <h2><?= cms('index', 'gallery_title') ?></h2>
            </div>
            <a href="realizacie.php" class="btn btn--outline">Celá galéria <?= icon('arrow-right') ?></a>
        </div>
        <div class="gallery-preview">
            <?php foreach (array_slice(galleryItems(), 0, 4) as $item): ?>
            <a class="gallery-preview__item reveal" href="realizacie.php">
                <img src="assets/img/gallery/<?= e($item['file']) ?>" alt="<?= e($item['title']) ?>" loading="lazy" width="400" height="300">
                <span class="gallery-preview__label"><?= e($item['categoryLabel']) ?></span>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
