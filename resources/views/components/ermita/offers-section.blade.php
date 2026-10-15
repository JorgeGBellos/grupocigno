<section id="offers" class="relative isolate overflow-hidden px-6 py-20 lg:px-10 lg:py-28">
    <img
        src="{{ asset('images/ermita/home/offers.png') }}"
        alt=""
        class="absolute inset-0 size-full object-cover"
    >

    <div class="relative z-10 mx-auto flex w-full max-w-xl flex-col items-center rounded-[14px] bg-off-white-100 px-8 py-14 text-center text-black-500 sm:px-12 sm:py-16 lg:px-16">
        <img
            src="{{ asset('images/ermita/icons/Vector (16).svg') }}"
            alt=""
            width="56"
            class="h-auto w-12 lg:w-14"
        >

        <h2 class="type-h1 mt-8">{{ __('ermita.offers_section.title') }}</h2>

        <p class="type-b2 mt-6 max-w-md">
            {{ __('ermita.offers_section.lead') }}
        </p>

        <x-ermita.button :href="route('cigno-ermita.offers')" variant="outline" class="mt-10 w-full max-w-md">
            {{ __('ermita.offers_section.cta') }}
        </x-ermita.button>
    </div>
</section>
