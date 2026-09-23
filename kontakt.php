<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/antispam.php';

$activePage = 'kontakt';
$pageTitle = cms('kontakt', 'seo_title');
$pageDescription = cms('kontakt', 'seo_description');

require_once __DIR__ . '/includes/header.php';

$formSent = isset($_GET['odoslane']) && $_GET['odoslane'] === '1';
$formError = isset($_GET['chyba']) && $_GET['chyba'] === '1';
?>

<section class="page-hero">
    <canvas class="hero-grid-canvas" aria-hidden="true"></canvas>
    <div class="container">
        <h1><?= cms('kontakt', 'hero_title') ?></h1>
        <p><?= cms('kontakt', 'hero_lead') ?></p>
    </div>
</section>

<section class="section section--tight">
    <div class="container contact-grid">
        <div class="contact-cards reveal">
            <a href="tel:<?= e(setting('phone_tel', PHONE_TEL)) ?>" class="contact-card">
                <span class="contact-card__icon"><?= icon('phone') ?></span>
                <div>
                    <h3>Zavolajte nám</h3>
                    <span><?= e(setting('phone_display', PHONE_DISPLAY)) ?></span>
                </div>
            </a>
            <a href="mailto:<?= e(setting('email', EMAIL_ADDR)) ?>" class="contact-card">
                <span class="contact-card__icon"><?= icon('mail') ?></span>
                <div>
                    <h3>Napíšte e-mail</h3>
                    <span><?= e(setting('email', EMAIL_ADDR)) ?></span>
                </div>
            </a>
            <div class="contact-card">
                <span class="contact-card__icon"><?= icon('pin') ?></span>
                <div>
                    <h3>Pôsobíme v regióne</h3>
                    <span><?= e(setting('region', SITE_REGION)) ?></span>
                </div>
            </div>
            <div class="contact-card">
                <span class="contact-card__icon"><?= icon('clock') ?></span>
                <div>
                    <h3>Dostupnosť</h3>
                    <span><?= e(setting('opening_hours', 'Po – Ne: 7:00 – 20:00')) ?></span>
                </div>
            </div>
        </div>

        <div class="contact-form-wrap reveal" id="formular">
            <?php if ($formSent): ?>
            <div class="alert alert--success"><?= icon('check-circle') ?> <?= cms('kontakt', 'success_message') ?></div>
            <?php endif; ?>
            <?php if ($formError): ?>
            <div class="alert alert--error"><?= cms('kontakt', 'error_message') ?></div>
            <?php endif; ?>

            <form class="contact-form" action="send-mail.php" method="post" novalidate>
                <div class="form-row">
                    <label for="meno">Meno a priezvisko</label>
                    <input type="text" id="meno" name="meno" required autocomplete="name" placeholder="Vaše meno">
                </div>
                <div class="form-row form-row--split">
                    <div>
                        <label for="email">E-mail</label>
                        <input type="email" id="email" name="email" required autocomplete="email" placeholder="vas@email.sk">
                    </div>
                    <div>
                        <label for="telefon">Telefón</label>
                        <input type="tel" id="telefon" name="telefon" autocomplete="tel" placeholder="09XX XXX XXX">
                    </div>
                </div>
                <div class="form-row">
                    <label for="mesto">Mesto / obec</label>
                    <input type="text" id="mesto" name="mesto" placeholder="napr. Martin">
                </div>
                <div class="form-row">
                    <label for="sprava">Správa</label>
                    <textarea id="sprava" name="sprava" rows="5" required placeholder="Popíšte nám, o aký priestor ide a čo potrebujete..."></textarea>
                </div>
                <input type="text" name="website" class="hp-field" tabindex="-1" autocomplete="off" aria-hidden="true">
                <?= formTimestampField() ?>
                <button type="submit" class="btn btn--accent btn--lg btn--block"><?= icon('arrow-right') ?> Odoslať dopyt</button>
                <p class="contact-form__note"><?= cms('kontakt', 'form_note') ?></p>
            </form>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="map-frame reveal">
            <iframe src="<?= e(setting('google_maps_embed', GOOGLE_MAPS_EMBED)) ?>" width="100%" height="420" style="border:0;" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Mapa pôsobenia – región Turiec"></iframe>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
