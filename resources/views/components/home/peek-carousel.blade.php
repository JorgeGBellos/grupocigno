@props([
    'images',
    'alt' => '',
    'trackClass' => 'bg-beige-300',
    'barClass' => 'bg-yellow-gold-500',
])

<div
    {{ $attributes->class('carousel w-full select-none') }}
    x-data="peekCarousel({{ count($images) }})"
    role="group"
    aria-roledescription="carousel"
>
    <div
        x-ref="viewport"
        class="relative overflow-hidden"
        :class="dragging ? 'cursor-grabbing' : 'cursor-grab'"
        style="touch-action: pan-y;"
        tabindex="0"
        @pointerdown="start($event)"
        @pointermove="move($event)"
        @pointerup="end($event)"
        @pointercancel="end($event)"
        @keydown.arrow-left.prevent="prev()"
        @keydown.arrow-right.prevent="next()"
    >
        <div x-ref="track" class="carousel-track">
            @foreach ([0, 1, 2] as $copy)
                @foreach ($images as $image)
                    <div class="carousel-slide" @if ($copy !== 1) aria-hidden="true" @endif>
                        <img
                            src="{{ asset($image) }}"
                            alt="{{ $copy === 1 ? $alt : '' }}"
                            class="size-full object-cover"
                            draggable="false"
                        >
                    </div>
                @endforeach
            @endforeach
        </div>

        <button
            type="button"
            class="absolute inset-y-0 left-0 z-10 min-w-11 w-(--carousel-peek)"
            @click="moved || prev()"
            aria-label="{{ __('ui.previous_image') }}"
        ></button>

        <button
            type="button"
            class="absolute inset-y-0 right-0 z-10 min-w-11 w-(--carousel-peek)"
            @click="moved || next()"
            aria-label="{{ __('ui.next_image') }}"
        ></button>
    </div>

    <div class="mx-auto mt-8 h-px w-full max-w-xl {{ $trackClass }}" aria-hidden="true">
        <div class="h-px {{ $barClass }}" :style="`width: ${progress}%`"></div>
    </div>
</div>
