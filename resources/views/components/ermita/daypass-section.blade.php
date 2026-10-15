@php
    use App\Enums\CmsPageSlug;

    $cms = cms(CmsPageSlug::Ermita);
@endphp

<section id="daypass" class="bg-off-white-300 px-6 py-20 text-black-500 lg:px-10 lg:py-28">
    <div class="mx-auto grid max-w-6xl grid-cols-1 items-center gap-12 lg:grid-cols-2 lg:gap-16 xl:gap-24">
        <img
            src="{{ $cms->asset('daypass.image', 'images/ermita/home/daypass.png') }}"
            alt="{{ __('ermita.daypass.image_alt') }}"
            class="aspect-[5/4] w-full object-cover"
        >

        <div class="flex max-w-xl flex-col">
            <img
                src="{{ asset('images/ermita/icons/Layer_1 (62).svg') }}"
                alt=""
                width="72"
                class="h-auto w-14 lg:w-[72px]"
            >

            <h2 class="type-h1 mt-8">{{ $cms->text('daypass.title', 'ermita.daypass.title') }}</h2>

            <div class="type-b2 mt-6 space-y-1">
                <p>{{ $cms->text('daypass.schedule_days', 'ermita.daypass.schedule_days') }}</p>
                <p>{{ $cms->text('daypass.schedule_hours', 'ermita.daypass.schedule_hours') }}</p>
                <p class="mt-4">{{ $cms->text('daypass.price', 'ermita.daypass.price') }}</p>
                <p>{{ $cms->text('daypass.includes', 'ermita.daypass.includes') }}</p>
            </div>

            <p class="type-btn-sm no-underline mt-6">{{ $cms->text('daypass.restrictions', 'ermita.daypass.restrictions') }}</p>

            <div class="mt-8 flex w-full max-w-md flex-col gap-4">
                <x-ermita.button href="#booking" class="w-full">
                    {{ $cms->text('daypass.cta_primary', 'ermita.daypass.cta_primary') }}
                </x-ermita.button>

                <x-ermita.button :href="route('cigno-ermita.daypass')" variant="outline" class="w-full">
                    {{ $cms->text('daypass.cta_secondary', 'ermita.daypass.cta_secondary') }}
                </x-ermita.button>
            </div>
        </div>
    </div>
</section>
