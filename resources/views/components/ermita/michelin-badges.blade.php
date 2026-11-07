@props([
    'tone' => 'light',
    'size' => 'default',
])

@php
    $toneClass = $tone === 'dark' ? 'brightness-0' : '';
    $isMenu = $size === 'menu';
    $logoClass = $isMenu
        ? 'h-3 w-auto max-w-full shrink-0 xl:h-3.5'
        : 'h-3.5 w-auto max-w-full shrink-0 sm:h-4';
@endphp

<div {{ $attributes->class([
    'flex flex-nowrap items-center justify-center',
]) }}>
    <img
        src="{{ asset('images/Llaves.svg') }}"
        alt="{{ __('nav.michelin_2026') }}"
        class="{{ $logoClass }} {{ $toneClass }}"
    >
</div>
