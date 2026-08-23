<?php
/**
 * Sada inline SVG ikon (bez externých závislostí, farba dedí currentColor).
 */

declare(strict_types=1);

function icon(string $name): string
{
    $icons = [
        'phone' => '<path d="M6.6 10.8c1.4 2.8 3.8 5.2 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1C10.9 21 3 13.1 3 3.4c0-.6.4-1 1-1h3.4c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.6.1.4 0 .8-.2 1L6.6 10.8Z"/>',
        'mail' => '<path d="M4 5h16a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="m3.5 6.5 8.5 6.2 8.5-6.2" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>',
        'pin' => '<path d="M12 22s7-6.6 7-12.6A7 7 0 0 0 5 9.4C5 15.4 12 22 12 22Z" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><circle cx="12" cy="9.5" r="2.5" fill="none" stroke="currentColor" stroke-width="1.6"/>',
        'clock' => '<circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="1.6"/><path d="M12 7v5.3l3.6 2.1" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>',
        'menu' => '<path d="M3 6h18M3 12h18M3 18h18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>',
        'close' => '<path d="M5 5l14 14M19 5 5 19" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>',
        'arrow-right' => '<path d="M4 12h15M13 6l6 6-6 6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>',
        'arrow-up' => '<path d="M12 19V5M6 11l6-6 6 6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>',
        'check' => '<path d="M4 12.5 9.5 18 20 6" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/>',
        'check-circle' => '<circle cx="12" cy="12" r="10"/><path d="m7.5 12.5 3 3 6-6.5" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>',
        'snowflake' => '<path d="M12 2v20M4.5 6.5l15 11M19.5 6.5l-15 11" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M12 2 9.8 4.6M12 2l2.2 2.6M12 22l-2.2-2.6M12 22l2.2-2.6M4.5 6.5 6 9.4M4.5 6.5l3.4-.4M19.5 6.5 18 9.4m1.5-2.9-3.4-.4M4.5 17.5 6 14.6m-1.5 2.9 3.4.4M19.5 17.5 18 14.6m1.5 2.9-3.4.4" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>',
        'gauge' => '<circle cx="12" cy="13" r="8"/><path d="M12 13 15.5 9M8 13h.01M12 5.5v.01M16 13h.01" stroke="#fff" stroke-width="1.6" stroke-linecap="round" fill="none"/>',
        'tool' => '<path d="M14.7 6.3a4 4 0 0 1-5.4 5.4L4 17l3 3 5.3-5.3a4 4 0 0 1 5.4-5.4L14.7 6.3Z" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>',
        'shield' => '<path d="M12 2 4 5v6c0 5 3.4 8.7 8 10 4.6-1.3 8-5 8-10V5l-8-3Z"/><path d="m8.5 12 2.5 2.5L16 9" fill="none" stroke="#fff" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>',
        'sun' => '<circle cx="12" cy="12" r="4.2"/><path d="M12 2.5v2.6M12 18.9v2.6M4.6 12H2M22 12h-2.6M5.6 5.6l1.9 1.9M16.5 16.5l1.9 1.9M18.4 5.6l-1.9 1.9M7.5 16.5l-1.9 1.9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>',
        'leaf' => '<path d="M20 4C9 4 4 9.5 4 17c0 1.7 1.3 3 3 3 7.5 0 13-5 13-16Z" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M8 20c2-4 5-7.5 12-13" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>',
        'spark' => '<path d="M12 2 9.8 9.8 2 12l7.8 2.2L12 22l2.2-7.8L22 12l-7.8-2.2Z"/>',
        'filter' => '<path d="M4 5h16l-6 7.5V19l-4 2v-8.5L4 5Z" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>',
        'facebook' => '<path d="M14 22v-8h2.7l.4-3H14V9c0-.9.2-1.5 1.6-1.5H17V4.9C16.7 4.9 15.7 4.8 14.6 4.8 12.2 4.8 10.6 6.3 10.6 8.7V11H8v3h2.6v8H14Z"/>',
        'instagram' => '<rect x="3" y="3" width="18" height="18" rx="5" fill="none" stroke="currentColor" stroke-width="1.7"/><circle cx="12" cy="12" r="4.2" fill="none" stroke="currentColor" stroke-width="1.7"/><circle cx="17.3" cy="6.7" r="1.2"/>',
        'chevron-down' => '<path d="m6 9 6 6 6-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>',
        'star' => '<path d="M12 2.5 15 9l7 1-5.2 5 1.4 7-6.2-3.4L5.8 22l1.4-7L2 10l7-1 3-6.5Z"/>',
        'quote' => '<path d="M9.5 6.5C6 7.7 4 10 4 13.4 4 15.9 5.7 17.5 8 17.5c2 0 3.5-1.4 3.5-3.4 0-1.8-1.2-3.1-2.9-3.2.4-1.6 1.7-2.8 3.4-3.4L9.5 6.5Zm9 0C15 7.7 13 10 13 13.4c0 2.5 1.7 4.1 4 4.1 2 0 3.5-1.4 3.5-3.4 0-1.8-1.2-3.1-2.9-3.2.4-1.6 1.7-2.8 3.4-3.4L18.5 6.5Z"/>',
        'building' => '<path d="M4 21V4h9v17M13 21h7V9h-7M7 8h2M7 11h2M7 14h2M16 12h2M16 15h2M16 18h2" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>',
        'route' => '<circle cx="6" cy="6" r="2.3"/><circle cx="18" cy="18" r="2.3"/><path d="M6 8.3v3.2A4.5 4.5 0 0 0 10.5 16H14a4 4 0 0 0 4-4" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>',
    ];

    if (!isset($icons[$name])) {
        return '';
    }

    return '<svg class="icon icon--' . e($name) . '" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">' . $icons[$name] . '</svg>';
}
