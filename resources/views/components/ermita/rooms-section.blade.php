@php
    use App\Enums\CmsPageSlug;

    $cms = cms(CmsPageSlug::Ermita);
    $items = cms(CmsPageSlug::ErmitaRooms)->ermitaRoomTeasers();
@endphp

<section id="rooms" class="bg-off-white-300 px-6 py-16 text-black-500 sm:py-20 lg:px-10 lg:py-28">
    <div class="mx-auto grid max-w-6xl grid-cols-1 items-center gap-12 lg:grid-cols-[minmax(20rem,1.3fr)_minmax(0,1.7fr)] lg:gap-12 xl:gap-14">
        <div class="flex flex-col items-start lg:max-w-[26rem] xl:max-w-none">
            <img
                src="{{ asset('images/home/Swan (1).svg') }}"
                alt=""
                width="62"
                height="62"
                class="h-auto w-[62px]"
            >

            <h2 class="type-h2 mt-8 max-w-[14em] text-balance">{{ $cms->text('rooms.title', 'ermita.rooms.title') }}</h2>

            <div class="type-b2 mt-8 max-w-lg space-y-4">
                <p>{{ $cms->text('rooms.lead_1', 'ermita.rooms.lead_1') }}</p>
                <p>{{ $cms->text('rooms.lead_2', 'ermita.rooms.lead_2') }}</p>
            </div>

            <x-ermita.button
                :href="route('cigno-ermita.rooms')"
                class="mt-10 w-full px-8"
            >
                {{ $cms->text('rooms.cta', 'ermita.rooms.cta') }}
            </x-ermita.button>
        </div>

        <div
            class="experiences-carousel rooms-carousel w-full select-none"
            x-data="peekCarousel({{ count($items) }}, { align: 'start' })"
            role="group"
            aria-roledescription="carousel"
            aria-label="{{ $cms->text('rooms.title', 'ermita.rooms.title') }}"
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
                <div x-ref="track" class="experiences-carousel-track items-stretch">
                    @foreach ([0, 1, 2] as $copy)
                        @foreach ($items as $item)
                            <article
                                class="experiences-carousel-slide flex h-full flex-col"
                                @if ($copy !== 1) aria-hidden="true" @endif
                            >
                                <div class="aspect-[3/4] overflow-hidden bg-beige-300">
                                    <img
                                        src="{{ asset($item['image']) }}"
                                        alt="{{ $copy === 1 ? $item['title'] : '' }}"
                                        class="size-full object-cover"
                                        draggable="false"
                                    >
                                </div>

                                <div class="mt-5 flex flex-wrap items-center gap-x-5 gap-y-2">
                                    <span class="type-label inline-flex items-center gap-2.5 text-black-500">
                                        <img
                                            src="{{ asset('images/ermita/Component 1 (7).svg') }}"
                                            alt=""
                                            width="28"
                                            height="28"
                                            class="size-7 shrink-0"
                                        >
                                        {{ $item['people'] === 1
                                            ? __('ermita.rooms.max_people_one')
                                            : __('ermita.rooms.max_people', ['count' => $item['people']]) }}
                                    </span>
                                    <span class="type-label inline-flex items-center gap-2.5 text-black-500">
                                        <img
                                            src="{{ asset('images/ermita/Component 1 (6).svg') }}"
                                            alt=""
                                            width="28"
                                            height="28"
                                            class="size-7 shrink-0"
                                        >
                                        {{ $item['beds'] === 1
                                            ? __('ermita.rooms.beds_one')
                                            : __('ermita.rooms.beds_other', ['count' => $item['beds']]) }}
                                    </span>
                                </div>

                                <h3 class="type-s2 mt-5 line-clamp-2 min-h-[calc(1.2em*2)] text-balance">{{ $item['title'] }}</h3>

                                <p class="type-b3 mt-3 line-clamp-2 min-h-[calc(1.2em*2)] text-pretty">{{ $item['body'] }}</p>

                                <div class="mt-auto pt-6" @click="if (moved) $event.preventDefault()">
                                    <x-ermita.button
                                        :href="route('cigno-ermita.rooms')"
                                        variant="outline"
                                        class="w-full px-6"
                                    >
                                        {{ __('ermita.rooms.see_more') }}
                                    </x-ermita.button>
                                </div>
                            </article>
                        @endforeach
                    @endforeach
                </div>
            </div>

            <div class="mt-10 h-px w-full bg-beige-300" aria-hidden="true">
                <div class="h-px bg-blue-ermita-300 transition-[width] duration-200" :style="`width: ${progress}%`"></div>
            </div>
        </div>
    </div>
</section>
