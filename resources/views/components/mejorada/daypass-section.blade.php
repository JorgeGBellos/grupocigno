@php
    $cms = cms('cigno-mejorada');
@endphp

<section id="daypass" class="bg-green-mejorada-500 px-6 py-20 text-white lg:px-10 lg:py-28">
    <div class="mx-auto grid max-w-6xl grid-cols-1 items-center gap-12 lg:grid-cols-2 lg:gap-16 xl:gap-24">
        <img
            src="{{ $cms->asset('daypass.image', 'images/mejorada/daypass-hat.jpg') }}"
            alt="{{ $cms->text('daypass.title', 'mejorada.daypass.title') }}"
            class="aspect-[5/4] w-full object-cover"
            loading="lazy"
        >

        <div class="flex max-w-xl flex-col">
            <img
                src="{{ asset('images/ermita/icons/Layer_1 (62).svg') }}"
                alt=""
                width="120"
                class="h-auto w-20 object-contain brightness-0 invert lg:w-[120px]"
                aria-hidden="true"
            >

            <h2 class="type-h1 mt-8 text-white">{{ $cms->text('daypass.title', 'mejorada.daypass.title') }}</h2>

            <div class="type-b2 mt-6 space-y-1 text-white">
                <p>{{ $cms->text('daypass.schedule_days', 'mejorada.daypass.schedule_days') }}</p>
                <p>{{ $cms->text('daypass.schedule_hours', 'mejorada.daypass.schedule_hours') }}</p>
                <p class="mt-4">{{ $cms->text('daypass.price', 'mejorada.daypass.price') }}</p>
                <p>{{ $cms->text('daypass.includes', 'mejorada.daypass.includes') }}</p>
            </div>

            <p class="type-btn-sm no-underline mt-6 text-white">{{ $cms->text('daypass.restrictions', 'mejorada.daypass.restrictions') }}</p>

            <div class="mt-8 flex w-full max-w-md flex-col gap-4">
                <x-mejorada.button :href="route('cigno-mejorada.daypass')" variant="white-solid" class="w-full">
                    {{ $cms->text('daypass.cta_primary', 'mejorada.daypass.cta_primary') }}
                </x-mejorada.button>

                <x-mejorada.button :href="route('cigno-mejorada.rooms')" variant="white" class="w-full">
                    {{ $cms->text('daypass.cta_secondary', 'mejorada.daypass.cta_secondary') }}
                </x-mejorada.button>
            </div>
        </div>
    </div>
</section>
