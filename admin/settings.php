<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/csrf.php';

requireAdminLogin();

$fields = [
    'phone_display' => ['label' => 'Telefón (zobrazený formát)', 'default' => PHONE_DISPLAY, 'hint' => 'napr. 0907 119 861'],
    'phone_tel' => ['label' => 'Telefón (formát pre odkaz tel:)', 'default' => PHONE_TEL, 'hint' => 'napr. +421907119861 – bez medzier'],
    'email' => ['label' => 'E-mail', 'default' => EMAIL_ADDR, 'hint' => ''],
    'region' => ['label' => 'Región pôsobenia', 'default' => SITE_REGION, 'hint' => 'napr. Turiec a okolie'],
    'opening_hours' => ['label' => 'Otváracie hodiny / dostupnosť', 'default' => 'Po – Ne: 7:00 – 20:00', 'hint' => ''],
    'facebook_url' => ['label' => 'Facebook URL', 'default' => FACEBOOK_URL, 'hint' => 'nechaj prázdne, ak firma nemá Facebook'],
    'instagram_url' => ['label' => 'Instagram URL', 'default' => INSTAGRAM_URL, 'hint' => 'nechaj prázdne, ak firma nemá Instagram'],
    'google_reviews_url' => ['label' => 'Odkaz na Google recenzie', 'default' => GOOGLE_REVIEWS_URL, 'hint' => ''],
    'google_maps_embed' => ['label' => 'Google Maps – embed URL', 'default' => GOOGLE_MAPS_EMBED, 'hint' => 'URL z Google Maps (Zdieľať → Vložiť mapu → src odkaz)'],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrfCheck();

    $pdo = db();
    if ($pdo === null) {
        setFlash('Databáza nie je dostupná, zmeny sa neuložili.', 'error');
        header('Location: settings.php');
        exit;
    }

    $stmt = $pdo->prepare(
        'INSERT INTO site_settings (setting_key, setting_value) VALUES (?, ?)
         ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)'
    );
    // Ochrana pred neúplným požiadavkom: pole, ktoré vôbec nebolo odoslané, sa v DB nemení.
    $postedFields = (array) ($_POST['field'] ?? []);
    foreach ($fields as $key => $def) {
        if (!array_key_exists($key, $postedFields)) {
            continue;
        }
        $value = trim((string) $postedFields[$key]);
        $stmt->execute([$key, $value]);
    }

    setFlash('Nastavenia boli uložené.', 'success');
    header('Location: settings.php');
    exit;
}

$adminTitle = 'Kontakt a nastavenia';
require_once __DIR__ . '/includes/layout_top.php';
?>

<form method="post" novalidate>
    <?= csrfField() ?>
    <div class="admin-card">
        <?php foreach ($fields as $key => $def): ?>
        <div class="admin-field">
            <label for="field-<?= e($key) ?>"><?= e($def['label']) ?></label>
            <input type="text" id="field-<?= e($key) ?>" name="field[<?= e($key) ?>]" value="<?= e(setting($key, $def['default'])) ?>">
            <?php if ($def['hint']): ?><small><?= e($def['hint']) ?></small><?php endif; ?>
        </div>
        <?php endforeach; ?>
        <div class="admin-toolbar">
            <button type="submit" class="btn btn--accent">Uložiť zmeny</button>
        </div>
    </div>
</form>

<?php require_once __DIR__ . '/includes/layout_bottom.php'; ?>
