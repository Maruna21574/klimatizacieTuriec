<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$activePage = 'o-nas';
$pageTitle = cms('o-nas', 'seo_title');
$pageDescription = cms('o-nas', 'seo_description');

require_once __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
    <canvas class="hero-grid-canvas" aria-hidden="true"></canvas>
    <div class="container">
        <h1><?= cms('o-nas', 'hero_title') ?></h1>
        <p><?= cms('o-nas', 'hero_lead') ?></p>
    </div>
</section>

<section class="section">
    <div class="container about-grid">
        <div class="about-grid__text reveal">
            <span class="section__kicker"><?= cms('o-nas', 'story_kicker') ?></span>
            <h2><?= cms('o-nas', 'story_title') ?></h2>
            <p><?= cms('o-nas', 'story_p1') ?></p>
            <p><?= cms('o-nas', 'story_p2') ?></p>
            <div class="about-grid__badges">
                <div class="about-badge"><?= icon('check-circle') ?><span><?= cms('o-nas', 'badge_1') ?></span></div>
                <div class="about-badge"><?= icon('check-circle') ?><span><?= cms('o-nas', 'badge_2') ?></span></div>
                <div class="about-badge"><?= icon('check-circle') ?><span><?= cms('o-nas', 'badge_3') ?></span></div>
            </div>
        </div>
        <div class="about-grid__visual reveal">
            <div class="about-photo">
                <img src="assets/img/gallery/realizacia-05.jpg" alt="Technik pri montáži klimatizácie na rebríku" loading="lazy" width="520" height="640">
            </div>
        </div>
    </div>
</section>

<section class="section section--alt">
    <div class="container">
        <div class="section__head reveal">
            <span class="section__kicker"><?= cms('o-nas', 'values_kicker') ?></span>
            <h2><?= cms('o-nas', 'values_title') ?></h2>
        </div>
        <div class="values-grid">
            <div class="value-card reveal">
                <span class="value-card__icon"><?= icon('gauge') ?></span>
                <h3><?= cms('o-nas', 'value_1_title') ?></h3>
                <p><?= cms('o-nas', 'value_1_desc') ?></p>
            </div>
            <div class="value-card reveal">
                <span class="value-card__icon"><?= icon('spark') ?></span>
                <h3><?= cms('o-nas', 'value_2_title') ?></h3>
                <p><?= cms('o-nas', 'value_2_desc') ?></p>
            </div>
            <div class="value-card reveal">
                <span class="value-card__icon"><?= icon('clock') ?></span>
                <h3><?= cms('o-nas', 'value_3_title') ?></h3>
                <p><?= cms('o-nas', 'value_3_desc') ?></p>
            </div>
            <div class="value-card reveal">
                <span class="value-card__icon"><?= icon('shield') ?></span>
                <h3><?= cms('o-nas', 'value_4_title') ?></h3>
                <p><?= cms('o-nas', 'value_4_desc') ?></p>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section__head reveal">
            <span class="section__kicker"><?= cms('o-nas', 'towns_kicker') ?></span>
            <h2><?= cms('o-nas', 'towns_title') ?></h2>
            <p><?= cms('o-nas', 'towns_lead') ?></p>
        </div>
        <div class="towns-grid reveal">
            <?php foreach (serviceTowns() as $town): ?>
            <span class="towns-grid__item"><?= icon('pin') ?> <?= e($town) ?></span>
            <?php endforeach; ?>
            <span class="towns-grid__item towns-grid__item--more"><?= icon('route') ?> a okolité obce</span>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
