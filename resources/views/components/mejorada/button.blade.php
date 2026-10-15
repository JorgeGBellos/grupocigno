@props([
    'href' => null,
    'variant' => 'solid',
    'type' => 'button',
    'size' => 'md',
])

@php
    $variantClass = match ($variant) {
        // Outline: white → beige-100
        'outline' => 'border-blue-mejorada-300 bg-white text-blue-mejorada-300 hover:bg-beige-100',
        // Soft: off-white-100 → blue-mejorada-100
        'outline-soft' => 'border-blue-mejorada-100 bg-off-white-100 text-blue-mejorada-300 hover:border-blue-mejorada-100 hover:bg-blue-mejorada-100 hover:text-white',
        'white' => 'border-white bg-transparent text-white hover:bg-white hover:text-blue-mejorada-300',
        // Soft on dark surfaces: white → blue-mejorada-100
        'white-solid' => 'border-white bg-white text-blue-mejorada-300 hover:border-blue-mejorada-100 hover:bg-blue-mejorada-100 hover:text-white',
        // Solid: blue-mejorada-300 → blue-mejorada-500
        default => 'border-blue-mejorada-300 bg-blue-mejorada-300 text-white hover:border-blue-mejorada-500 hover:bg-blue-mejorada-500',
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
