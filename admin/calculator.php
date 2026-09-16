<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/csrf.php';

requireAdminLogin();

$registry = calcSettingsRegistry();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrfCheck();

    $pdo = db();
    if ($pdo === null) {
        setFlash('Databáza nie je dostupná, zmeny sa neuložili.', 'error');
        header('Location: calculator.php');
        exit;
    }

    $stmt = $pdo->prepare(
        'INSERT INTO calculator_settings (setting_key, setting_value) VALUES (?, ?)
         ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)'
    );

    // Ochrana pred neúplným požiadavkom: pole, ktoré vôbec nebolo odoslané, sa v DB nemení.
    $postedFields = (array) ($_POST['field'] ?? []);
    $errors = [];
    foreach ($registry as $field) {
        if (!array_key_exists($field['key'], $postedFields)) {
            continue;
        }
        $raw = trim((string) $postedFields[$field['key']]);
        if ($field['type'] === 'number') {
            if ($raw === '' || !is_numeric($raw)) {
                $errors[] = $field['label'];
                continue;
            }
        }
        $stmt->execute([$field['key'], $raw]);
    }

    if ($errors) {
        setFlash('Niektoré číselné polia neboli platné čísla, neuložené: ' . implode(', ', $errors), 'error');
    } else {
        setFlash('Nastavenia kalkulačky boli uložené.', 'success');
    }
    header('Location: calculator.php');
    exit;
}

$current = calcSettings();

$groups = [];
foreach ($registry as $field) {
    $groups[$field['group']][] = $field;
}

$adminTitle = 'Kalkulačka';
require_once __DIR__ . '/includes/layout_top.php';
?>

<p class="admin-hint">Tieto hodnoty priamo ovplyvňujú výpočet na stránke Kalkulačka (odporúčaný výkon aj cenový rozsah).</p>

<form method="post" novalidate>
    <?= csrfField() ?>
    <div class="admin-card">
        <?php foreach ($groups as $groupLabel => $fields): ?>
        <div class="admin-group-label"><?= e($groupLabel) ?></div>
        <div class="two-col">
            <?php foreach ($fields as $field): ?>
            <div class="admin-field">
                <label for="field-<?= e($field['key']) ?>"><?= e($field['label']) ?></label>
                <input
                    type="<?= $field['type'] === 'number' ? 'text' : 'text' ?>"
                    inputmode="<?= $field['type'] === 'number' ? 'decimal' : 'text' ?>"
                    id="field-<?= e($field['key']) ?>"
                    name="field[<?= e($field['key']) ?>]"
                    value="<?= e($current[$field['key']] ?? $field['default']) ?>">
            </div>
            <?php endforeach; ?>
        </div>
        <?php endforeach; ?>
        <div class="admin-toolbar">
            <button type="submit" class="btn btn--accent">Uložiť zmeny</button>
        </div>
    </div>
</form>

<?php require_once __DIR__ . '/includes/layout_bottom.php'; ?>
