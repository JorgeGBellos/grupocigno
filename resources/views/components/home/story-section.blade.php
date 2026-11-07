@php
    use App\Enums\CmsPageSlug;

    $cms = cms(CmsPageSlug::Home);
@endphp

<section class="site-section bg-off-white-500 text-black-500">
    <h2 class="sr-only">{{ $cms->text('story.title', 'home.story.title') }}</h2>

    <div class="site-shell grid grid-cols-1 items-start gap-[clamp(2.5rem,4vw,5rem)] lg:grid-cols-[minmax(0,9fr)_minmax(0,4fr)] lg:gap-[clamp(3rem,6vw,8rem)]">
        {{-- Left: landscape ~900, lower --}}
        <figure class="min-w-0 lg:mt-[clamp(3rem,6vw,9rem)]">
            <div class="aspect-[900/700] overflow-hidden">
                <img
                    src="{{ $cms->asset('story.image_1', 'images/mejorada/home/story-2.png') }}"
                    alt=""
                    class="size-full object-cover"
                >
            </div>

            <figcaption class="type-b2 mt-6 max-w-[36rem] text-pretty lg:mt-8">
                {{ $cms->text('story.lead_2', 'home.story.lead_2') }}
            </figcaption>
        </figure>

        {{-- Right: portrait ~400 proportional, higher --}}
        <figure class="max-w-md min-w-0 justify-self-center lg:max-w-none lg:justify-self-stretch">
            <div class="aspect-[400/515] overflow-hidden">
                <img
                    src="{{ $cms->asset('story.image_2', 'images/home/seccion1.2.png') }}"
                    alt=""
                    class="size-full object-cover"
                >
            </div>

            <figcaption class="type-b2 mt-6 max-w-sm text-pretty lg:mt-8">
                {{ $cms->text('story.lead_1', 'home.story.lead_1') }}
            </figcaption>
        </figure>
    </div>
</section>
