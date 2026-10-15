<section class="bg-beige-500 px-6 py-20 text-black-500 lg:px-10 lg:py-28" aria-labelledby="ermita-celebrate-title">
    <div class="mx-auto grid max-w-6xl grid-cols-1 items-center gap-12 lg:grid-cols-2 lg:gap-16 xl:gap-24">
        <div class="flex max-w-xl flex-col">
            <img
                src="{{ asset('images/ermita/icons/Vector (16).svg') }}"
                alt=""
                width="72"
                class="h-auto w-14 lg:w-[72px]"
            >

            <h2 id="ermita-celebrate-title" class="type-h1 mt-8 text-balance">
                {{ __('ermita.celebrate.title') }}
            </h2>

            <p class="type-b2 mt-6 max-w-md">
                {{ __('ermita.celebrate.lead') }}
            </p>

            <x-ermita.button :href="route('cigno-ermita.venue')" class="mt-10 w-full max-w-md">
                {{ __('ermita.celebrate.cta') }}
            </x-ermita.button>
        </div>

        <img
            src="{{ asset('images/ermita/home/barrio2.png') }}"
            alt="{{ __('ermita.celebrate.image_alt') }}"
            class="aspect-[5/4] w-full object-cover"
        >
    </div>
</section>
