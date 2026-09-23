<?php
/**
 * Jednoduchá ochrana formulárov proti spamu (bez CAPTCHA):
 * honeypot pole (viď kontakt.php) + podpísaná časová pečiatka, ktorá
 * odhalí boty odosielajúce formulár okamžite po načítaní stránky.
 */

declare(strict_types=1);

/** Skryté pole s podpísaným časom vykreslenia formulára. */
function formTimestampField(): string
{
    $ts = (string) time();
    $sig = substr(hash_hmac('sha256', $ts, FORM_SECRET), 0, 16);
    return '<input type="hidden" name="ts" value="' . e($ts . '.' . $sig) . '">';
}

/**
 * Overí, že formulár bol odoslaný minimálne $minSeconds po vykreslení
 * (bránia bez toho, aby skutočný návštevník niečo postrehol) a že
 * hodnota nebola podvrhnutá (podpis sedí).
 */
function formTimestampValid(string $value, int $minSeconds = 3, int $maxSeconds = 21600): bool
{
    $parts = explode('.', $value, 2);
    if (count($parts) !== 2) {
        return false;
    }
    [$ts, $sig] = $parts;
    if (!ctype_digit($ts)) {
        return false;
    }
    $expected = substr(hash_hmac('sha256', $ts, FORM_SECRET), 0, 16);
    if (!hash_equals($expected, $sig)) {
        return false;
    }
    $elapsed = time() - (int) $ts;
    return $elapsed >= $minSeconds && $elapsed <= $maxSeconds;
}

/** True, ak text obsahuje 2 a viac odkazov — typický znak spamu. */
function looksLikeLinkSpam(string $text): bool
{
    return preg_match_all('/(https?:\/\/|www\.)/i', $text) >= 2;
}
