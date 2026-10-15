@props([
    'image' => 'images/mejorada/home-rooms-pool-divider.jpg',
    'alt' => 'Alberca y patio de Cigno Mejorada',
])

<div class="relative w-full overflow-hidden aspect-[16/6] max-h-[580px] bg-beige-300">
    <img
        src="{{ asset($image) }}"
        alt="{{ $alt }}"
        class="size-full object-cover object-center"
        loading="lazy"
    >
</div>
