<?php
declare(strict_types=1);

http_response_code(404);

require_once __DIR__ . '/includes/config.php';

$activePage = '';
$pageTitle = 'Stránka nenájdená – Klimatizácie Turiec';
$pageDescription = 'Požadovaná stránka neexistuje.';

require_once __DIR__ . '/includes/header.php';
?>

<section class="section not-found">
    <div class="container not-found__inner reveal">
        <span class="not-found__code">404</span>
        <h1><?= cms('stranka-404', 'title') ?></h1>
        <p><?= cms('stranka-404', 'desc') ?></p>
        <div class="hero__actions">
            <a href="index.php" class="btn btn--accent btn--lg"><?= icon('arrow-right') ?> Späť na domovskú stránku</a>
            <a href="kontakt.php" class="btn btn--outline btn--lg"><?= icon('mail') ?> Kontaktovať nás</a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
