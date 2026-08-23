<?php
/**
 * Inline SVG logo "Klíma Turiec" — tri vrcholy (Turiec v horách) + snehová vločka.
 * Vykresľuje sa priamo v HTML (nie ako <img>), preto dedí webfont Poppins.
 */

declare(strict_types=1);

function renderLogo(string $variant = 'color', string $layout = 'horizontal', string $class = ''): string
{
    $isWhite = $variant === 'white';
    $inkStrong = $isWhite ? '#ffffff' : '#0a2f66';
    $inkSoft = $isWhite ? 'rgba(255,255,255,.78)' : '#1668c4';
    $gradId = 'lgMtn' . ($isWhite ? 'W' : 'C') . substr(md5($layout . $class), 0, 4);

    $mark = '<svg class="brand-mark" viewBox="0 0 64 58" width="42" height="38" fill="none" aria-hidden="true">
        <defs>
            <linearGradient id="' . $gradId . '" x1="2" y1="52" x2="62" y2="10" gradientUnits="userSpaceOnUse">
                <stop offset="0" stop-color="' . ($isWhite ? '#eaf4ff' : '#4aa2f5') . '"/>
                <stop offset="1" stop-color="' . ($isWhite ? '#ffffff' : '#0a2650') . '"/>
            </linearGradient>
        </defs>
        <path d="M2 52 L15 22 L23 36 L2 52Z" fill="none" stroke="url(#' . $gradId . ')" stroke-width="2.4" stroke-linejoin="round" opacity="0.55"/>
        <path d="M62 52 L49 22 L41 36 L62 52Z" fill="none" stroke="url(#' . $gradId . ')" stroke-width="2.4" stroke-linejoin="round" opacity="0.55"/>
        <path d="M32 6 L50 52 L14 52 Z" fill="none" stroke="url(#' . $gradId . ')" stroke-width="3.4" stroke-linejoin="round" stroke-linecap="round"/>
        <path d="M32 6 L38 24 L32 34 L26 24Z" fill="' . ($isWhite ? 'rgba(255,255,255,.16)' : 'rgba(22,104,196,.12)') . '"/>
        <g transform="translate(32,42)" stroke="' . ($isWhite ? '#ffffff' : '#eaf4ff') . '" stroke-width="1.5" stroke-linecap="round">
            <path d="M0 -7 V7 M-6 -3.5 L6 3.5 M6 -3.5 L-6 3.5"/>
            <path d="M0 -7 L-2 -4.3 M0 -7 L2 -4.3 M0 7 L-2 4.3 M0 7 L2 4.3"/>
            <path d="M-6 -3.5 L-6.4 -0.9 M-6 -3.5 L-3.6 -4.9 M6 3.5 L6.4 0.9 M6 3.5 L3.6 4.9"/>
            <path d="M6 -3.5 L6.4 -0.9 M6 -3.5 L3.6 -4.9 M-6 3.5 L-6.4 0.9 M-6 3.5 L-3.6 4.9"/>
        </g>
    </svg>';

    $wordStacked = $layout === 'stacked';
    $wordmark = '<span class="brand-word' . ($wordStacked ? ' brand-word--stacked' : '') . '" style="color:' . $inkStrong . '">KLÍMA<span style="color:' . $inkSoft . '"> TURIEC</span></span>';

    $tag = $layout === 'stacked' ? 'brand-lockup brand-lockup--stacked' : 'brand-lockup';
    return '<span class="' . $tag . ($class ? ' ' . e($class) : '') . '">' . $mark . $wordmark . '</span>';
}
