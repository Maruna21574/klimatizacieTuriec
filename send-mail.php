<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: kontakt');
    exit;
}

// Honeypot proti spamu — skryté pole, ktoré bot pravdepodobne vyplní
if (!empty($_POST['website'])) {
    header('Location: kontakt?odoslane=1');
    exit;
}

$meno = trim((string) ($_POST['meno'] ?? ''));
$email = trim((string) ($_POST['email'] ?? ''));
$telefon = trim((string) ($_POST['telefon'] ?? ''));
$mesto = trim((string) ($_POST['mesto'] ?? ''));
$sprava = trim((string) ($_POST['sprava'] ?? ''));

if ($meno === '' || $sprava === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: kontakt?chyba=1');
    exit;
}

$fromAddr = 'web@' . preg_replace('/^https?:\/\//', '', SITE_URL);
$companyEmail = setting('email', EMAIL_ADDR);

// --- 1) Notifikácia pre firmu ------------------------------------------
$subject = 'Nový dopyt z webu – ' . SITE_NAME;
$body = "Nová správa z kontaktného formulára\n\n"
    . "Meno: {$meno}\n"
    . "E-mail: {$email}\n"
    . "Telefón: " . ($telefon !== '' ? $telefon : '-') . "\n"
    . "Mesto/obec: " . ($mesto !== '' ? $mesto : '-') . "\n\n"
    . "Správa:\n{$sprava}\n";

$headers = [
    'From' => $fromAddr,
    'Reply-To' => $email,
    'Content-Type' => 'text/plain; charset=UTF-8',
];
$headerString = '';
foreach ($headers as $key => $value) {
    $headerString .= "{$key}: {$value}\r\n";
}

$sent = @mail($companyEmail, $subject, $body, $headerString);

// --- 2) Potvrdenie pre zákazníka ----------------------------------------
$customerSubject = 'Prijali sme vašu správu – ' . SITE_NAME;
$customerBody = "Dobrý deň, {$meno},\n\n"
    . "ďakujeme za váš dopyt cez web " . SITE_NAME . ". Vašu správu sme prijali a ozveme sa vám čo najskôr na uvedený telefón alebo e-mail.\n\n"
    . "Zhrnutie vašej správy:\n"
    . "Telefón: " . ($telefon !== '' ? $telefon : '-') . "\n"
    . "Mesto/obec: " . ($mesto !== '' ? $mesto : '-') . "\n"
    . "Správa:\n{$sprava}\n\n"
    . "S pozdravom\n"
    . SITE_NAME . "\n"
    . PHONE_DISPLAY . " | " . $companyEmail . "\n";

$customerHeaders = [
    'From' => SITE_NAME . ' <' . $fromAddr . '>',
    'Reply-To' => $companyEmail,
    'Content-Type' => 'text/plain; charset=UTF-8',
];
$customerHeaderString = '';
foreach ($customerHeaders as $key => $value) {
    $customerHeaderString .= "{$key}: {$value}\r\n";
}

@mail($email, $customerSubject, $customerBody, $customerHeaderString);

header('Location: kontakt?' . ($sent ? 'odoslane=1' : 'chyba=1'));
exit;
