<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/csrf.php';

requireAdminLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrfCheck();

    $current = (string) ($_POST['current_password'] ?? '');
    $new = (string) ($_POST['new_password'] ?? '');
    $confirm = (string) ($_POST['new_password_confirm'] ?? '');

    $pdo = db();
    $stmt = $pdo->prepare('SELECT password_hash FROM admin_users WHERE id = ?');
    $stmt->execute([currentAdminId()]);
    $row = $stmt->fetch();

    if (!$row || !password_verify($current, $row['password_hash'])) {
        setFlash('Súčasné heslo nie je správne.', 'error');
    } elseif (strlen($new) < 8) {
        setFlash('Nové heslo musí mať aspoň 8 znakov.', 'error');
    } elseif ($new !== $confirm) {
        setFlash('Nové heslá sa nezhodujú.', 'error');
    } else {
        $upd = $pdo->prepare('UPDATE admin_users SET password_hash = ? WHERE id = ?');
        $upd->execute([password_hash($new, PASSWORD_DEFAULT), currentAdminId()]);
        setFlash('Heslo bolo zmenené.', 'success');
    }

    header('Location: change-password.php');
    exit;
}

$adminTitle = 'Zmena hesla';
require_once __DIR__ . '/includes/layout_top.php';
?>

<div class="admin-card">
    <form method="post" novalidate style="max-width:400px;">
        <?= csrfField() ?>
        <div class="admin-field">
            <label for="current_password">Súčasné heslo</label>
            <input type="password" id="current_password" name="current_password" required autocomplete="current-password">
        </div>
        <div class="admin-field">
            <label for="new_password">Nové heslo</label>
            <input type="password" id="new_password" name="new_password" required autocomplete="new-password" minlength="8">
            <small>Aspoň 8 znakov.</small>
        </div>
        <div class="admin-field">
            <label for="new_password_confirm">Nové heslo znova</label>
            <input type="password" id="new_password_confirm" name="new_password_confirm" required autocomplete="new-password" minlength="8">
        </div>
        <button type="submit" class="btn btn--accent">Zmeniť heslo</button>
    </form>
</div>

<?php require_once __DIR__ . '/includes/layout_bottom.php'; ?>
