<?php
declare(strict_types=1);

$activePage = 'domov';
$pageTitle = 'Klíma Turiec – Montáž a servis klimatizácií v Martine a Turci';
$pageDescription = 'Montáž, servis a čistenie klimatizácií v Martine, Vrútkach a celom regióne Turiec. Bezplatná obhliadka, rýchle termíny, záruka na montáž.';

require_once __DIR__ . '/includes/header.php';
?>

<section class="hero">
    <div class="hero__bg" aria-hidden="true">
        <canvas class="hero-grid-canvas" aria-hidden="true"></canvas>
    </div>
    <div class="container hero__inner">
        <div class="hero__content reveal">
            <h1>Príjemný chlad vo vašom&nbsp;dome, <span>presne podľa vašich predstáv</span></h1>
            <p class="hero__lead">Montujeme, servisujeme a čistíme klimatizácie všetkých značiek. Od obhliadky po spustenie zvládneme montáž rodinného domu alebo bytu spravidla do pár dní.</p>
            <div class="hero__actions">
                <a href="kontakt.php" class="btn btn--accent btn--lg"><?= icon('arrow-right') ?> Nezáväzná cenová ponuka</a>
                <a href="tel:<?= e(PHONE_TEL) ?>" class="btn btn--outline-light btn--lg"><?= icon('phone') ?> <?= e(PHONE_DISPLAY) ?></a>
            </div>
            <ul class="hero__points">
                <li><?= icon('check') ?> Bezplatná obhliadka a návrh riešenia</li>
                <li><?= icon('check') ?> Montáž do 1–2 týždňov</li>
                <li><?= icon('check') ?> Záruka na montáž aj servis</li>
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
            <span class="section__kicker">Čo pre vás urobíme</span>
            <h2>Kompletné služby okolo klimatizácie</h2>
            <p>Od prvého telefonátu až po pravidelný servis – všetko zastrešíme jeden dodávateľ.</p>
        </div>
        <div class="service-grid">
            <article class="service-card reveal">
                <span class="service-card__icon"><?= icon('snowflake') ?></span>
                <h3>Montáž klimatizácií</h3>
                <p>Nástenné aj multisplit jednotky pre rodinné domy, byty a prevádzky – čisté vedenie potrubia, odborné zapojenie.</p>
                <a href="sluzby.php#montaz">Viac o montáži <?= icon('arrow-right') ?></a>
            </article>
            <article class="service-card reveal">
                <span class="service-card__icon"><?= icon('tool') ?></span>
                <h3>Servis a čistenie</h3>
                <p>Pravidelná údržba, dezinfekcia a čistenie filtrov predĺžia životnosť jednotky a udržia zdravý vzduch.</p>
                <a href="sluzby.php#servis">Viac o servise <?= icon('arrow-right') ?></a>
            </article>
            <article class="service-card reveal">
                <span class="service-card__icon"><?= icon('gauge') ?></span>
                <h3>Diagnostika a chladivo</h3>
                <p>Meranie tlaku, dopĺňanie chladiva a odstránenie porúch pomocou digitálnych manometrov.</p>
                <a href="sluzby.php#diagnostika">Viac o diagnostike <?= icon('arrow-right') ?></a>
            </article>
            <article class="service-card reveal">
                <span class="service-card__icon"><?= icon('leaf') ?></span>
                <h3>Poradenstvo a výber</h3>
                <p>Poradíme s výkonom, umiestnením aj vhodnou značkou podľa veľkosti a orientácie priestoru.</p>
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
            <span class="section__kicker">Prečo si vybrať nás</span>
            <h2>Montáž, na ktorú sa môžete spoľahnúť</h2>
            <div class="why__list">
                <div class="why__item">
                    <span><?= icon('sun') ?></span>
                    <div>
                        <h4>Rýchle termíny</h4>
                        <p>Väčšinu montáží zrealizujeme do 1–2 týždňov od obhliadky, v sezóne aj skôr.</p>
                    </div>
                </div>
                <div class="why__item">
                    <span><?= icon('shield') ?></span>
                    <div>
                        <h4>Záruka a poistenie</h4>
                        <p>Na montáž aj prácu poskytujeme záruku, práce vykonávame s poistením zodpovednosti.</p>
                    </div>
                </div>
                <div class="why__item">
                    <span><?= icon('gauge') ?></span>
                    <div>
                        <h4>Odborná montáž</h4>
                        <p>Tlakové skúšky, vákuovanie a presné dávkovanie chladiva pri každej inštalácii.</p>
                    </div>
                </div>
                <div class="why__item">
                    <span><?= icon('spark') ?></span>
                    <div>
                        <h4>Čistá práca</h4>
                        <p>Estetické vedenie potrubia v maskovacích lištách a upratané pracovisko po montáži.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section__head reveal">
            <span class="section__kicker">Ako to prebieha</span>
            <h2>Od obhliadky po spustenie v 4 krokoch</h2>
        </div>
        <div class="process">
            <div class="process__step reveal">
                <span class="process__num">1</span>
                <h3>Obhliadka a ponuka</h3>
                <p>Prídeme k vám, prezrieme priestor a do 24 hodín pošleme nezáväznú cenovú ponuku.</p>
            </div>
            <div class="process__step reveal">
                <span class="process__num">2</span>
                <h3>Návrh riešenia</h3>
                <p>Odporučíme výkon a umiestnenie jednotky presne podľa vášho priestoru a potrieb.</p>
            </div>
            <div class="process__step reveal">
                <span class="process__num">3</span>
                <h3>Montáž</h3>
                <p>Odborná inštalácia, tlaková skúška a vákuovanie okruhu skúsenými technikmi.</p>
            </div>
            <div class="process__step reveal">
                <span class="process__num">4</span>
                <h3>Spustenie a servis</h3>
                <p>Zaškolíme vás v ovládaní a v prípade záujmu zabezpečíme pravidelný servis.</p>
            </div>
        </div>
    </div>
</section>

<section class="section section--alt brands">
    <div class="container">
        <div class="section__head reveal">
            <span class="section__kicker">Montujeme overené značky</span>
            <h2>Klimatizácie, ktorým môžete dôverovať</h2>
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
                <span class="section__kicker">Naša práca</span>
                <h2>Vybrané realizácie</h2>
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
