@props([
    'href' => null,
    'variant' => 'gold',
    'type' => 'button',
])

@php
    $variantClass = match ($variant) {
        // 4. solid: yellow-gold-300 → yellow-gold-500
        'solid' => 'border-yellow-gold-300 bg-yellow-gold-300 text-white hover:border-yellow-gold-500 hover:bg-yellow-gold-500',
        // 5. soft: off-white-100 → yellow-gold-100
        'soft' => 'border-yellow-gold-100 bg-off-white-100 text-yellow-gold-500 hover:border-yellow-gold-100 hover:bg-yellow-gold-100 hover:text-white',
        'white' => 'border-white bg-transparent text-white hover:bg-white hover:text-yellow-gold-500',
        // 5. soft on dark surfaces: white → yellow-gold-100
        'white-solid' => 'border-white bg-white text-yellow-gold-500 hover:border-yellow-gold-100 hover:bg-yellow-gold-100 hover:text-white',
        // 6. outline: white → beige-100
        default => 'border-yellow-gold-500 bg-white text-yellow-gold-500 hover:bg-beige-100',
    };

    $classes = implode(' ', [
        'type-btn-md no-underline uppercase tracking-[0.08em]',
        'inline-flex items-center justify-center rounded-[14px] border px-12 py-3.5 transition-colors duration-300',
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
