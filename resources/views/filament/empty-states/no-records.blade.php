@props(['heading' => null, 'description' => null])

<div style="display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 1rem; padding: 2rem 0; text-align: center;">
    <svg width="160" height="120" viewBox="0 0 240 180" fill="none" xmlns="http://www.w3.org/2000/svg">
        <ellipse cx="120" cy="158" rx="70" ry="10" fill="#94A3B8" fill-opacity="0.15" />

        <path d="M48 74L120 40L192 74L192 132C192 136.418 188.418 140 184 140H56C51.5817 140 48 136.418 48 132L48 74Z"
            fill="#94A3B8" fill-opacity="0.18" />
        <path d="M48 74L120 40L192 74L120 108L48 74Z" fill="#94A3B8" fill-opacity="0.32" />
        <path d="M120 108L192 74V132C192 136.418 188.418 140 184 140H120V108Z" fill="#94A3B8"
            fill-opacity="0.1" />

        <circle cx="120" cy="74" r="34" fill="#00C853" fill-opacity="0.12" />
        <path d="M104 74a16 16 0 1 1 22.6 14.6" stroke="#00C853" stroke-width="4" stroke-linecap="round"
            fill="none" />
        <circle cx="120" cy="74" r="3" fill="#00C853" />
        <circle cx="120" cy="90" r="3" fill="#00C853" />
    </svg>

    <div>
        @if ($heading)
            <p style="margin: 0; font-size: 0.9375rem; font-weight: 600; color: rgb(9, 9, 11);">{{ $heading }}</p>
        @endif

        @if ($description)
            <p style="margin: 0.25rem 0 0; font-size: 0.875rem; color: rgb(113, 113, 122);">{{ $description }}</p>
        @endif
    </div>
</div>
