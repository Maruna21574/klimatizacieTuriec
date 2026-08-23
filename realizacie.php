<?php
declare(strict_types=1);

$activePage = 'realizacie';
$pageTitle = 'Realizácie – galéria montáží klimatizácií | Klíma Turiec';
$pageDescription = 'Pozrite si vybrané realizácie montáží klimatizácií v rodinných domoch, bytoch aj pri exteriérových priestoroch v regióne Turiec.';

require_once __DIR__ . '/includes/header.php';

$items = galleryItems();
$categories = [
    'all' => 'Všetko',
    'rodinne-domy' => 'Rodinné domy',
    'byty' => 'Byty a balkóny',
    'exterier' => 'Exteriér',
    'servis' => 'Servis',
];
?>

<section class="page-hero">
    <canvas class="hero-grid-canvas" aria-hidden="true"></canvas>
    <div class="container">
        <h1>Montáže, na ktoré sme hrdí</h1>
        <p>Výber z realizovaných montáží v rodinných domoch, bytoch aj pri exteriérových priestoroch v Turci. Kliknutím na fotografiu si ju zobrazíte v plnej veľkosti.</p>
    </div>
</section>

<section class="section section--tight">
    <div class="container">
        <div class="gallery-filter reveal" role="tablist" aria-label="Filter realizácií">
            <?php foreach ($categories as $key => $label): ?>
            <button type="button" class="gallery-filter__btn<?= $key === 'all' ? ' is-active' : '' ?>" data-filter="<?= e($key) ?>"><?= e($label) ?></button>
            <?php endforeach; ?>
        </div>

        <div class="gallery-grid" id="gallery-grid">
            <?php foreach ($items as $i => $item): ?>
            <figure class="gallery-grid__item reveal" data-category="<?= e($item['category']) ?>">
                <a href="assets/img/gallery/<?= e($item['file']) ?>" class="gallery-grid__link" data-lightbox data-caption="<?= e($item['title']) ?>">
                    <img src="assets/img/gallery/<?= e($item['file']) ?>" alt="<?= e($item['title']) ?>" loading="lazy" width="500" height="380">
                    <span class="gallery-grid__zoom" aria-hidden="true">+</span>
                </a>
                <figcaption>
                    <span class="gallery-grid__tag"><?= e($item['categoryLabel']) ?></span>
                    <strong><?= e($item['title']) ?></strong>
                    <span><?= e($item['desc']) ?></span>
                </figcaption>
            </figure>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<div class="lightbox" id="lightbox" aria-hidden="true">
    <button type="button" class="lightbox__close" id="lightbox-close" aria-label="Zavrieť náhľad"><?= icon('close') ?></button>
    <button type="button" class="lightbox__nav lightbox__nav--prev" id="lightbox-prev" aria-label="Predchádzajúca fotografia"><?= icon('arrow-right') ?></button>
    <figure class="lightbox__figure">
        <img src="" alt="" id="lightbox-img">
        <figcaption id="lightbox-caption"></figcaption>
    </figure>
    <button type="button" class="lightbox__nav lightbox__nav--next" id="lightbox-next" aria-label="Nasledujúca fotografia"><?= icon('arrow-right') ?></button>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
