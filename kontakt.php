<?php
declare(strict_types=1);

$activePage = 'kontakt';
$pageTitle = 'Kontakt – Klíma Turiec';
$pageDescription = 'Napíšte nám alebo zavolajte – radi vám pripravíme nezáväznú cenovú ponuku na montáž klimatizácie v regióne Turiec.';

require_once __DIR__ . '/includes/header.php';

$formSent = isset($_GET['odoslane']) && $_GET['odoslane'] === '1';
$formError = isset($_GET['chyba']) && $_GET['chyba'] === '1';
?>

<section class="page-hero">
    <canvas class="hero-grid-canvas" aria-hidden="true"></canvas>
    <div class="container">
        <h1>Poďme naplánovať vašu klimatizáciu</h1>
        <p>Napíšte nám pár slov o tom, čo potrebujete, alebo rovno zavolajte. Ozveme sa spravidla do 24 hodín s nezáväznou ponukou.</p>
    </div>
</section>

<section class="section section--tight">
    <div class="container contact-grid">
        <div class="contact-cards reveal">
            <a href="tel:<?= e(PHONE_TEL) ?>" class="contact-card">
                <span class="contact-card__icon"><?= icon('phone') ?></span>
                <div>
                    <h3>Zavolajte nám</h3>
                    <span><?= e(PHONE_DISPLAY) ?></span>
                </div>
            </a>
            <a href="mailto:<?= e(EMAIL_ADDR) ?>" class="contact-card">
                <span class="contact-card__icon"><?= icon('mail') ?></span>
                <div>
                    <h3>Napíšte e-mail</h3>
                    <span><?= e(EMAIL_ADDR) ?></span>
                </div>
            </a>
            <div class="contact-card">
                <span class="contact-card__icon"><?= icon('pin') ?></span>
                <div>
                    <h3>Pôsobíme v regióne</h3>
                    <span><?= e(SITE_REGION) ?></span>
                </div>
            </div>
            <div class="contact-card">
                <span class="contact-card__icon"><?= icon('clock') ?></span>
                <div>
                    <h3>Dostupnosť</h3>
                    <span>Po – Ne: 7:00 – 20:00</span>
                </div>
            </div>
        </div>

        <div class="contact-form-wrap reveal" id="formular">
            <?php if ($formSent): ?>
            <div class="alert alert--success"><?= icon('check-circle') ?> Ďakujeme! Správa bola odoslaná, ozveme sa vám čo najskôr.</div>
            <?php endif; ?>
            <?php if ($formError): ?>
            <div class="alert alert--error">Správu sa nepodarilo odoslať. Skúste to prosím znova alebo nám zavolajte.</div>
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
                <button type="submit" class="btn btn--accent btn--lg btn--block"><?= icon('arrow-right') ?> Odoslať dopyt</button>
                <p class="contact-form__note">Odoslaním súhlasíte so spracovaním údajov za účelom vybavenia vášho dopytu.</p>
            </form>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="map-frame reveal">
            <iframe src="<?= e(GOOGLE_MAPS_EMBED) ?>" width="100%" height="420" style="border:0;" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Mapa pôsobenia – región Turiec"></iframe>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
