@props([
    'iconClass' => 'size-10',
    'brand' => null,
])

@php
    $brandKey = $brand
        ?? collect(config('navigation.brands'))
            ->first(fn (array $item): bool => filled($item['match'] ?? null) && request()->routeIs($item['match']))['key']
        ?? 'main';

    $instagramUrl = config('social.instagram.'.$brandKey) ?? config('social.instagram.main');
    $phone = config('social.phone.'.$brandKey);
    $phoneHref = filled($phone)
        ? 'tel:'.preg_replace('/\D+/', '', (string) $phone)
        : route('contact');
@endphp

<div {{ $attributes->class(['flex items-center gap-6']) }}>
    <a href="{{ $phoneHref }}" class="transition-opacity duration-300 hover:opacity-40" aria-label="{{ __('ui.call') }}">
        <img
            src="{{ asset('images/footer/llamada.svg') }}"
            alt=""
            width="40"
            height="40"
            @class([$iconClass])
        >
    </a>
    <a
        href="{{ $instagramUrl }}"
        class="transition-opacity duration-300 hover:opacity-40"
        aria-label="{{ __('ui.instagram') }}"
        target="_blank"
        rel="noopener noreferrer"
    >
        <img
            src="{{ asset('images/footer/ig.svg') }}"
            alt=""
            width="40"
            height="40"
            @class([$iconClass])
        >
    </a>
</div>
