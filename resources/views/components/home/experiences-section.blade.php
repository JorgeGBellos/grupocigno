@php
    use App\Enums\CmsPageSlug;

    $cms = cms(CmsPageSlug::Home);
    $items = __('home.experiences.items');
@endphp

<section id="experiences" class="site-section bg-off-white-300 text-black-500">
    <div class="site-shell grid grid-cols-1 items-start gap-[var(--site-gap)] lg:grid-cols-[minmax(0,0.85fr)_minmax(0,1.15fr)] lg:gap-[clamp(2.5rem,5vw,5rem)]">
        <div class="min-w-0 lg:sticky lg:top-[calc(var(--header-height)+2rem)]">
            <img
                src="{{ $cms->asset('experiences.icon', 'images/home/experiences-icon.png') }}"
                alt=""
                width="56"
                height="56"
                class="h-14 w-auto"
            >

            <h2 class="type-h2 mt-8">
                {{ $cms->text('experiences.title', 'home.experiences.title') }}
            </h2>

            <div class="type-b2 mt-6 max-w-[36rem] space-y-4">
                <p>{{ $cms->text('experiences.lead_1', 'home.experiences.lead_1') }}</p>
                <p>{{ $cms->text('experiences.lead_2', 'home.experiences.lead_2') }}</p>
            </div>
        </div>

        <div
            class="experiences-carousel w-full select-none"
            x-data="peekCarousel({{ count($items) }}, { align: 'start' })"
            role="group"
            aria-roledescription="carousel"
            aria-label="{{ $cms->text('experiences.title', 'home.experiences.title') }}"
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
                <div x-ref="track" class="experiences-carousel-track">
                    @foreach ([0, 1, 2] as $copy)
                        @foreach ($items as $item)
                            <article
                                class="experiences-carousel-slide flex flex-col"
                                @if ($copy !== 1) aria-hidden="true" @endif
                            >
                                <div class="relative aspect-[650/600] overflow-hidden bg-beige-300">
                                    <img
                                        src="{{ asset($item['image']) }}"
                                        alt="{{ $copy === 1 ? $item['title'] : '' }}"
                                        class="absolute inset-0 size-full object-cover"
                                        draggable="false"
                                        @if ($copy !== 1) aria-hidden="true" @endif
                                    >
                                </div>

                                @if (! empty($item['label']))
                                    <p class="type-label mt-6 font-sans text-black-300">{{ $item['label'] }}</p>
                                @endif

                                <h3 class="type-s2 mt-3 text-balance">{{ $item['title'] }}</h3>

                                <p class="type-b3 mt-3 text-pretty text-black-500">{{ $item['body'] }}</p>
                            </article>
                        @endforeach
                    @endforeach
                </div>
            </div>

            <div class="mt-10 h-px w-full bg-beige-300" aria-hidden="true">
                <div class="h-px bg-yellow-gold-500 transition-[width] duration-200" :style="`width: ${progress}%`"></div>
            </div>
        </div>
    </div>
</section>
