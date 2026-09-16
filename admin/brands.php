<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/csrf.php';

requireAdminLogin();

$pdo = db();
if ($pdo === null) {
    $adminTitle = 'Značky';
    require_once __DIR__ . '/includes/layout_top.php';
    echo '<div class="admin-alert admin-alert--error">Databáza nie je dostupná.</div>';
    require_once __DIR__ . '/includes/layout_bottom.php';
    exit;
}

$action = (string) ($_POST['action'] ?? '');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'add') {
    csrfCheck();
    $name = trim((string) ($_POST['name'] ?? ''));
    if ($name !== '') {
        $maxOrder = (int) $pdo->query('SELECT COALESCE(MAX(sort_order), 0) FROM brands')->fetchColumn();
        $pdo->prepare('INSERT INTO brands (name, sort_order) VALUES (?, ?)')->execute([$name, $maxOrder + 10]);
        setFlash('Značka bola pridaná.', 'success');
    }
    header('Location: brands.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'update') {
    csrfCheck();
    $stmt = $pdo->prepare('UPDATE brands SET name = ?, sort_order = ? WHERE id = ?');
    foreach ((array) ($_POST['item'] ?? []) as $id => $item) {
        $stmt->execute([trim((string) ($item['name'] ?? '')), (int) ($item['sort_order'] ?? 0), (int) $id]);
    }
    setFlash('Zmeny boli uložené.', 'success');
    header('Location: brands.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'delete') {
    csrfCheck();
    $pdo->prepare('DELETE FROM brands WHERE id = ?')->execute([(int) ($_POST['id'] ?? 0)]);
    setFlash('Značka bola vymazaná.', 'success');
    header('Location: brands.php');
    exit;
}

$items = $pdo->query('SELECT * FROM brands ORDER BY sort_order ASC, id ASC')->fetchAll();

$adminTitle = 'Značky';
require_once __DIR__ . '/includes/layout_top.php';
?>

<p class="admin-hint">Tento zoznam sa zobrazuje na domovskej stránke a stránke Služby.</p>

<div class="admin-card">
    <form method="post" novalidate style="display:flex; gap:10px; align-items:flex-end;">
        <?= csrfField() ?>
        <input type="hidden" name="action" value="add">
        <div class="admin-field" style="flex:1; margin-bottom:0;">
            <label for="name">Nová značka</label>
            <input type="text" id="name" name="name" placeholder="napr. Mitsubishi" required>
        </div>
        <button type="submit" class="btn btn--accent">Pridať</button>
    </form>
</div>

<form method="post" novalidate>
    <?= csrfField() ?>
    <input type="hidden" name="action" value="update">
    <div class="admin-card">
        <table class="admin-table">
            <thead><tr><th>Názov</th><th>Poradie</th><th></th></tr></thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                <tr>
                    <td><input type="text" name="item[<?= (int) $item['id'] ?>][name]" value="<?= e($item['name']) ?>"></td>
                    <td><input type="number" name="item[<?= (int) $item['id'] ?>][sort_order]" value="<?= (int) $item['sort_order'] ?>" style="width:70px;"></td>
                    <td class="row-actions">
                        <button type="submit" form="delete-brand-<?= (int) $item['id'] ?>" class="btn btn--danger btn--sm" onclick="return confirm('Vymazať túto značku?');">Vymazať</button>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (!$items): ?>
                <tr><td colspan="3">Zatiaľ žiadne značky.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="admin-toolbar">
            <button type="submit" class="btn btn--accent">Uložiť poradie a názvy</button>
        </div>
    </div>
</form>

<?php foreach ($items as $item): ?>
<form method="post" id="delete-brand-<?= (int) $item['id'] ?>" novalidate>
    <?= csrfField() ?>
    <input type="hidden" name="action" value="delete">
    <input type="hidden" name="id" value="<?= (int) $item['id'] ?>">
</form>
<?php endforeach; ?>

<?php require_once __DIR__ . '/includes/layout_bottom.php'; ?>
