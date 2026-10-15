@php
    use App\Enums\CmsPageSlug;

    $cms = cms(CmsPageSlug::ErmitaContact);
@endphp

<x-layouts.app :title="__('nav.ermita_contact').' — '.__('nav.ermita')">
    <section class="flex flex-1 flex-col bg-off-white-300 px-6 py-16 text-black-500 lg:px-10 lg:py-24">
        <div class="mx-auto flex w-full max-w-3xl flex-col items-center text-center">
            <img
                src="{{ $cms->asset('contact.logo', 'images/ermita/icons/cisneentero.svg') }}"
                alt=""
                width="274"
                class="h-auto w-[220px] sm:w-[260px]"
            >

            <h1 class="type-h1 mt-10">{{ __('nav.ermita_contact') }}</h1>

            <div class="type-b2 mt-6 w-full space-y-4">
                <p>{{ $cms->text('contact.lead_1', 'ermita.contact.lead_1') }}</p>
                <p>{{ $cms->text('contact.lead_2', 'ermita.contact.lead_2') }}</p>
            </div>

            <x-contact.form accent="ermita" source="ermita" />
        </div>
    </section>
</x-layouts.app>
