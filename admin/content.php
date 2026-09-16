<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/csrf.php';

requireAdminLogin();

$registry = pageContentRegistry();
$pageKeys = array_keys($registry);
$currentPage = (string) ($_GET['page'] ?? $pageKeys[0]);
if (!isset($registry[$currentPage])) {
    $currentPage = $pageKeys[0];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrfCheck();
    $postedPage = (string) ($_POST['page'] ?? '');
    if (!isset($registry[$postedPage])) {
        setFlash('Neznáma stránka.', 'error');
        header('Location: content.php');
        exit;
    }

    $pdo = db();
    if ($pdo === null) {
        setFlash('Databáza nie je dostupná, zmeny sa neuložili.', 'error');
        header('Location: content.php?page=' . urlencode($postedPage));
        exit;
    }

    $stmt = $pdo->prepare(
        'INSERT INTO page_content (page_slug, block_key, content_value) VALUES (?, ?, ?)
         ON DUPLICATE KEY UPDATE content_value = VALUES(content_value)'
    );

    // Ochrana pred neúplným požiadavkom: ak pole vôbec nebolo odoslané (nie len prázdne),
    // jeho hodnotu v DB nemeníme - zabráni to náhodnému vymazaniu obsahu pri poškodenom requeste.
    $postedBlocks = (array) ($_POST['block'] ?? []);
    foreach ($registry[$postedPage]['blocks'] as $key => $def) {
        if (!array_key_exists($key, $postedBlocks)) {
            continue;
        }
        $stmt->execute([$postedPage, $key, (string) $postedBlocks[$key]]);
    }

    setFlash('Texty stránky „' . $registry[$postedPage]['label'] . '“ boli uložené.', 'success');
    header('Location: content.php?page=' . urlencode($postedPage));
    exit;
}

$adminTitle = 'Texty stránok';
require_once __DIR__ . '/includes/layout_top.php';
?>

<div class="admin-card" style="display:flex; gap:8px; flex-wrap:wrap;">
    <?php foreach ($registry as $key => $page): ?>
    <a href="content.php?page=<?= e($key) ?>" class="btn btn--sm <?= $key === $currentPage ? '' : 'btn--outline' ?>"><?= e($page['label']) ?></a>
    <?php endforeach; ?>
</div>

<form method="post" novalidate>
    <?= csrfField() ?>
    <input type="hidden" name="page" value="<?= e($currentPage) ?>">
    <div class="admin-card">
        <?php foreach ($registry[$currentPage]['blocks'] as $key => $def): ?>
        <div class="admin-field">
            <label for="block-<?= e($key) ?>"><?= e($def['label']) ?></label>
            <?php if ($def['type'] === 'text'): ?>
            <input type="text" id="block-<?= e($key) ?>" name="block[<?= e($key) ?>]" value="<?= e(cmsRaw($currentPage, $key)) ?>">
            <?php else: ?>
            <textarea id="block-<?= e($key) ?>" name="block[<?= e($key) ?>]" rows="<?= $def['type'] === 'html' ? 2 : 3 ?>"><?= e(cmsRaw($currentPage, $key)) ?></textarea>
            <?php if ($def['type'] === 'html'): ?>
            <small>Môže obsahovať jednoduché HTML (napr. &lt;span&gt;text&lt;/span&gt;) – upravuj opatrne.</small>
            <?php endif; ?>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
        <div class="admin-toolbar">
            <button type="submit" class="btn btn--accent">Uložiť zmeny</button>
        </div>
    </div>
</form>

<?php require_once __DIR__ . '/includes/layout_bottom.php'; ?>
