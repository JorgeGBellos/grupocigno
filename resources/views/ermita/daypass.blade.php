@php
    use App\Enums\CmsPageSlug;

    $cms = cms(CmsPageSlug::ErmitaDaypass);
    $gallery = $cms->gallery('daypass.gallery', __('ermita.daypass.gallery'));
@endphp

<x-layouts.app :title="$cms->text('daypass.page_title', 'ermita.daypass.page_title').' — '.__('nav.ermita')">
    <section class="flex flex-1 flex-col bg-off-white-300 px-6 py-16 text-black-500 lg:px-10 lg:py-24">
        <div class="mx-auto flex w-full max-w-4xl flex-col items-center text-center">
            <img
                src="{{ $cms->asset('daypass.mark', 'images/ermita/icons/tortugaentera.svg') }}"
                alt=""
                width="280"
                class="h-auto w-[220px] sm:w-[260px]"
            >

            <h1 class="type-h1 mt-8">{{ $cms->text('daypass.page_title', 'ermita.daypass.page_title') }}</h1>

            <div class="type-b2 mt-8 max-w-md space-y-1">
                <p>{{ $cms->text('daypass.schedule_days', 'ermita.daypass.schedule_days') }}</p>
                <p>{{ $cms->text('daypass.schedule_hours', 'ermita.daypass.schedule_hours') }}</p>
                <p class="mt-4">{{ $cms->text('daypass.price', 'ermita.daypass.price') }}</p>
                <p>{{ $cms->text('daypass.includes', 'ermita.daypass.includes') }}</p>
                <p>{{ $cms->text('daypass.restrictions', 'ermita.daypass.restrictions') }}</p>
            </div>

            <x-ermita.button
                :href="route('cigno-ermita').'#booking'"
                class="mt-10 w-full max-w-md px-8"
            >
                {{ $cms->text('daypass.page_cta', 'ermita.daypass.page_cta') }}
            </x-ermita.button>
        </div>

        <div class="mx-auto mt-16 w-full max-w-5xl lg:mt-20">
            <x-home.peek-carousel
                :images="$gallery"
                :alt="$cms->text('daypass.page_title', 'ermita.daypass.image_alt')"
                bar-class="bg-blue-ermita-300"
            />
        </div>
    </section>

    <x-ermita.amenities-section
        banner
        :title="$cms->text('daypass.amenities.title', 'ermita.daypass.amenities.title')"
        :lead="$cms->text('daypass.amenities.lead', 'ermita.daypass.amenities.lead')"
        :items="__('ermita.daypass.amenities.items')"
    />
</x-layouts.app>
