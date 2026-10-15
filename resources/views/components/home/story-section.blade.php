@php
    use App\Enums\CmsPageSlug;

    $cms = cms(CmsPageSlug::Home);
@endphp

<section class="bg-off-white-500 px-6 py-20 text-black-500 lg:px-10 lg:py-28">
    <h2 class="sr-only">{{ $cms->text('story.title', 'home.story.title') }}</h2>

    <div class="mx-auto grid max-w-6xl grid-cols-1 items-start gap-14 lg:grid-cols-[minmax(0,9fr)_minmax(0,4fr)] lg:gap-24 xl:gap-32">
        {{-- Left: landscape ~900, lower --}}
        <figure class="lg:mt-28 xl:mt-36">
            <div class="aspect-[900/700] overflow-hidden">
                <img
                    src="{{ $cms->asset('story.image_1', 'images/home/seccion1.png') }}"
                    alt=""
                    class="size-full object-cover"
                >
            </div>

            <figcaption class="type-b2 mt-6 max-w-xl text-pretty lg:mt-8">
                {{ $cms->text('story.lead_2', 'home.story.lead_2') }}
            </figcaption>
        </figure>

        {{-- Right: portrait ~400 proportional, higher --}}
        <figure class="max-w-md justify-self-center lg:max-w-none lg:justify-self-stretch">
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
