@php
    use App\Enums\CmsPageSlug;

    $cms = cms(CmsPageSlug::ErmitaVenue);
    $spaces = __('ermita.venue.spaces');
@endphp

<x-layouts.app :title="$cms->text('venue.title', 'ermita.venue.title').' — '.__('nav.ermita')">
    <section class="bg-off-white-300 px-6 py-16 text-black-500 lg:px-10 lg:py-24">
        <div class="mx-auto flex w-full max-w-3xl flex-col items-center text-center">
            <img
                src="{{ asset('images/ermita/icons/tortugaentera.svg') }}"
                alt=""
                width="280"
                class="h-auto w-[220px] sm:w-[260px]"
            >

            <h1 class="type-h1 mt-10 max-w-xl text-balance">{{ $cms->text('venue.title', 'ermita.venue.title') }}</h1>

            <div class="type-b2 mt-8 max-w-xl space-y-1">
                <p>{{ $cms->text('venue.lead', 'ermita.venue.lead') }}</p>
                <p>{{ $cms->text('venue.intro', 'ermita.venue.intro') }}</p>
            </div>
        </div>
    </section>

    <section class="bg-off-white-300 px-6 pb-16 text-black-500 lg:px-10 lg:pb-24">
        <div class="mx-auto grid max-w-6xl grid-cols-1 gap-10 sm:grid-cols-2 lg:grid-cols-3 lg:gap-8">
            @foreach ($spaces as $space)
                <article>
                    <img
                        src="{{ asset($space['image']) }}"
                        alt="{{ $space['title'] }}"
                        class="aspect-[3/4] w-full object-cover"
                    >
                    <h2 class="type-s2 mt-6">{{ $space['title'] }}</h2>
                    <p class="type-b3 mt-3">{{ $space['body'] }}</p>
                </article>
            @endforeach
        </div>
    </section>

    <section class="bg-beige-100 px-6 py-16 text-black-500 lg:px-10 lg:py-24">
        <div class="mx-auto grid max-w-6xl grid-cols-1 items-center gap-12 lg:grid-cols-2 lg:gap-16 xl:gap-24">
            <div class="flex max-w-xl flex-col">
                <img
                    src="{{ asset('images/ermita/icons/Vector (16).svg') }}"
                    alt=""
                    width="56"
                    class="h-auto w-12 lg:w-14"
                >

                <div class="type-b2 mt-8 space-y-6">
                    <p>{{ __('ermita.venue.story_1') }}</p>
                    <p>{{ __('ermita.venue.story_2') }}</p>
                </div>

                <x-ermita.button href="#venue-inquiry" class="mt-10 w-full max-w-xs">
                    {{ __('ermita.venue.story_cta') }}
                </x-ermita.button>
            </div>

            <img
                src="{{ asset(__('ermita.venue.story_image')) }}"
                alt=""
                class="aspect-[4/5] w-full object-cover"
            >
        </div>
    </section>

    <section id="venue-inquiry" class="bg-off-white-300 px-6 py-16 text-black-500 lg:px-10 lg:py-24">
        <div class="mx-auto flex w-full max-w-3xl flex-col items-center text-center">
            <p class="type-b2 max-w-2xl">{{ $cms->text('venue.form_lead', 'ermita.venue.form_lead') }}</p>

            <x-ermita.venue-form />
        </div>
    </section>
</x-layouts.app>
