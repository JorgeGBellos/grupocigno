@php
    use App\Enums\CmsPageSlug;

    $cms = cms(CmsPageSlug::Mejorada);
    $gallery = $cms->gallery('story.gallery', [
        'images/mejorada/home/story-2.png',
        'images/mejorada/home/story-1.png',
    ]);
@endphp

<section class="bg-off-white-500 px-6 py-20 text-black-500 lg:px-10 lg:py-28">
    <h2 class="sr-only">{{ $cms->text('story.title', 'mejorada.story.title') }}</h2>

    <div class="mx-auto grid max-w-6xl grid-cols-1 items-start gap-14 lg:grid-cols-[minmax(0,9fr)_minmax(0,4fr)] lg:gap-24 xl:gap-32">
        <figure class="lg:mt-28 xl:mt-36">
            <div class="aspect-[900/700] overflow-hidden">
                <img
                    src="{{ asset($gallery[0] ?? 'images/mejorada/home/story-2.png') }}"
                    alt="{{ __('mejorada.story.image_alt') }}"
                    class="size-full object-cover"
                >
            </div>

            <figcaption class="type-b2 mt-6 max-w-xl space-y-4 text-pretty lg:mt-8">
                <p>{{ $cms->text('story.lead_1', 'mejorada.story.lead_1') }}</p>
                <p>{{ $cms->text('story.lead_2', 'mejorada.story.lead_2') }}</p>
            </figcaption>
        </figure>

        <figure class="max-w-md justify-self-center lg:max-w-none lg:justify-self-stretch">
            <div class="aspect-[400/515] overflow-hidden">
                <img
                    src="{{ asset($gallery[1] ?? 'images/mejorada/home/story-1.png') }}"
                    alt=""
                    class="size-full object-cover"
                >
            </div>

            <figcaption class="type-b2 mt-6 max-w-sm text-pretty lg:mt-8">
                {{ $cms->text('hero.line_1', 'mejorada.hero.line_1') }} {{ $cms->text('hero.line_2', 'mejorada.hero.line_2') }}
            </figcaption>

            <div class="mt-8 flex max-w-sm flex-col gap-4">
                <x-mejorada.button
                    :href="route('booking.search', ['hotel' => 'cigno-mejorada'])"
                    class="w-full"
                >
                    {{ $cms->text('story.book_btn', 'mejorada.story.book_btn') }}
                </x-mejorada.button>

                <x-mejorada.button
                    :href="route('cigno-mejorada.story')"
                    variant="outline"
                    class="w-full"
                >
                    {{ $cms->text('story.discover_btn', 'mejorada.story.discover_btn') }}
                </x-mejorada.button>
            </div>
        </figure>
    </div>
</section>
