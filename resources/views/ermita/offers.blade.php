@php
    $offers = __('ermita.offers_section.items');
@endphp

<x-layouts.app :title="__('ermita.offers_section.page_title').' — '.__('nav.ermita')">
    <section class="bg-off-white-300 px-6 py-16 text-black-500 lg:px-10 lg:py-24">
        <div class="mx-auto flex w-full max-w-3xl flex-col items-center text-center">
            <img
                src="{{ asset('images/ermita/icons/cisneentero.svg') }}"
                alt=""
                width="274"
                class="h-auto w-[220px] sm:w-[260px]"
            >

            <h1 class="type-h1 mt-10">{{ __('ermita.offers_section.page_title') }}</h1>

            <p class="type-b2 mt-8 max-w-xl">{{ __('ermita.offers_section.lead') }}</p>
        </div>
    </section>

    <section class="bg-off-white-300 px-6 pb-16 text-black-500 lg:px-10 lg:pb-24">
        <div class="mx-auto flex max-w-6xl flex-col gap-16 lg:gap-24">
            @foreach ($offers as $offer)
                <article class="grid grid-cols-1 items-stretch gap-8 lg:grid-cols-[minmax(0,1.45fr)_minmax(0,1fr)] lg:gap-12 xl:gap-16">
                    <div class="min-h-[16rem] overflow-hidden sm:min-h-[20rem] lg:min-h-full">
                        <img
                            src="{{ asset($offer['image']) }}"
                            alt="{{ $offer['title'] }}"
                            class="size-full object-cover"
                        >
                    </div>

                    <div class="flex flex-col justify-center text-left lg:py-2">
                        <h2 class="type-h2 text-balance">{{ $offer['title'] }}</h2>
                        <p class="type-b2 mt-6">{{ $offer['dates'] }}</p>

                        <p class="type-b3 mt-8">{{ __('ermita.offers_section.includes') }}</p>
                        <ul class="type-b3 mt-3 list-disc space-y-1 pl-5">
                            @foreach ($offer['perks'] as $perk)
                                <li>{{ $perk }}</li>
                            @endforeach
                        </ul>

                        <p class="type-label mt-6">{{ __('ermita.offers_section.note') }}</p>

                        <x-ermita.button :href="route('cigno-ermita').'#booking'" class="mt-8 w-full">
                            {{ __('ermita.offers_section.book') }}
                        </x-ermita.button>
                    </div>
                </article>
            @endforeach
        </div>
    </section>
</x-layouts.app>
