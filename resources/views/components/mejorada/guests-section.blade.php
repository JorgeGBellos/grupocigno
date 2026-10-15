@php
    $cms = cms('cigno-mejorada');
    $items = __('mejorada.guests.items');
@endphp

<section class="bg-off-white-300 px-6 py-20 text-black-500 lg:px-10 lg:py-28">
    <div class="mx-auto flex max-w-3xl flex-col items-center text-center">
        <img
            src="{{ asset('images/home/Swan (1).svg') }}"
            alt=""
            width="80"
            height="64"
            class="mb-6 h-16 w-auto object-contain"
            aria-hidden="true"
        >

        <h2 class="type-h1">{{ $cms->text('guests.title', 'mejorada.guests.title') }}</h2>
        <p class="type-b2 mt-4 max-w-xl">{{ $cms->text('guests.lead', 'mejorada.guests.lead') }}</p>
    </div>

    <div
        class="carousel mx-auto mt-14 w-full max-w-5xl select-none lg:mt-16"
        x-data="peekCarousel({{ count($items) }})"
        role="group"
        aria-roledescription="carousel"
        aria-label="{{ $cms->text('guests.title', 'mejorada.guests.title') }}"
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
            <div x-ref="track" class="carousel-track items-stretch">
                @foreach ([0, 1, 2] as $copy)
                    @foreach ($items as $item)
                        <article
                            class="carousel-slide !aspect-auto flex min-h-[22rem] flex-col rounded-[24px] bg-blue-mejorada-300 px-8 py-10 text-left text-white lg:min-h-[26rem] lg:px-12 lg:py-12"
                            @if ($copy !== 1) aria-hidden="true" @endif
                        >
                            <img
                                src="{{ asset('images/home/Guia (1).svg') }}"
                                alt=""
                                width="40"
                                height="40"
                                class="h-10 w-auto self-start brightness-0 invert"
                                aria-hidden="true"
                            >

                            <h3 class="type-h3 mt-6 text-balance text-white">{{ $item['title'] }}</h3>
                            <p class="type-b3 mt-5 flex-1 text-pretty text-white/95">{{ $item['body'] }}</p>
                            <p class="type-label mt-8 text-white">{{ $item['author'] }}</p>
                        </article>
                    @endforeach
                @endforeach
            </div>

            <button
                type="button"
                class="absolute inset-y-0 left-0 z-10 w-(--carousel-peek)"
                @click="moved || prev()"
                aria-label="{{ __('ui.previous_image') }}"
            ></button>

            <button
                type="button"
                class="absolute inset-y-0 right-0 z-10 w-(--carousel-peek)"
                @click="moved || next()"
                aria-label="{{ __('ui.next_image') }}"
            ></button>
        </div>

        <div class="mx-auto mt-10 h-px w-full max-w-xl bg-beige-300" aria-hidden="true">
            <div class="h-px bg-blue-mejorada-300 transition-[width] duration-200" :style="`width: ${progress}%`"></div>
        </div>
    </div>
</section>
