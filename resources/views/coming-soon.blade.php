@props([
    'hotel' => 'nav.ermita',
])

<x-layouts.app :title="__($hotel).' — '.config('app.name')">
    <section class="flex flex-1 flex-col bg-off-white-300 px-6 py-16 text-black-500 lg:px-10 lg:py-24">
        <div class="mx-auto flex w-full max-w-3xl flex-col items-center text-center">
            <img
                src="{{ asset('images/footer/Swan.svg') }}"
                alt=""
                width="120"
                class="h-auto w-[120px]"
            >

            <p class="type-label mt-10 uppercase text-yellow-gold-500">{{ __('pages.coming_soon.eyebrow') }}</p>

            <h1 class="type-h1 mt-4">{{ __($hotel) }}</h1>

            <div class="type-b2 mt-6 max-w-xl space-y-4">
                <p>{{ __('pages.coming_soon.lead_1') }}</p>
                <p>{{ __('pages.coming_soon.lead_2') }}</p>
            </div>

            <div class="mt-12 flex w-full max-w-md flex-col gap-4 sm:flex-row sm:justify-center">
                <x-home.outline-button
                    :href="route('home')"
                    class="w-full sm:w-auto"
                >
                    {{ __('pages.coming_soon.back_home') }}
                </x-home.outline-button>

                <x-home.outline-button
                    :href="route('home').'#booking'"
                    variant="solid"
                    class="w-full sm:w-auto"
                >
                    {{ __('pages.coming_soon.book') }}
                </x-home.outline-button>
            </div>
        </div>
    </section>
</x-layouts.app>
