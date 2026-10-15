<x-layouts.app :title="__('contact.thank_you.title').' — '.__('nav.ermita')">
    <section class="flex flex-1 flex-col bg-off-white-300 px-6 py-16 text-black-500 lg:px-10 lg:py-24">
        <div class="mx-auto flex w-full max-w-3xl flex-col items-center text-center">
            <img
                src="{{ asset('images/footer/Swan.svg') }}"
                alt=""
                width="120"
                class="h-auto w-[120px]"
            >

            <h1 class="type-h1 mt-10">{{ __('contact.thank_you.title') }}</h1>

            <div class="type-b2 mt-6 max-w-xl space-y-4">
                <p>{{ __('ermita.contact.thank_you_lead_1') }}</p>
                <p>{{ __('ermita.contact.thank_you_lead_2') }}</p>
            </div>

            <x-ermita.button
                :href="route('cigno-ermita')"
                class="mt-12 w-full max-w-md"
            >
                {{ __('ermita.contact.back_home') }}
            </x-ermita.button>
        </div>
    </section>
</x-layouts.app>
