<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: kontakt.php');
    exit;
}

// Honeypot proti spamu — skryté pole, ktoré bot pravdepodobne vyplní
if (!empty($_POST['website'])) {
    header('Location: kontakt.php?odoslane=1');
    exit;
}

$meno = trim((string) ($_POST['meno'] ?? ''));
$email = trim((string) ($_POST['email'] ?? ''));
$telefon = trim((string) ($_POST['telefon'] ?? ''));
$mesto = trim((string) ($_POST['mesto'] ?? ''));
$sprava = trim((string) ($_POST['sprava'] ?? ''));

if ($meno === '' || $sprava === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: kontakt.php?chyba=1');
    exit;
}

$subject = 'Nový dopyt z webu – ' . SITE_NAME;
$body = "Nová správa z kontaktného formulára\n\n"
    . "Meno: {$meno}\n"
    . "E-mail: {$email}\n"
    . "Telefón: " . ($telefon !== '' ? $telefon : '-') . "\n"
    . "Mesto/obec: " . ($mesto !== '' ? $mesto : '-') . "\n\n"
    . "Správa:\n{$sprava}\n";

$headers = [
    'From' => 'web@' . preg_replace('/^https?:\/\//', '', SITE_URL),
    'Reply-To' => $email,
    'Content-Type' => 'text/plain; charset=UTF-8',
];
$headerString = '';
foreach ($headers as $key => $value) {
    $headerString .= "{$key}: {$value}\r\n";
}

$sent = @mail(EMAIL_ADDR, $subject, $body, $headerString);

header('Location: kontakt.php?' . ($sent ? 'odoslane=1' : 'chyba=1'));
exit;
