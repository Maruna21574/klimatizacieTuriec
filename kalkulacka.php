<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$activePage = 'kalkulacka';
$pageTitle = cms('kalkulacka', 'seo_title');
$pageDescription = cms('kalkulacka', 'seo_description');

$calc = calcSettings();

require_once __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
    <canvas class="hero-grid-canvas" aria-hidden="true"></canvas>
    <div class="container">
        <h1><?= cms('kalkulacka', 'hero_title') ?></h1>
        <p><?= cms('kalkulacka', 'hero_lead') ?></p>
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
                <label for="calc-ceiling">Výška stropu</label>
                <select id="calc-ceiling">
                    <option value="<?= e($calc['ceiling_low_value']) ?>"><?= e($calc['ceiling_low_label']) ?></option>
                    <option value="<?= e($calc['ceiling_mid_value']) ?>"><?= e($calc['ceiling_mid_label']) ?></option>
                    <option value="<?= e($calc['ceiling_high_value']) ?>"><?= e($calc['ceiling_high_label']) ?></option>
                </select>
            </div>
            <div class="form-row">
                <label for="calc-orientation">Orientácia okien</label>
                <select id="calc-orientation">
                    <option value="<?= e($calc['orient_none_value']) ?>"><?= e($calc['orient_none_label']) ?></option>
                    <option value="<?= e($calc['orient_north_value']) ?>" selected><?= e($calc['orient_north_label']) ?></option>
                    <option value="<?= e($calc['orient_east_value']) ?>"><?= e($calc['orient_east_label']) ?></option>
                    <option value="<?= e($calc['orient_west_value']) ?>"><?= e($calc['orient_west_label']) ?></option>
                    <option value="<?= e($calc['orient_south_value']) ?>"><?= e($calc['orient_south_label']) ?></option>
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
                <li><?= icon('check') ?> <?= cms('kalkulacka', 'check_1') ?></li>
                <li><?= icon('check') ?> <?= cms('kalkulacka', 'check_2') ?></li>
                <li><?= icon('check') ?> <?= cms('kalkulacka', 'check_3') ?></li>
            </ul>
            <div class="hero__actions">
                <a href="kontakt" class="btn btn--accent btn--lg"><?= icon('arrow-right') ?> Nezáväzná cenová ponuka</a>
                <a href="tel:<?= e(setting('phone_tel', PHONE_TEL)) ?>" class="btn btn--outline-light btn--lg"><?= icon('phone') ?> <?= e(setting('phone_display', PHONE_DISPLAY)) ?></a>
            </div>
            <p class="calc-disclaimer"><?= cms('kalkulacka', 'disclaimer') ?></p>
        </div>
    </div>
</section>

<script>
window.CALC_CONFIG = {
    roomBaseValue: <?= json_encode((float) $calc['room_base_value']) ?>,
    personLoadKw: <?= json_encode((float) $calc['person_load_kw']) ?>,
    routeIncludedM: <?= json_encode((float) $calc['route_included_m']) ?>,
    routeRateEur: <?= json_encode((float) $calc['route_rate_eur']) ?>,
    prices: {
        '2': [<?= (int) $calc['price_2_min'] ?>, <?= (int) $calc['price_2_max'] ?>],
        '2.5': [<?= (int) $calc['price_2_5_min'] ?>, <?= (int) $calc['price_2_5_max'] ?>],
        '3.5': [<?= (int) $calc['price_3_5_min'] ?>, <?= (int) $calc['price_3_5_max'] ?>],
        '5': [<?= (int) $calc['price_5_min'] ?>, <?= (int) $calc['price_5_max'] ?>],
        '7': [<?= (int) $calc['price_7_min'] ?>, <?= (int) $calc['price_7_max'] ?>],
        '9': [<?= (int) $calc['price_9_min'] ?>, <?= (int) $calc['price_9_max'] ?>],
        '12': [<?= (int) $calc['price_12_min'] ?>, <?= (int) $calc['price_12_max'] ?>]
    }
};
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
