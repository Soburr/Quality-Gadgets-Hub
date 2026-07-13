@props(['name', 'size' => 20])

<svg width="{{ $size }}" height="{{ $size }}" viewBox="0 0 24 24" fill="none" {{ $attributes }}>
    @switch($name)
        @case('phone')
            <rect x="8" y="4" width="10" height="18" rx="2" stroke="currentColor" stroke-width="1.8" fill="none"/>
            <circle cx="13" cy="18.5" r=".9" fill="currentColor"/>
            @break
        @case('tablet')
            <rect x="5" y="4" width="16" height="18" rx="2" stroke="currentColor" stroke-width="1.8" fill="none"/>
            <circle cx="13" cy="18.5" r=".9" fill="currentColor"/>
            @break
        @case('watch')
            <rect x="8" y="8" width="10" height="10" rx="2.5" stroke="currentColor" stroke-width="1.8" fill="none"/>
            <path d="M10 8V5h6v3M10 18v3h6v-3" stroke="currentColor" stroke-width="1.8"/>
            @break
        @case('earbud')
            <circle cx="9" cy="9" r="3" stroke="currentColor" stroke-width="1.8" fill="none"/>
            <circle cx="19" cy="9" r="3" stroke="currentColor" stroke-width="1.8" fill="none"/>
            <path d="M9 12v4a3 3 0 003 3M19 12v4a3 3 0 01-3 3" stroke="currentColor" stroke-width="1.8" fill="none"/>
            @break
        @case('battery')
            <rect x="6" y="8" width="14" height="10" rx="2" stroke="currentColor" stroke-width="1.8" fill="none"/>
            <path d="M20 11h2v4h-2" stroke="currentColor" stroke-width="1.8" fill="none"/>
            <path d="M13 10l-3 4h3l-1 4 4-5h-3z" fill="currentColor"/>
            @break
        @case('plug')
            <path d="M9 7v4M15 7v4M8 11h8v3a4 4 0 01-4 4 4 4 0 01-4-4v-3z" stroke="currentColor" stroke-width="1.8" fill="none"/>
            <path d="M12 18v3" stroke="currentColor" stroke-width="1.8"/>
            @break
        @case('case')
            <rect x="7" y="4" width="12" height="18" rx="3" stroke="currentColor" stroke-width="1.8" fill="none"/>
            <path d="M7 9h12" stroke="currentColor" stroke-width="1.8"/>
            @break
        @case('shield')
            <path d="M13 3l7 3v6c0 5-3 8-7 9-4-1-7-4-7-9V6l7-3z" stroke="currentColor" stroke-width="1.8" fill="none"/>
            @break
        @case('refresh')
            <path d="M20 8a8 8 0 00-14.5-3M6 4v5h5M6 18a8 8 0 0014.5 3M20 22v-5h-5" stroke="currentColor" stroke-width="1.8" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
            @break
        @case('game')
            <rect x="4" y="9" width="18" height="9" rx="4" stroke="currentColor" stroke-width="1.8" fill="none"/>
            <path d="M9 12v3M7.5 13.5h3" stroke="currentColor" stroke-width="1.8"/>
            <circle cx="17" cy="12.5" r=".9" fill="currentColor"/>
            <circle cx="15.5" cy="14.5" r=".9" fill="currentColor"/>
            @break
        @case('signal')
            <path d="M5 19V15M10 19V11M15 19V7M20 19V4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
            @break
        @case('dots')
            <circle cx="8" cy="8" r="1.6" fill="currentColor"/>
            <circle cx="16" cy="8" r="1.6" fill="currentColor"/>
            <circle cx="8" cy="16" r="1.6" fill="currentColor"/>
            <circle cx="16" cy="16" r="1.6" fill="currentColor"/>
            @break
        @case('search')
            <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/>
            <path d="M21 21l-4.3-4.3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            @break
        @case('user')
            <path d="M20 21a8 8 0 10-16 0" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            <circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="2"/>
            @break
        @case('heart')
            <path d="M20.8 4.6a5.5 5.5 0 00-7.8 0L12 5.6l-1-1a5.5 5.5 0 10-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 000-7.8z" stroke="currentColor" stroke-width="2"/>
            @break
        @case('cart')
            <path d="M3 4h2l1.2 12.4A2 2 0 008.2 18h9.6a2 2 0 002-1.7L21 8H6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <circle cx="9" cy="21" r="1.4" fill="currentColor"/>
            <circle cx="18" cy="21" r="1.4" fill="currentColor"/>
            @break
        @case('check')
            <path d="M9 12l2 2 4-4" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/>
            <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2"/>
            @break
        @case('truck')
            <rect x="3" y="7" width="18" height="12" rx="2" stroke="currentColor" stroke-width="2"/>
            <path d="M16 11h3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            @break
        @case('arrow-right')
            <path d="M5 12h14M13 5l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            @break
        @case('box')
            <path d="M3 7l9-4 9 4-9 4-9-4z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
            <path d="M3 7v10l9 4 9-4V7" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
            @break
        @case('menu')
            <path d="M4 7h16M4 12h16M4 17h16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            @break
        @case('close')
            <path d="M6 6l12 12M18 6L6 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            @break
        @case('chevron-down')
            <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            @break
        @case('arrow-left')
            <path d="M19 12H5M12 19l-7-7 7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            @break
        @case('menu')
            <path d="M4 7h16M4 12h16M4 17h16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            @break
        @case('close')
            <path d="M6 6l12 12M18 6L6 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            @break
        @case('chevron-down')
            <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            @break
        @case('arrow-left')
            <path d="M19 12H5M12 19l-7-7 7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            @break
        @case('support')
            <path d="M4 13v-1a8 8 0 0116 0v1" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
            <rect x="3" y="13" width="5" height="6" rx="2" stroke="currentColor" stroke-width="1.8"/>
            <rect x="16" y="13" width="5" height="6" rx="2" stroke="currentColor" stroke-width="1.8"/>
            <path d="M20 19a4 4 0 01-4 4h-2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
            @break
        @case('minus')
            <path d="M5 12h14" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/>
            @break
        @case('plus')
            <path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/>
            @break
    @endswitch
</svg>
