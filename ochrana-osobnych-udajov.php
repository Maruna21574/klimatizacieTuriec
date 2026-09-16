<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$activePage = '';
$pageTitle = cms('gdpr', 'seo_title');
$pageDescription = cms('gdpr', 'seo_description');

require_once __DIR__ . '/includes/header.php';

$bodyHtml = str_replace(
    ['{{SITE_FULLNAME}}', '{{EMAIL}}', '{{PHONE}}', '{{SITE_REGION}}'],
    [e(SITE_FULLNAME), e(setting('email', EMAIL_ADDR)), e(setting('phone_display', PHONE_DISPLAY)), e(setting('region', SITE_REGION))],
    cms('gdpr', 'body_html')
);
?>

<section class="page-hero">
    <canvas class="hero-grid-canvas" aria-hidden="true"></canvas>
    <div class="container">
        <h1><?= cms('gdpr', 'hero_title') ?></h1>
        <p><?= cms('gdpr', 'hero_lead') ?></p>
    </div>
</section>

<section class="section section--tight">
    <div class="container">
        <div class="legal-content reveal">
            <?= $bodyHtml ?>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
