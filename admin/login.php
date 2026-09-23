<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/csrf.php';

adminSessionStart();

if (isAdminLoggedIn()) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrfCheck();
    $username = trim((string) ($_POST['username'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');

    if (isAdminLoginLocked(adminClientIp())) {
        $error = 'Príliš veľa neúspešných pokusov o prihlásenie. Skúste to znova o pár minút.';
    } elseif ($username !== '' && $password !== '' && attemptAdminLogin($username, $password)) {
        header('Location: index.php');
        exit;
    } else {
        $error = 'Nesprávne meno alebo heslo.';
    }
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<title>Prihlásenie – Administrácia Matrotech</title>
<link rel="stylesheet" href="assets/admin.css?v=<?= (int) @filemtime(__DIR__ . '/assets/admin.css') ?>">
</head>
<body>
<div class="admin-login-wrap">
    <div class="admin-login-card">
        <h1>Matrotech</h1>
        <p class="admin-hint" style="text-align:center;">Prihlásenie do administrácie webu</p>
        <?php if ($error !== ''): ?>
        <div class="admin-alert admin-alert--error"><?= e($error) ?></div>
        <?php endif; ?>
        <form method="post" novalidate>
            <?= csrfField() ?>
            <div class="admin-field">
                <label for="username">Používateľské meno</label>
                <input type="text" id="username" name="username" required autofocus autocomplete="username">
            </div>
            <div class="admin-field">
                <label for="password">Heslo</label>
                <input type="password" id="password" name="password" required autocomplete="current-password">
            </div>
            <button type="submit" class="btn btn--accent">Prihlásiť sa</button>
        </form>
    </div>
</div>
</body>
</html>
