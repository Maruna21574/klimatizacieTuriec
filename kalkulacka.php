<?php
declare(strict_types=1);

$activePage = 'kalkulacka';
$pageTitle = 'Kalkulačka výkonu klimatizácie – Klíma Turiec';
$pageDescription = 'Zistite orientačný výkon klimatizácie podľa plochy a typu miestnosti. Rýchly odhad zadarmo, presný návrh pripravíme pri bezplatnej obhliadke.';

require_once __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
    <canvas class="hero-grid-canvas" aria-hidden="true"></canvas>
    <div class="container">
        <h1>Kalkulačka výkonu klimatizácie</h1>
        <p>Zadajte parametre miestnosti a hneď uvidíte orientačný výkon jednotky aj odhadovanú cenu montáže. Presný návrh pripravíme zadarmo priamo na mieste.</p>
    </div>
</section>

<section class="section section--tight">
    <div class="container calc-grid">
        <div class="calc-card reveal">
            <div class="form-row">
                <label for="calc-area">Plocha miestnosti (m²)</label>
                <input type="number" id="calc-area" min="5" max="150" step="1" value="20" inputmode="numeric">
            </div>
            <div class="form-row">
                <label for="calc-room">Typ miestnosti</label>
                <select id="calc-room">
                    <option value="0.10">Spálňa / izba</option>
                    <option value="0.11" selected>Obývačka</option>
                    <option value="0.13">Kuchyňa</option>
                    <option value="0.12">Kancelária / prevádzka</option>
                    <option value="0.14">Podkrovie (izba pod strechou)</option>
                </select>
            </div>
            <div class="form-row">
                <label for="calc-ceiling">Výška stropu</label>
                <select id="calc-ceiling">
                    <option value="1">do 2,6 m</option>
                    <option value="1.12">2,6 – 3 m</option>
                    <option value="1.25">nad 3 m</option>
                </select>
            </div>
            <div class="form-row">
                <label for="calc-orientation">Orientácia okien</label>
                <select id="calc-orientation">
                    <option value="0.95">Bez okien / vnútorná miestnosť</option>
                    <option value="1" selected>Sever (najmenej slnka)</option>
                    <option value="1.05">Východ</option>
                    <option value="1.1">Západ</option>
                    <option value="1.15">Juh (najviac slnka)</option>
                </select>
            </div>
            <div class="form-row form-row--split">
                <div>
                    <label for="calc-people">Počet osôb v miestnosti</label>
                    <input type="number" id="calc-people" min="1" max="10" step="1" value="2" inputmode="numeric">
                </div>
                <div>
                    <label for="calc-route">Dĺžka trasy k vonk. jednotke (m)</label>
                    <input type="number" id="calc-route" min="1" max="30" step="1" value="3" inputmode="numeric">
                </div>
            </div>
        </div>

        <div class="calc-result reveal">
            <span class="section__kicker">Orientačný výsledok</span>
            <div class="calc-result__value">
                <strong id="calc-kw">2,5 kW</strong>
                <span id="calc-btu">≈ 8 530 BTU/h</span>
            </div>
            <p id="calc-note">Orientačný odhad pre zadanú miestnosť.</p>
            <div class="calc-price">
                <span class="calc-price__label">Odhadovaná cena montáže</span>
                <strong id="calc-price">700 – 900 €</strong>
                <span id="calc-price-note" class="calc-price__note">vrátane 3 m trasy k vonkajšej jednotke</span>
            </div>
            <ul class="check-list">
                <li><?= icon('check') ?> Odhad podľa bežných pravidiel pre chladenie priestoru</li>
                <li><?= icon('check') ?> Cena je orientačná, presnú vám potvrdíme po obhliadke</li>
                <li><?= icon('check') ?> Poradíme aj s výberom značky a umiestnením jednotiek</li>
            </ul>
            <div class="hero__actions">
                <a href="kontakt.php" class="btn btn--accent btn--lg"><?= icon('arrow-right') ?> Nezáväzná cenová ponuka</a>
                <a href="tel:<?= e(PHONE_TEL) ?>" class="btn btn--outline-light btn--lg"><?= icon('phone') ?> <?= e(PHONE_DISPLAY) ?></a>
            </div>
            <p class="calc-disclaimer">Ceny sú orientačné podľa bežných cien montáže na Slovensku a slúžia len ako predbežný odhad. Konečná cena závisí od konkrétnej obhliadky, značky jednotky a stavebných úprav.</p>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
