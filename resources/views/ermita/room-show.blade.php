@php
    $exclusive = $room['exclusive'] ?? [];
@endphp

<x-layouts.app :title="$room['title'].' — '.__('nav.ermita')">
    <section class="flex flex-1 flex-col bg-off-white-300 px-6 py-12 text-black-500 lg:px-10 lg:py-16">
        <div class="mx-auto w-full max-w-4xl">
            <div class="text-center">
                <a
                    href="{{ route('cigno-ermita.rooms') }}"
                    class="type-label text-blue-ermita-300 transition-opacity duration-300 hover:opacity-40"
                >
                    {{ __('ermita.rooms_page.back') }}
                </a>
            </div>

            <div class="mt-8 overflow-hidden bg-beige-300">
                <img
                    src="{{ asset($room['image']) }}"
                    alt="{{ $room['title'] }}"
                    class="aspect-[16/10] w-full object-cover"
                >
            </div>

            <div class="mt-8">
                <x-ermita.button
                    :href="route('cigno-ermita').'#booking'"
                    class="w-full"
                >
                    {{ __('ermita.rooms_page.reserve') }}
                </x-ermita.button>
            </div>

            <div class="mx-auto mt-12 max-w-2xl text-center">
                <h1 class="type-h1">{{ $room['title'] }}</h1>
                <p class="type-b2 mt-4">{{ $room['price'] }}</p>

                <div class="mt-8 flex flex-wrap items-center justify-center gap-x-8 gap-y-3">
                    <span class="type-label inline-flex items-center gap-3">
                        <img
                            src="{{ asset('images/ermita/Component 1 (7).svg') }}"
                            alt=""
                            width="44"
                            height="44"
                            class="size-11 shrink-0"
                        >
                        {{ $room['people'] === 1
                            ? __('ermita.rooms.max_people_one')
                            : __('ermita.rooms.max_people', ['count' => $room['people']]) }}
                    </span>
                    <span class="type-label inline-flex items-center gap-3">
                        <img
                            src="{{ asset('images/ermita/Component 1 (6).svg') }}"
                            alt=""
                            width="44"
                            height="44"
                            class="size-11 shrink-0"
                        >
                        {{ $room['beds'] === 1
                            ? __('ermita.rooms.beds_one')
                            : __('ermita.rooms.beds_other', ['count' => $room['beds']]) }}
                    </span>
                </div>

                <p class="type-b2 mt-10 text-pretty">{{ $room['detail'] ?? $room['body'] }}</p>
                <p class="type-b3 mt-6">{{ $room['size'] }}</p>
            </div>

            @if (count($exclusive))
                <div class="mx-auto mt-16 max-w-2xl text-center">
                    <h2 class="type-h3">{{ __('ermita.rooms_page.only_in_room') }}</h2>
                    <ul class="type-b2 mt-6 space-y-2">
                        @foreach ($exclusive as $item)
                            <li>• {{ $item }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mx-auto mt-16 max-w-3xl text-center">
                <h2 class="type-h3">{{ __('ermita.rooms_page.all_rooms') }}</h2>
                <ul class="type-b2 mt-8 grid grid-cols-1 gap-x-12 gap-y-3 text-left sm:grid-cols-2">
                    @foreach ($sharedAmenities as $amenity)
                        <li>• {{ $amenity }}</li>
                    @endforeach
                </ul>
            </div>

            @if (count($offers))
                <div class="mt-20 text-center">
                    <h2 class="type-h3">{{ __('ermita.rooms_page.offers_title') }}</h2>

                    <div
                        class="carousel mx-auto mt-10 w-full max-w-3xl select-none"
                        x-data="peekCarousel({{ count($offers) }})"
                        role="group"
                        aria-roledescription="carousel"
                        aria-label="{{ __('ermita.rooms_page.offers_title') }}"
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
                                    @foreach ($offers as $offer)
                                        <article
                                            class="carousel-slide !aspect-auto flex min-h-[16rem] flex-col rounded-[24px] border border-beige-300 bg-off-white-100 px-8 py-10 text-center lg:px-10"
                                            @if ($copy !== 1) aria-hidden="true" @endif
                                        >
                                            <h3 class="type-h3 text-balance">{{ $offer['title'] }}</h3>
                                            <p class="type-b3 mt-4">{{ $offer['dates'] }}</p>
                                            <ul class="type-b3 mt-6 grid flex-1 grid-cols-1 gap-2 sm:grid-cols-2">
                                                @foreach ($offer['perks'] as $perk)
                                                    <li>• {{ $perk }}</li>
                                                @endforeach
                                            </ul>
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

                        <div class="mx-auto mt-8 h-px w-full max-w-xl bg-beige-300" aria-hidden="true">
                            <div class="h-px bg-blue-ermita-300 transition-[width] duration-200" :style="`width: ${progress}%`"></div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
</x-layouts.app>
