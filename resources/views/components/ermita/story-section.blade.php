@php
    use App\Enums\CmsPageSlug;

    $cms = cms(CmsPageSlug::Ermita);
    $gallery = $cms->gallery('story.gallery', [
        'images/ermita/home/banner.png',
        'images/ermita/home/Galería.png',
        'images/home/Rectangle 2 (5).png',
    ]);
@endphp

<section class="bg-off-white-500 px-6 py-20 text-black-500 lg:px-10 lg:py-28">
    <h2 class="sr-only">{{ $cms->text('story.title', 'ermita.story.title') }}</h2>

    <div class="mx-auto grid max-w-6xl grid-cols-1 items-start gap-14 lg:grid-cols-[minmax(0,9fr)_minmax(0,4fr)] lg:gap-24 xl:gap-32">
        <figure class="lg:mt-28 xl:mt-36">
            <div class="aspect-[900/700] overflow-hidden">
                <img
                    src="{{ asset($gallery[0] ?? 'images/ermita/home/banner.png') }}"
                    alt="{{ __('ermita.story.image_alt') }}"
                    class="size-full object-cover"
                >
            </div>

            <figcaption class="type-b2 mt-6 max-w-xl space-y-4 text-pretty lg:mt-8">
                <p>{{ $cms->text('story.lead_1', 'ermita.story.lead_1') }}</p>
                <p>{{ $cms->text('story.lead_2', 'ermita.story.lead_2') }}</p>
            </figcaption>
        </figure>

        <figure class="max-w-md justify-self-center lg:max-w-none lg:justify-self-stretch">
            <div class="aspect-[400/515] overflow-hidden">
                <img
                    src="{{ asset($gallery[1] ?? 'images/ermita/home/Galería.png') }}"
                    alt=""
                    class="size-full object-cover"
                >
            </div>

            <figcaption class="type-b2 mt-6 max-w-sm text-pretty lg:mt-8">
                {{ $cms->text('hero.line_1', 'ermita.hero.line_1') }} {{ $cms->text('hero.line_2', 'ermita.hero.line_2') }}
            </figcaption>

            <div class="mt-8 flex max-w-sm flex-col gap-4">
                <x-ermita.button href="#booking" class="w-full">
                    {{ __('ermita.story.book') }}
                </x-ermita.button>

                <x-ermita.button :href="route('cigno-ermita.rooms')" variant="outline" class="w-full">
                    {{ __('ermita.story.discover') }}
                </x-ermita.button>
            </div>
        </figure>
    </div>

    <img
        src="{{ asset('images/ermita/michelin-2025-black.png') }}"
        alt="{{ __('nav.michelin_2025') }}"
        class="mx-auto mt-16 h-5 w-auto lg:mt-20"
    >
</section>
