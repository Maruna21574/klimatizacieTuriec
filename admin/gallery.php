<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/csrf.php';

requireAdminLogin();

$pdo = db();
if ($pdo === null) {
    $adminTitle = 'Galéria fotiek';
    require_once __DIR__ . '/includes/layout_top.php';
    echo '<div class="admin-alert admin-alert--error">Databáza nie je dostupná.</div>';
    require_once __DIR__ . '/includes/layout_bottom.php';
    exit;
}

$galleryDir = __DIR__ . '/../assets/img/gallery';
$categoryOptions = [
    'rodinne-domy' => 'Rodinný dom',
    'byty' => 'Byty a balkóny',
    'exterier' => 'Exteriér',
    'servis' => 'Servis',
];

$action = (string) ($_POST['action'] ?? '');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'upload') {
    csrfCheck();

    $title = trim((string) ($_POST['title'] ?? ''));
    $category = (string) ($_POST['category'] ?? 'rodinne-domy');
    $categoryLabel = trim((string) ($_POST['category_label'] ?? ''));
    $description = trim((string) ($_POST['description'] ?? ''));

    if (!isset($categoryOptions[$category])) {
        $category = 'rodinne-domy';
    }
    if ($categoryLabel === '') {
        $categoryLabel = $categoryOptions[$category];
    }

    $file = $_FILES['photo'] ?? null;

    if (!$file || $file['error'] === UPLOAD_ERR_NO_FILE) {
        setFlash('Nevybral si žiadnu fotku.', 'error');
    } elseif ($file['error'] !== UPLOAD_ERR_OK) {
        setFlash('Nahrávanie fotky zlyhalo (chyba #' . $file['error'] . ').', 'error');
    } elseif ($file['size'] > 8 * 1024 * 1024) {
        setFlash('Fotka je príliš veľká (max 8 MB).', 'error');
    } else {
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($file['tmp_name']);
        $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];

        if (!isset($allowed[$mime]) || @getimagesize($file['tmp_name']) === false) {
            setFlash('Nepodporovaný typ súboru. Povolené sú JPG, PNG a WEBP fotky.', 'error');
        } else {
            $ext = $allowed[$mime];
            $slug = $title !== '' ? $title : 'realizacia';
            $slug = strtolower(trim((string) preg_replace('/[^a-z0-9]+/i', '-', $slug), '-'));
            $slug = $slug !== '' ? $slug : 'realizacia';
            $filename = $slug . '-' . substr(bin2hex(random_bytes(4)), 0, 8) . '.' . $ext;

            if (!is_dir($galleryDir)) {
                mkdir($galleryDir, 0755, true);
            }

            if (move_uploaded_file($file['tmp_name'], $galleryDir . '/' . $filename)) {
                $maxOrder = (int) $pdo->query('SELECT COALESCE(MAX(sort_order), 0) FROM gallery_images')->fetchColumn();
                $stmt = $pdo->prepare('INSERT INTO gallery_images (filename, category, category_label, title, description, sort_order) VALUES (?, ?, ?, ?, ?, ?)');
                $stmt->execute([$filename, $category, $categoryLabel, $title, $description, $maxOrder + 10]);
                setFlash('Fotka bola nahraná.', 'success');
            } else {
                setFlash('Fotku sa nepodarilo uložiť na server.', 'error');
            }
        }
    }

    header('Location: gallery.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'update') {
    csrfCheck();

    $stmt = $pdo->prepare('UPDATE gallery_images SET category = ?, category_label = ?, title = ?, description = ?, sort_order = ? WHERE id = ?');
    foreach ((array) ($_POST['item'] ?? []) as $id => $item) {
        $id = (int) $id;
        $category = (string) ($item['category'] ?? 'rodinne-domy');
        if (!isset($categoryOptions[$category])) {
            $category = 'rodinne-domy';
        }
        $categoryLabel = trim((string) ($item['category_label'] ?? ''));
        $title = trim((string) ($item['title'] ?? ''));
        $description = trim((string) ($item['description'] ?? ''));
        $sortOrder = (int) ($item['sort_order'] ?? 0);
        $stmt->execute([$category, $categoryLabel, $title, $description, $sortOrder, $id]);
    }

    setFlash('Galéria bola uložená.', 'success');
    header('Location: gallery.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'delete') {
    csrfCheck();
    $id = (int) ($_POST['id'] ?? 0);

    $stmt = $pdo->prepare('SELECT filename FROM gallery_images WHERE id = ?');
    $stmt->execute([$id]);
    $filename = $stmt->fetchColumn();

    if ($filename) {
        $pdo->prepare('DELETE FROM gallery_images WHERE id = ?')->execute([$id]);
        $path = $galleryDir . '/' . basename($filename);
        if (is_file($path)) {
            @unlink($path);
        }
        setFlash('Fotka bola vymazaná.', 'success');
    }

    header('Location: gallery.php');
    exit;
}

$items = $pdo->query('SELECT * FROM gallery_images ORDER BY sort_order ASC, id ASC')->fetchAll();

$adminTitle = 'Galéria fotiek';
require_once __DIR__ . '/includes/layout_top.php';
?>

<h2>Nahrať novú fotku</h2>
<div class="admin-card">
    <form method="post" enctype="multipart/form-data" novalidate>
        <?= csrfField() ?>
        <input type="hidden" name="action" value="upload">
        <div class="admin-field">
            <label for="photo">Fotografia (JPG, PNG alebo WEBP, max 8 MB)</label>
            <input type="file" id="photo" name="photo" accept="image/jpeg,image/png,image/webp" required>
        </div>
        <div class="two-col">
            <div class="admin-field">
                <label for="title">Názov fotky</label>
                <input type="text" id="title" name="title" placeholder="napr. Montáž klimatizácie na fasáde">
            </div>
            <div class="admin-field">
                <label for="category">Kategória</label>
                <select id="category" name="category">
                    <?php foreach ($categoryOptions as $key => $label): ?>
                    <option value="<?= e($key) ?>"><?= e($label) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="admin-field">
            <label for="category_label">Popisok kategórie na fotke</label>
            <input type="text" id="category_label" name="category_label" placeholder="napr. Rodinný dom (nechaj prázdne pre predvolené)">
        </div>
        <div class="admin-field">
            <label for="description">Popis fotky</label>
            <textarea id="description" name="description" rows="2"></textarea>
        </div>
        <div class="admin-toolbar">
            <button type="submit" class="btn btn--accent">Nahrať fotku</button>
        </div>
    </form>
</div>

<h2>Fotky v galérii (<?= count($items) ?>)</h2>
<form method="post" novalidate>
    <?= csrfField() ?>
    <input type="hidden" name="action" value="update">
    <div class="admin-card">
        <div style="overflow-x:auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Náhľad</th>
                    <th>Názov</th>
                    <th>Kategória</th>
                    <th>Popisok</th>
                    <th>Popis</th>
                    <th>Poradie</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                <tr>
                    <td><img class="thumb" src="../assets/img/gallery/<?= e($item['filename']) ?>" alt=""></td>
                    <td><input type="text" name="item[<?= (int) $item['id'] ?>][title]" value="<?= e($item['title']) ?>" style="min-width:160px;"></td>
                    <td>
                        <select name="item[<?= (int) $item['id'] ?>][category]">
                            <?php foreach ($categoryOptions as $key => $label): ?>
                            <option value="<?= e($key) ?>" <?= $item['category'] === $key ? 'selected' : '' ?>><?= e($label) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td><input type="text" name="item[<?= (int) $item['id'] ?>][category_label]" value="<?= e($item['category_label']) ?>" style="min-width:120px;"></td>
                    <td><textarea name="item[<?= (int) $item['id'] ?>][description]" rows="2" style="min-width:220px;"><?= e($item['description']) ?></textarea></td>
                    <td><input type="number" name="item[<?= (int) $item['id'] ?>][sort_order]" value="<?= (int) $item['sort_order'] ?>" style="width:70px;"></td>
                    <td class="row-actions">
                        <button type="submit" form="delete-<?= (int) $item['id'] ?>" class="btn btn--danger btn--sm" onclick="return confirm('Naozaj vymazať túto fotku?');">Vymazať</button>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (!$items): ?>
                <tr><td colspan="7">Galéria je zatiaľ prázdna.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
        </div>
        <div class="admin-toolbar">
            <button type="submit" class="btn btn--accent">Uložiť poradie a popisy</button>
        </div>
    </div>
</form>

<?php foreach ($items as $item): ?>
<form method="post" id="delete-<?= (int) $item['id'] ?>" novalidate>
    <?= csrfField() ?>
    <input type="hidden" name="action" value="delete">
    <input type="hidden" name="id" value="<?= (int) $item['id'] ?>">
</form>
<?php endforeach; ?>

<?php require_once __DIR__ . '/includes/layout_bottom.php'; ?>
