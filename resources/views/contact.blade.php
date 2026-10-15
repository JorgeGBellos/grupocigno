@php
    use App\Enums\CmsPageSlug;

    $cms = cms(CmsPageSlug::Contact);
@endphp

<x-layouts.app :title="__('nav.contact').' — '.config('app.name')">
    <section class="flex flex-1 flex-col bg-off-white-300 px-6 py-16 text-black-500 lg:px-10 lg:py-24">
        <div class="mx-auto flex w-full max-w-3xl flex-col items-center text-center">
            <img
                src="{{ $cms->asset('logo', 'images/footer/Swan.svg') }}"
                alt=""
                width="120"
                class="hidden h-auto w-[120px] lg:block"
            >

            <h1 class="type-h1 lg:mt-10">{{ __('nav.contact') }}</h1>

            <div class="type-b2 mt-6 w-full space-y-4">
                <p>{{ $cms->text('lead_1', 'contact.lead_1') }}</p>
                <p>{{ $cms->text('lead_2', 'contact.lead_2') }}</p>
            </div>

            <x-contact.form />
        </div>
    </section>
</x-layouts.app>
