<?php
/**
 * Spoločná HTML šablóna pre e-maily (notifikácia + potvrdenie zo send-mail.php).
 * Inline štýly kvôli kompatibilite s e-mailovými klientmi.
 */

declare(strict_types=1);

/**
 * @param string $title    Nadpis zobrazený v tele e-mailu (pod logom).
 * @param string $bodyHtml  Vnútorný HTML obsah (už bezpečne escapovaný volajúcim).
 * @param array{label:string,url:string}|null $cta Voliteľné tlačidlo.
 */
function emailLayout(string $title, string $bodyHtml, ?array $cta = null): string
{
    $logoUrl = e(SITE_URL . '/assets/img/logo-white.png');
    $siteName = e(SITE_NAME);
    $year = date('Y');
    $phone = e(setting('phone_display', PHONE_DISPLAY));
    $phoneTel = e(setting('phone_tel', PHONE_TEL));
    $companyEmail = e(setting('email', EMAIL_ADDR));

    $ctaHtml = '';
    if ($cta !== null) {
        $ctaHtml = <<<HTML
        <table role="presentation" cellpadding="0" cellspacing="0" style="margin:28px 0 4px;">
            <tr>
                <td style="border-radius:999px;background:#ff5f2e;">
                    <a href="{$cta['url']}" style="display:inline-block;padding:14px 28px;font-family:'Segoe UI',Arial,sans-serif;font-size:15px;font-weight:600;color:#ffffff;text-decoration:none;border-radius:999px;">{$cta['label']}</a>
                </td>
            </tr>
        </table>
        HTML;
    }

    return <<<HTML
    <!DOCTYPE html>
    <html lang="sk">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$title}</title>
    </head>
    <body style="margin:0;padding:0;background:#f5f8fc;font-family:'Segoe UI',Arial,sans-serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f5f8fc;padding:32px 16px;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;background:#ffffff;border-radius:14px;overflow:hidden;box-shadow:0 10px 30px rgba(10,38,80,0.10);">
                    <tr>
                        <td style="background:#0a2650;padding:28px 32px;text-align:center;">
                            <img src="{$logoUrl}" alt="{$siteName}" width="170" style="display:block;margin:0 auto;border:0;outline:none;">
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:36px 32px 8px;">
                            <h1 style="margin:0 0 18px;font-family:'Segoe UI',Arial,sans-serif;font-size:22px;line-height:1.3;color:#0a2650;">{$title}</h1>
                            <div style="font-family:'Segoe UI',Arial,sans-serif;font-size:15px;line-height:1.6;color:#37425a;">
                                {$bodyHtml}
                            </div>
                            {$ctaHtml}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:28px 32px 32px;">
                            <hr style="border:none;border-top:1px solid #dfe5ee;margin:0 0 20px;">
                            <table role="presentation" cellpadding="0" cellspacing="0" style="font-family:'Segoe UI',Arial,sans-serif;font-size:13px;color:#7c88a0;">
                                <tr>
                                    <td style="padding-bottom:4px;"><strong style="color:#37425a;">{$siteName}</strong> &middot; Montáž a servis klimatizácií</td>
                                </tr>
                                <tr>
                                    <td style="padding-bottom:4px;">
                                        <a href="tel:{$phoneTel}" style="color:#1668c4;text-decoration:none;">{$phone}</a>
                                        &nbsp;&middot;&nbsp;
                                        <a href="mailto:{$companyEmail}" style="color:#1668c4;text-decoration:none;">{$companyEmail}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top:8px;color:#c7d0de;">&copy; {$year} {$siteName}. Všetky práva vyhradené.</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    </body>
    </html>
    HTML;
}

/** Riadok "Štítok: hodnota" pre súhrnnú kartu v e-maile. */
function emailField(string $label, string $value): string
{
    $label = e($label);
    $value = nl2br(e($value));
    return <<<HTML
    <tr>
        <td style="padding:9px 0;border-bottom:1px solid #edf1f7;font-size:13px;color:#7c88a0;width:130px;vertical-align:top;">{$label}</td>
        <td style="padding:9px 0;border-bottom:1px solid #edf1f7;font-size:15px;color:#131b2c;vertical-align:top;">{$value}</td>
    </tr>
    HTML;
}
