<?php
declare(strict_types=1);

$activePage = 'o-nas';
$pageTitle = 'O nás – Klíma Turiec';
$pageDescription = 'Sme lokálny tím zameraný na montáž a servis klimatizácií v Turci. Poznáme miestne domy, byty aj firmy a robíme prácu, za ktorou si stojíme.';

require_once __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
    <canvas class="hero-grid-canvas" aria-hidden="true"></canvas>
    <div class="container">
        <h1>Robíme montáže, ktoré chceme mať aj vo vlastnom dome</h1>
        <p>Klíma Turiec je tím technikov zameraný výhradne na montáž, servis a čistenie klimatizácií v regióne Turiec. Pracujeme poctivo, bez zbytočného naťahovania termínov a s dôrazom na detail, ktorý sa oplatí až o pár rokov.</p>
    </div>
</section>

<section class="section">
    <div class="container about-grid">
        <div class="about-grid__text reveal">
            <span class="section__kicker">Náš príbeh</span>
            <h2>Od jednej montáže po stovky spokojných domácností</h2>
            <p>Začínali sme ako malý tím, ktorý montoval klimatizácie susedom a známym v Martine a Vrútkach. Dnes vďaka odporúčaniam pôsobíme v celom regióne Turiec – od Sučian po Turčianske Teplice – a za sebou máme stovky zrealizovaných montáží v rodinných domoch, bytoch aj menších prevádzkach.</p>
            <p>Nešpecializujeme sa na desiatky odborov naraz. Robíme jednu vec – klimatizácie – a robíme ju poriadne, od prvej obhliadky až po pravidelný servis.</p>
            <div class="about-grid__badges">
                <div class="about-badge"><?= icon('check-circle') ?><span>Poistenie zodpovednosti za škodu</span></div>
                <div class="about-badge"><?= icon('check-circle') ?><span>Preškolení technici na aktuálne značky</span></div>
                <div class="about-badge"><?= icon('check-circle') ?><span>Práca s tlakovými skúškami a vákuovaním</span></div>
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
            <span class="section__kicker">Naše hodnoty</span>
            <h2>Na čom nám záleží pri každej zákazke</h2>
        </div>
        <div class="values-grid">
            <div class="value-card reveal">
                <span class="value-card__icon"><?= icon('gauge') ?></span>
                <h3>Presnosť</h3>
                <p>Každú montáž kontrolujeme tlakovou skúškou a meraním – žiadne odhady, len overené hodnoty.</p>
            </div>
            <div class="value-card reveal">
                <span class="value-card__icon"><?= icon('spark') ?></span>
                <h3>Čistá práca</h3>
                <p>Potrubie vedieme v maskovacích lištách a po sebe upraceme – dom vyzerá, ako keby sme tam ani neboli.</p>
            </div>
            <div class="value-card reveal">
                <span class="value-card__icon"><?= icon('clock') ?></span>
                <h3>Dochvíľnosť</h3>
                <p>Dohodnutý termín dodržíme. Ak sa čokoľvek zmení, dáme vám vedieť vopred.</p>
            </div>
            <div class="value-card reveal">
                <span class="value-card__icon"><?= icon('shield') ?></span>
                <h3>Zodpovednosť</h3>
                <p>Za odvedenú prácu poskytujeme záruku a v prípade potreby sme dostupní aj po montáži.</p>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section__head reveal">
            <span class="section__kicker">Kde pôsobíme</span>
            <h2>Celý región Turiec</h2>
            <p>Realizujeme montáže a servis vo všetkých okolitých obciach a mestách.</p>
        </div>
        <div class="towns-grid reveal">
            <?php foreach (SERVICE_TOWNS as $town): ?>
            <span class="towns-grid__item"><?= icon('pin') ?> <?= e($town) ?></span>
            <?php endforeach; ?>
            <span class="towns-grid__item towns-grid__item--more"><?= icon('route') ?> a okolité obce</span>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
