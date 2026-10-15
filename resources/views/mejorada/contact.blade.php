@php
    use App\Enums\CmsPageSlug;
    $cms = cms(CmsPageSlug::MejoradaContact);
@endphp

<x-layouts.app :title="__('nav.mejorada_contact').' — '.__('nav.mejorada')">
    <section class="flex flex-1 flex-col bg-off-white-300 px-6 py-16 text-black-500 lg:px-10 lg:py-24">
        <div class="mx-auto flex w-full max-w-3xl flex-col items-center text-center">
            <img
                src="{{ $cms->asset('contact.logo', 'images/ermita/icons/cisneentero.svg') }}"
                alt=""
                width="120"
                class="h-auto w-[96px] sm:w-[120px]"
            >

            <h1 class="type-h1 mt-10">{{ __('nav.mejorada_contact') }}</h1>

            <div class="type-b2 mt-6 w-full space-y-4">
                <p>{{ $cms->text('contact.lead_1', 'mejorada.contact.lead_1') }}</p>
                <p>{{ $cms->text('contact.lead_2', 'mejorada.contact.lead_2') }}</p>
            </div>

            <x-contact.form accent="mejorada" source="mejorada" />
        </div>
    </section>
</x-layouts.app>
