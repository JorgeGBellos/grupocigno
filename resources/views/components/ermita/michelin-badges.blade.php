@props([
    'tone' => 'light',
    'size' => 'default',
])

@php
    $toneClass = $tone === 'dark' ? 'brightness-0' : '';
    $isMenu = $size === 'menu';
    $yearClass = $isMenu
        ? 'h-3 w-auto max-h-3 shrink-0 xl:h-3.5 xl:max-h-3.5'
        : 'h-3.5 w-auto shrink-0 sm:h-4';
    $guideClass = $isMenu
        ? 'h-7 w-auto max-h-7 shrink-0 xl:h-8 xl:max-h-8'
        : 'h-9 w-auto shrink-0 sm:h-10';
@endphp

<div {{ $attributes->class([
    'flex flex-nowrap items-center justify-center',
    $isMenu ? 'gap-x-2.5 xl:gap-x-3' : 'gap-x-3 sm:gap-x-4',
]) }}>
    <img
        src="{{ asset('images/ermita/michelin-2024.svg') }}"
        alt="{{ __('nav.michelin_2024') }}"
        class="{{ $yearClass }} {{ $toneClass }}"
    >
    <img
        src="{{ asset('images/ermita/michelin-2025.svg') }}"
        alt="{{ __('nav.michelin_2025') }}"
        class="{{ $yearClass }} {{ $toneClass }}"
    >
    <img
        src="{{ asset('images/ermita/michelin-2026.svg') }}"
        alt="{{ __('nav.michelin_2026') }}"
        class="{{ $guideClass }} {{ $toneClass }}"
    >
</div>
