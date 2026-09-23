<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/mail-template.php';

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

$fieldsHtml = emailField('Meno', $meno)
    . emailField('E-mail', $email)
    . emailField('Telefón', $telefon !== '' ? $telefon : '-')
    . emailField('Mesto/obec', $mesto !== '' ? $mesto : '-')
    . emailField('Správa', $sprava);

$adminBodyHtml = '<p style="margin:0 0 20px;">Cez kontaktný formulár prišiel nový dopyt:</p>'
    . '<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">' . $fieldsHtml . '</table>';

$html = emailLayout($subject, $adminBodyHtml, [
    'label' => 'Odpovedať e-mailom',
    'url' => 'mailto:' . e($email),
]);

$headers = [
    'MIME-Version' => '1.0',
    'From' => $fromAddr,
    'Reply-To' => $email,
    'Content-Type' => 'text/html; charset=UTF-8',
];
$headerString = '';
foreach ($headers as $key => $value) {
    $headerString .= "{$key}: {$value}\r\n";
}

$sent = @mail($companyEmail, $subject, $html, $headerString);

// --- 2) Potvrdenie pre zákazníka ----------------------------------------
$customerSubject = 'Prijali sme vašu správu – ' . SITE_NAME;

$customerFieldsHtml = emailField('Telefón', $telefon !== '' ? $telefon : '-')
    . emailField('Mesto/obec', $mesto !== '' ? $mesto : '-')
    . emailField('Správa', $sprava);

$customerBodyHtml = '<p style="margin:0 0 4px;">Dobrý deň, ' . e($meno) . ',</p>'
    . '<p style="margin:0 0 20px;">ďakujeme za váš dopyt cez web ' . e(SITE_NAME) . '. Vašu správu sme prijali a ozveme sa vám čo najskôr na uvedený telefón alebo e-mail.</p>'
    . '<p style="margin:0 0 10px;font-weight:600;color:#0a2650;">Zhrnutie vašej správy:</p>'
    . '<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">' . $customerFieldsHtml . '</table>';

$customerHtml = emailLayout($customerSubject, $customerBodyHtml, [
    'label' => 'Zavolať ' . setting('phone_display', PHONE_DISPLAY),
    'url' => 'tel:' . e(setting('phone_tel', PHONE_TEL)),
]);

$customerHeaders = [
    'MIME-Version' => '1.0',
    'From' => SITE_NAME . ' <' . $fromAddr . '>',
    'Reply-To' => $companyEmail,
    'Content-Type' => 'text/html; charset=UTF-8',
];
$customerHeaderString = '';
foreach ($customerHeaders as $key => $value) {
    $customerHeaderString .= "{$key}: {$value}\r\n";
}

@mail($email, $customerSubject, $customerHtml, $customerHeaderString);

header('Location: kontakt?' . ($sent ? 'odoslane=1' : 'chyba=1'));
exit;
