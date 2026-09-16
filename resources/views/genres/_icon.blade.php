@php
    [$svg, $c] = match($genre->slug) {
        'action' => [
            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>',
            $color['text'] ?? 'text-blue-400',
        ],
        'adventure' => [
            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/>',
            $color['text'] ?? 'text-blue-400',
        ],
        'rpg' => [
            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3l1.5 4.5L18 9l-4.5 1.5L12 15l-1.5-4.5L6 9l4.5-1.5L12 3z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 17l1.5 3H6l-1.5 3v-6H6zm9 0l1.5 3h1.5l-1.5 3v-6H15z"/>',
            $color['text'] ?? 'text-blue-400',
        ],
        'shooter' => [
            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8a4 4 0 100 8 4 4 0 000-8z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12h3m12 0h3M12 3v3m0 12v3"/>',
            $color['text'] ?? 'text-blue-400',
        ],
        'strategy' => [
            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 3h12M6 21h12M9 3v6a3 3 0 106 0V3M12 9v6a3 3 0 106 0V9M6 15h2M16 15h2"/>',
            $color['text'] ?? 'text-blue-400',
        ],
        'simulation' => [
            '<circle cx="12" cy="12" r="9" stroke-width="2" stroke="currentColor" fill="none"/><path stroke-linecap="round" stroke-width="2" d="M12 3v18M3 12h18M5.6 5.6l12.8 12.8M18.4 5.6L5.6 18.4"/>',
            $color['text'] ?? 'text-blue-400',
        ],
        'sports' => [
            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2c4.418 0 8 3.582 8 8s-3.582 8-8 8-8-3.582-8-8 3.582-8 8-8z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.93 4.93l14.14 14.14M19.07 4.93L4.93 19.07M12 2v18M2 12h18"/>',
            $color['text'] ?? 'text-blue-400',
        ],
        'racing' => [
            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3a9 9 0 100 18 9 9 0 000-18z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v18"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12h9"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 8l3-1"/>',
            $color['text'] ?? 'text-blue-400',
        ],
        'fighting' => [
            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3v8a6 6 0 0012 0V3"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 3v4.5M11 3v4.5"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 17h4v4"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h4v-4a4 4 0 00-4-4h-4v4a4 4 0 004 4z"/>',
            $color['text'] ?? 'text-blue-400',
        ],
        'horror' => [
            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3a9 9 0 110 18 9 9 0 010-18z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14a4 4 0 008 0"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10h.01"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10h.01"/>',
            $color['text'] ?? 'text-blue-400',
        ],
        'puzzle' => [
            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 11a2 2 0 10-4 0 2 2 0 00-4 0V3a2 2 0 00-4 0v4a2 2 0 00-4 0v2a2 2 0 004 0 2 2 0 004 0 2 2 0 004 0 2 2 0 004 0v-2a2 2 0 10-4 0 2 2 0 00-4 0v8a2 2 0 004 0v2a2 2 0 104 0 2 2 0 104 0v-2a2 2 0 004 0v-8z"/>',
            $color['text'] ?? 'text-blue-400',
        ],
        'platformer' => [
            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21l6-6 3 3 4-4 2 2 3-3"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 13l6-6 3 3 4-4 2 2 3-3"/>',
            $color['text'] ?? 'text-blue-400',
        ],
        'indie' => [
            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2l2.4 7.2H22l-6 4.6 2.3 7.2-6.3-4.6-6.3 4.6L8 13.8 2 9.2h7.6L12 2z"/>',
            $color['text'] ?? 'text-blue-400',
        ],
        'multiplayer' => [
            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4" stroke-width="2" stroke="currentColor" fill="none"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M23 21v-2a4 4 0 00-3-3.87"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 3.13a4 4 0 010 7.75"/>',
            $color['text'] ?? 'text-blue-400',
        ],
        'open-world' => [
            '<circle cx="12" cy="12" r="9" stroke-width="2" stroke="currentColor" fill="none"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12h18"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3c-3 3-3 6-3 9s0 6 3 9"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3c3 3 3 6 3 9s0 6-3 9"/>',
            $color['text'] ?? 'text-blue-400',
        ],
        default => [
            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2z"/>',
            $color['text'] ?? 'text-blue-400',
        ],
    };
@endphp
<svg class="h-6 w-6 {{ $c }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    {!! $svg !!}
</svg>