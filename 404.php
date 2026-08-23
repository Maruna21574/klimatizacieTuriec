<?php
declare(strict_types=1);

http_response_code(404);

$activePage = '';
$pageTitle = 'Stránka nenájdená – Klíma Turiec';
$pageDescription = 'Požadovaná stránka neexistuje.';

require_once __DIR__ . '/includes/header.php';
?>

<section class="section not-found">
    <div class="container not-found__inner reveal">
        <span class="not-found__code">404</span>
        <h1>Túto stránku sa nám nepodarilo nájsť</h1>
        <p>Možno bola presunutá alebo už neexistuje. Skúste sa vrátiť na domovskú stránku.</p>
        <div class="hero__actions">
            <a href="index.php" class="btn btn--accent btn--lg"><?= icon('arrow-right') ?> Späť na domovskú stránku</a>
            <a href="kontakt.php" class="btn btn--outline btn--lg"><?= icon('mail') ?> Kontaktovať nás</a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
