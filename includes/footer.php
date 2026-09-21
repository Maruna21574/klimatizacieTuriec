</main>

<div class="cta-strip">
    <div class="container">
        <div class="cta-band reveal">
            <div>
                <h2><?= cms('global', 'cta_title') ?></h2>
                <p><?= cms('global', 'cta_desc') ?></p>
            </div>
            <div class="cta-band__actions">
                <a href="tel:<?= e(setting('phone_tel', PHONE_TEL)) ?>" class="btn btn--accent"><?= icon('phone') ?> <?= e(setting('phone_display', PHONE_DISPLAY)) ?></a>
                <a href="kontakt.php" class="btn btn--outline-light"><?= icon('mail') ?> Napísať správu</a>
            </div>
        </div>
    </div>
</div>

<footer class="site-footer">
    <div class="container">
        <div class="site-footer__top">
            <div>
                <div class="site-footer__brand">
                    <img src="<?= asset('assets/img/logo-white.png') ?>" alt="<?= e(SITE_NAME) ?>" class="footer-logo-img" width="831" height="440">
                </div>
                <p class="site-footer__desc"><?= cms('global', 'footer_desc') ?></p>
                <div class="site-footer__social">
                    <?php if (setting('facebook_url', FACEBOOK_URL)): ?><a href="<?= e(setting('facebook_url', FACEBOOK_URL)) ?>" aria-label="Facebook" target="_blank" rel="noopener"><?= icon('facebook') ?></a><?php endif; ?>
                    <?php if (setting('instagram_url', INSTAGRAM_URL)): ?><a href="<?= e(setting('instagram_url', INSTAGRAM_URL)) ?>" aria-label="Instagram" target="_blank" rel="noopener"><?= icon('instagram') ?></a><?php endif; ?>
                    <a href="tel:<?= e(setting('phone_tel', PHONE_TEL)) ?>" aria-label="Zavolať"><?= icon('phone') ?></a>
                    <a href="mailto:<?= e(setting('email', EMAIL_ADDR)) ?>" aria-label="Napísať e-mail"><?= icon('mail') ?></a>
                </div>
            </div>

            <div>
                <h4>Navigácia</h4>
                <nav class="site-footer__links" aria-label="Odkazy v pätičke">
                    <a href="index.php">Domov</a>
                    <a href="o-nas.php">O nás</a>
                    <a href="sluzby.php">Služby</a>
                    <a href="realizacie.php">Realizácie</a>
                    <a href="kontakt.php">Kontakt</a>
                    <a href="ochrana-osobnych-udajov.php">Ochrana osobných údajov</a>
                </nav>
            </div>

            <div>
                <h4>Kontakt</h4>
                <div class="site-footer__contact">
                    <div class="site-footer__contact-item"><?= icon('phone') ?> <a href="tel:<?= e(setting('phone_tel', PHONE_TEL)) ?>"><?= e(setting('phone_display', PHONE_DISPLAY)) ?></a></div>
                    <div class="site-footer__contact-item"><?= icon('mail') ?> <a href="mailto:<?= e(setting('email', EMAIL_ADDR)) ?>"><?= e(setting('email', EMAIL_ADDR)) ?></a></div>
                    <div class="site-footer__contact-item"><?= icon('pin') ?> <span><?= e(setting('region', SITE_REGION)) ?></span></div>
                    <div class="site-footer__contact-item"><?= icon('clock') ?> <span><?= e(setting('opening_hours', 'Po – Ne: 7:00 – 20:00')) ?></span></div>
                </div>
            </div>
        </div>

        <div class="site-footer__bottom">
            <span>&copy; <?= date('Y') ?> <?= e(SITE_FULLNAME) ?>. Všetky práva vyhradené. · <button type="button" class="cookie-settings-link" data-cookie-settings>Nastavenia cookies</button></span>
            <div class="site-footer__brands">
                <span>Montujeme značky:</span>
                <?php foreach (brandList() as $i => $b): ?><span><?= e($b['name']) ?><?= $i < count(brandList()) - 1 ? ' ·' : '' ?></span><?php endforeach; ?>
            </div>
        </div>
    </div>
</footer>

<button type="button" class="back-to-top" id="back-to-top" aria-label="Späť hore"><?= icon('arrow-up') ?></button>

<button type="button" class="cookie-fab" id="cookie-fab" data-cookie-settings aria-label="Nastavenia cookies" title="Nastavenia cookies"><?= icon('cookie') ?></button>

<div class="cookie-banner" id="cookie-banner" hidden role="dialog" aria-label="Súhlas s cookies">
    <div class="cookie-banner__inner">
        <div class="cookie-banner__text">
            <strong><?= cms('global', 'cookie_title') ?></strong>
            <p><?= cms('global', 'cookie_text') ?></p>
        </div>
        <div class="cookie-banner__actions">
            <a href="ochrana-osobnych-udajov.php" class="cookie-banner__link">Viac informácií</a>
            <button type="button" class="btn btn--outline-light btn--sm" id="cookie-reject">Iba nevyhnutné</button>
            <button type="button" class="btn btn--accent btn--sm" id="cookie-accept">Prijať všetky</button>
        </div>
    </div>
</div>

<script src="<?= asset('assets/js/main.js') ?>" defer></script>
<script src="<?= asset('assets/js/hero-grid.js') ?>" defer></script>
<script src="<?= asset('assets/js/cookie-consent.js') ?>" defer></script>
<?php if ($activePage === 'kalkulacka'): ?>
<script src="<?= asset('assets/js/calculator.js') ?>" defer></script>
<?php endif; ?>
</body>
</html>
