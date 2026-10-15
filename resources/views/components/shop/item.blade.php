@props([
    'category',
    'products',
])

@php
    $products = array_values($products);
    $hasCarousel = count($products) > 1;
@endphp

<article
    class="flex h-full flex-col items-center text-center"
    @if ($hasCarousel)
        x-data="shopProductCarousel({{ \Illuminate\Support\Js::from(collect($products)->map(fn ($product) => [
            'brand' => $product['brand'],
            'body' => $product['body'],
            'image' => str_starts_with($product['image'], 'http') || str_starts_with($product['image'], '/')
                ? $product['image']
                : asset($product['image']),
        ])->values()) }})"
    @endif
>
    <h3 class="type-h3 min-h-[2.75em]">{{ $category }}</h3>

    @if ($hasCarousel)
        <div
            class="mt-8 flex w-full flex-1 flex-col select-none"
            :class="dragging ? 'cursor-grabbing' : 'cursor-grab'"
            style="touch-action: pan-y;"
            tabindex="0"
            role="group"
            aria-roledescription="carousel"
            aria-label="{{ $category }}"
            @pointerdown="start($event)"
            @pointermove="move($event)"
            @pointerup="end($event)"
            @pointercancel="end($event)"
            @keydown.arrow-left.prevent="prev()"
            @keydown.arrow-right.prevent="next()"
        >
            <div class="overflow-hidden">
                <img
                    :src="current.image"
                    :alt="current.brand"
                    class="aspect-[790/417] w-full object-cover"
                    draggable="false"
                >
            </div>

            <p class="type-b1 mt-8 min-h-[1.5em]" x-text="current.brand"></p>
            <p class="type-b3 mx-auto mt-4 min-h-[6.5em] max-w-md" x-text="current.body"></p>
        </div>
    @else
        <img
            src="{{ str_starts_with($products[0]['image'], 'http') || str_starts_with($products[0]['image'], '/') ? $products[0]['image'] : asset($products[0]['image']) }}"
            alt="{{ $products[0]['brand'] }}"
            class="mt-8 aspect-[790/417] w-full object-cover"
        >

        <p class="type-b1 mt-8 min-h-[1.5em]">{{ $products[0]['brand'] }}</p>
        <p class="type-b3 mx-auto mt-4 min-h-[6.5em] max-w-md">{{ $products[0]['body'] }}</p>
    @endif

    @if ($hasCarousel)
        <div class="mt-auto w-full max-w-md pt-8" aria-hidden="true">
            <div class="h-px w-full bg-beige-300">
                <div class="h-px bg-yellow-gold-500 transition-[width] duration-200" :style="`width: ${progress}%`"></div>
            </div>
        </div>
    @endif
</article>
