</main>

<div class="cta-strip">
    <div class="container">
        <div class="cta-band reveal">
            <div>
                <h2>Naplánujme si montáž ešte pred vlnou horúčav</h2>
                <p>Zavolajte alebo napíšte – do 24 hodín sa vám ozveme s nezáväznou cenovou ponukou.</p>
            </div>
            <div class="cta-band__actions">
                <a href="tel:<?= e(PHONE_TEL) ?>" class="btn btn--accent"><?= icon('phone') ?> <?= e(PHONE_DISPLAY) ?></a>
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
                    <?= renderLogo('white') ?>
                </div>
                <p class="site-footer__desc">Profesionálna montáž, servis a čistenie klimatizácií v Martine, Vrútkach a celom regióne Turiec. Kvalitne, spoľahlivo a za férovú cenu.</p>
                <div class="site-footer__social">
                    <?php if (FACEBOOK_URL): ?><a href="<?= e(FACEBOOK_URL) ?>" aria-label="Facebook" target="_blank" rel="noopener"><?= icon('facebook') ?></a><?php endif; ?>
                    <?php if (INSTAGRAM_URL): ?><a href="<?= e(INSTAGRAM_URL) ?>" aria-label="Instagram" target="_blank" rel="noopener"><?= icon('instagram') ?></a><?php endif; ?>
                    <a href="tel:<?= e(PHONE_TEL) ?>" aria-label="Zavolať"><?= icon('phone') ?></a>
                    <a href="mailto:<?= e(EMAIL_ADDR) ?>" aria-label="Napísať e-mail"><?= icon('mail') ?></a>
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
                </nav>
            </div>

            <div>
                <h4>Pôsobíme v obciach</h4>
                <nav class="site-footer__links" aria-label="Obce v regióne Turiec">
                    <?php foreach (array_slice(SERVICE_TOWNS, 0, 6) as $town): ?>
                    <span><?= e($town) ?></span>
                    <?php endforeach; ?>
                </nav>
            </div>

            <div>
                <h4>Kontakt</h4>
                <div class="site-footer__contact">
                    <div class="site-footer__contact-item"><?= icon('phone') ?> <a href="tel:<?= e(PHONE_TEL) ?>"><?= e(PHONE_DISPLAY) ?></a></div>
                    <div class="site-footer__contact-item"><?= icon('mail') ?> <a href="mailto:<?= e(EMAIL_ADDR) ?>"><?= e(EMAIL_ADDR) ?></a></div>
                    <div class="site-footer__contact-item"><?= icon('pin') ?> <span><?= e(SITE_REGION) ?></span></div>
                    <div class="site-footer__contact-item"><?= icon('clock') ?> <span>Po – Ne: 7:00 – 20:00</span></div>
                </div>
            </div>
        </div>

        <div class="site-footer__bottom">
            <span>&copy; <?= date('Y') ?> <?= e(SITE_FULLNAME) ?>. Všetky práva vyhradené.</span>
            <div class="site-footer__brands">
                <span>Montujeme značky:</span>
                <?php foreach (brandList() as $i => $b): ?><span><?= e($b['name']) ?><?= $i < count(brandList()) - 1 ? ' ·' : '' ?></span><?php endforeach; ?>
            </div>
        </div>
    </div>
</footer>

<button type="button" class="back-to-top" id="back-to-top" aria-label="Späť hore"><?= icon('arrow-up') ?></button>

<script src="<?= asset('assets/js/main.js') ?>" defer></script>
<script src="<?= asset('assets/js/hero-grid.js') ?>" defer></script>
<?php if ($activePage === 'kalkulacka'): ?>
<script src="<?= asset('assets/js/calculator.js') ?>" defer></script>
<?php endif; ?>
</body>
</html>
