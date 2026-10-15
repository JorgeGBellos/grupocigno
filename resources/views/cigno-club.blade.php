@php
    use App\Enums\CmsPageSlug;

    $cms = cms(CmsPageSlug::Club);
    $signUpUrl = $cms->text('sign_up_url') ?: config('club.sign_up_url');
    $signInUrl = $cms->text('sign_in_url') ?: config('club.sign_in_url');
@endphp

<x-layouts.app :title="__('nav.club').' — '.config('app.name')">
    <section class="flex flex-1 flex-col bg-off-white-300 px-6 py-16 text-black-500 lg:px-10 lg:py-24">
        <div class="mx-auto flex w-full max-w-3xl flex-col items-center text-center">
            <img
                src="{{ $cms->asset('logo', 'images/club/Guia.svg') }}"
                alt=""
                width="120"
                class="h-auto w-[120px]"
            >

            <h1 class="type-h1 mt-8 lg:mt-10">{{ __('nav.club') }}</h1>
            <p class="type-b2 mt-4 max-w-xl lg:mt-6">{{ $cms->text('lead', 'club.lead') }}</p>

            <div class="mt-8 flex w-full max-w-md flex-col items-center lg:mt-10">
                <p class="type-b3">{{ $cms->text('prompt', 'club.prompt') }}</p>

                <x-home.outline-button
                    :href="$signUpUrl"
                    class="mt-8 w-full lg:mt-10"
                    target="_blank"
                    rel="noopener noreferrer"
                >
                    {{ __('club.sign_up') }}
                </x-home.outline-button>

                <x-home.outline-button
                    :href="$signInUrl"
                    class="mt-4 w-full"
                    target="_blank"
                    rel="noopener noreferrer"
                >
                    {{ __('club.sign_in') }}
                </x-home.outline-button>
            </div>
        </div>
    </section>
</x-layouts.app>
