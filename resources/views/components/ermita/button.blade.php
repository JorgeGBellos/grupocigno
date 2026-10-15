@props([
    'href' => null,
    'variant' => 'solid',
    'type' => 'button',
    'size' => 'md',
])

@php
    $variantClass = match ($variant) {
        // 3. outline: white → beige-100
        'outline' => 'border-blue-ermita-300 bg-white text-blue-ermita-300 hover:bg-beige-100',
        // 2. soft: off-white-100 → blue-ermita-100
        'outline-soft' => 'border-blue-ermita-100 bg-off-white-100 text-blue-ermita-300 hover:border-blue-ermita-100 hover:bg-blue-ermita-100 hover:text-white',
        'white' => 'border-white bg-transparent text-white hover:bg-white hover:text-blue-ermita-300',
        // 2. soft on dark surfaces: white → blue-ermita-100
        'white-solid' => 'border-white bg-white text-blue-ermita-300 hover:border-blue-ermita-100 hover:bg-blue-ermita-100 hover:text-white',
        // 1. solid: blue-ermita-300 → blue-ermita-500
        default => 'border-blue-ermita-300 bg-blue-ermita-300 text-white hover:border-blue-ermita-500 hover:bg-blue-ermita-500',
    };

    $sizeClass = $size === 'sm'
        ? 'type-btn-sm px-5 py-2.5'
        : 'type-btn-md px-6 py-3.5 sm:px-12';

    $classes = implode(' ', [
        $sizeClass,
        'no-underline uppercase tracking-[0.08em]',
        'inline-flex items-center justify-center rounded-[14px] border transition-colors duration-300',
        $variantClass,
    ]);
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
