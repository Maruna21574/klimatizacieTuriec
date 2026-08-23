<?php
declare(strict_types=1);

$activePage = 'sluzby';
$pageTitle = 'Služby – montáž, servis a čistenie klimatizácií | Klíma Turiec';
$pageDescription = 'Montáž klimatizácií, servis, čistenie, diagnostika a doplnenie chladiva. Poradenstvo pri výbere vhodnej klimatizácie pre dom, byt aj prevádzku.';

require_once __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
    <canvas class="hero-grid-canvas" aria-hidden="true"></canvas>
    <div class="container">
        <h1>Všetko okolo klimatizácie na jednom mieste</h1>
        <p>Od výberu vhodného typu jednotky, cez odbornú montáž, až po pravidelný servis a čistenie. Pracujeme so všetkými bežnými značkami klimatizácií.</p>
    </div>
</section>

<section class="section" id="montaz">
    <div class="container service-detail">
        <div class="service-detail__text reveal">
            <span class="service-detail__icon"><?= icon('snowflake') ?></span>
            <h2>Montáž klimatizácií</h2>
            <p>Realizujeme montáž nástenných aj multisplit klimatizácií pre rodinné domy, byty, kancelárie a menšie prevádzky. Súčasťou montáže je návrh optimálneho umiestnenia vnútornej aj vonkajšej jednotky, vedenie potrubia v maskovacích lištách, elektrické zapojenie, tlaková skúška, vákuovanie okruhu a odborné spustenie.</p>
            <ul class="check-list">
                <li><?= icon('check') ?> Nástenné aj multisplit jednotky</li>
                <li><?= icon('check') ?> Rodinné domy, byty aj prevádzky</li>
                <li><?= icon('check') ?> Čisté vedenie potrubia v lištách</li>
                <li><?= icon('check') ?> Tlaková skúška a vákuovanie okruhu</li>
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
            <h2>Servis a čistenie</h2>
            <p>Pravidelný servis predlžuje životnosť klimatizácie a udržiava zdravý vzduch v priestore. Vyčistíme filtre a výmenník, skontrolujeme tesnosť okruhu, funkčnosť odvodu kondenzátu a v prípade potreby vykonáme dezinfekciu jednotky.</p>
            <ul class="check-list">
                <li><?= icon('check') ?> Čistenie filtrov a výmenníka</li>
                <li><?= icon('check') ?> Dezinfekcia vnútornej jednotky</li>
                <li><?= icon('check') ?> Kontrola odvodu kondenzátu</li>
                <li><?= icon('check') ?> Odporúčaný servis raz ročne</li>
            </ul>
        </div>
    </div>
</section>

<section class="section" id="diagnostika">
    <div class="container service-detail">
        <div class="service-detail__text reveal">
            <span class="service-detail__icon"><?= icon('gauge') ?></span>
            <h2>Diagnostika a doplnenie chladiva</h2>
            <p>Ak klimatizácia nechladí ako má, príčinou je často únik alebo nedostatok chladiva. Digitálnymi manometrami zmeriame tlak v okruhu, nájdeme prípadný únik a chladivo bezpečne doplníme na presnú hodnotu podľa výrobcu.</p>
            <ul class="check-list">
                <li><?= icon('check') ?> Meranie tlaku digitálnymi manometrami</li>
                <li><?= icon('check') ?> Vyhľadanie a odstránenie úniku</li>
                <li><?= icon('check') ?> Presné doplnenie chladiva</li>
                <li><?= icon('check') ?> Odstránenie bežných porúch</li>
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
            <h2>Poradenstvo a výber jednotky</h2>
            <p>Nie každý priestor potrebuje rovnaký výkon. Pri obhliadke posúdime veľkosť a orientáciu miestnosti, počet okien aj zdroje tepla a odporučíme vhodný výkon, typ aj umiestnenie jednotky – bez zbytočného predimenzovania.</p>
            <ul class="check-list">
                <li><?= icon('check') ?> Výpočet vhodného výkonu jednotky</li>
                <li><?= icon('check') ?> Porovnanie dostupných značiek</li>
                <li><?= icon('check') ?> Odporúčanie umiestnenia jednotiek</li>
                <li><?= icon('check') ?> Nezáväzná cenová ponuka</li>
            </ul>
        </div>
    </div>
</section>

<section class="section brands">
    <div class="container">
        <div class="section__head reveal">
            <span class="section__kicker">Značky, s ktorými pracujeme</span>
            <h2>Kvalitné klimatizácie overených výrobcov</h2>
        </div>
        <div class="brands__row reveal">
            <?php foreach (brandList() as $b): ?>
            <span class="brands__item"><?= e($b['name']) ?></span>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
