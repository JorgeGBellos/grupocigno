@props([
    'accent' => 'gold',
    'source' => 'grupo',
])

@php
    $errorClass = match ($accent) {
        'ermita' => 'border-blue-ermita-300 text-blue-ermita-300',
        'mejorada' => 'border-blue-mejorada-300 text-blue-mejorada-300',
        default => 'border-yellow-gold-500 text-yellow-gold-500',
    };
    $submitClass = match ($accent) {
        'ermita' => 'border border-blue-ermita-300 bg-blue-ermita-300 hover:border-blue-ermita-500 hover:bg-blue-ermita-500',
        'mejorada' => 'border border-blue-mejorada-300 bg-blue-mejorada-300 hover:border-blue-mejorada-500 hover:bg-blue-mejorada-500',
        default => 'border border-yellow-gold-300 bg-yellow-gold-300 hover:border-yellow-gold-500 hover:bg-yellow-gold-500',
    };
@endphp

<form
    class="mt-16 w-full text-left lg:mt-20"
    action="{{ route('contact.store') }}"
    method="post"
    aria-label="{{ __('contact.aria') }}"
>
    @csrf
    <input type="hidden" name="source" value="{{ $source }}">

    @if ($errors->any())
        <div class="type-b3 mb-8 rounded-[24px] border bg-off-white-100 px-5 py-4 {{ $errorClass }}" role="alert">
            <ul class="space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 gap-x-8 gap-y-6 md:grid-cols-2">
        <x-club.field name="contact_name" :label="__('contact.name')" label-class="type-b2 text-black-500">
            <input
                id="club-contact_name"
                class="contact-input"
                type="text"
                name="name"
                value="{{ old('name') }}"
                placeholder="{{ __('contact.placeholder_name') }}"
                autocomplete="name"
                required
            >
        </x-club.field>

        <x-club.field name="contact_email" :label="__('contact.email')" label-class="type-b2 text-black-500">
            <input
                id="club-contact_email"
                class="contact-input"
                type="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="{{ __('contact.placeholder_email') }}"
                autocomplete="email"
                required
            >
        </x-club.field>

        <x-club.field name="contact_phone" :label="__('contact.phone')" label-class="type-b2 text-black-500">
            <input
                id="club-contact_phone"
                class="contact-input"
                type="tel"
                name="phone"
                value="{{ old('phone') }}"
                placeholder="{{ __('contact.placeholder_phone') }}"
                autocomplete="tel"
                required
            >
        </x-club.field>

        <x-club.field name="contact_subject" :label="__('contact.subject')" label-class="type-b2 text-black-500">
            <input
                id="club-contact_subject"
                class="contact-input"
                type="text"
                name="subject"
                value="{{ old('subject') }}"
                placeholder="{{ __('contact.placeholder_subject') }}"
                required
            >
        </x-club.field>

        <x-club.field name="contact_message" :label="__('contact.message')" class="md:col-span-2" label-class="type-b2 text-black-500">
            <textarea
                id="club-contact_message"
                class="contact-input"
                name="message"
                placeholder="{{ __('contact.placeholder_message') }}"
                required
            >{{ old('message') }}</textarea>
        </x-club.field>
    </div>

    <div class="mt-12">
        <button
            type="submit"
            class="type-btn-md no-underline w-full rounded-[14px] {{ $submitClass }} py-3.5 uppercase text-off-white-100 transition-colors duration-300"
        >
            {{ __('contact.submit') }}
        </button>
    </div>
</form>
