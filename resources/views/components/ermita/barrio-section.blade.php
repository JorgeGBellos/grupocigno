<section class="bg-beige-500 px-6 py-20 text-black-500 lg:px-10 lg:py-28" aria-labelledby="ermita-barrio-title">
    <div class="mx-auto grid max-w-6xl grid-cols-1 items-center gap-12 lg:grid-cols-2 lg:gap-16 xl:gap-24">
        <img
            src="{{ asset('images/ermita/home/barrio.png') }}"
            alt="{{ __('ermita.barrio.image_alt') }}"
            class="aspect-square w-full object-cover"
        >

        <div class="flex max-w-xl flex-col">
            <img
                src="{{ asset('images/ermita/icons/Vector (16).svg') }}"
                alt=""
                width="72"
                class="h-auto w-14 lg:w-[72px]"
            >

            <h2 id="ermita-barrio-title" class="type-h1 mt-8">
                {{ __('ermita.barrio.title') }}
            </h2>

            <div class="type-b2 mt-6 space-y-4">
                <p>{{ __('ermita.barrio.lead_1') }}</p>
                <p>{{ __('ermita.barrio.lead_2') }}</p>
            </div>

            <x-ermita.button :href="route('cigno-ermita.barrio')" class="mt-10 w-full max-w-md">
                {{ __('ermita.barrio.cta') }}
            </x-ermita.button>
        </div>
    </div>
</section>
