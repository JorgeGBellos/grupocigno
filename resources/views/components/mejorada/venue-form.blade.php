<form
    class="mt-12 w-full text-left lg:mt-16"
    action="{{ route('cigno-mejorada.venue.store') }}"
    method="post"
    aria-label="{{ __('mejorada.venue.form_aria') }}"
>
    @csrf
    <input type="hidden" name="hotel" value="cigno-mejorada">

    @if ($errors->any())
        <div class="type-b3 mb-8 rounded-[24px] border border-blue-mejorada-300 bg-off-white-100 px-5 py-4 text-blue-mejorada-300" role="alert">
            <ul class="space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 gap-x-8 gap-y-6 md:grid-cols-2">
        <x-club.field name="venue_first_name" :label="__('mejorada.venue.first_name')" label-class="type-b2 text-black-500">
            <input
                id="club-venue_first_name"
                class="contact-input"
                type="text"
                name="first_name"
                value="{{ old('first_name') }}"
                placeholder="{{ __('mejorada.venue.placeholder_first_name') }}"
                autocomplete="given-name"
                required
            >
        </x-club.field>

        <x-club.field name="venue_last_name" :label="__('mejorada.venue.last_name')" label-class="type-b2 text-black-500">
            <input
                id="club-venue_last_name"
                class="contact-input"
                type="text"
                name="last_name"
                value="{{ old('last_name') }}"
                placeholder="{{ __('mejorada.venue.placeholder_last_name') }}"
                autocomplete="family-name"
                required
            >
        </x-club.field>

        <x-club.field name="venue_email" :label="__('mejorada.venue.email')" label-class="type-b2 text-black-500">
            <input
                id="club-venue_email"
                class="contact-input"
                type="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="{{ __('mejorada.venue.placeholder_email') }}"
                autocomplete="email"
                required
            >
        </x-club.field>

        <x-club.field name="venue_event_date" :label="__('mejorada.venue.event_date')" label-class="type-b2 text-black-500">
            <input
                id="club-venue_event_date"
                class="contact-input"
                type="date"
                name="event_date"
                value="{{ old('event_date') }}"
                min="{{ now()->toDateString() }}"
                required
            >
        </x-club.field>

        <x-club.field name="venue_event_type" :label="__('mejorada.venue.event_type')" class="md:col-span-2" label-class="type-b2 text-black-500">
            <select
                id="club-venue_event_type"
                class="contact-input"
                name="event_type"
                required
            >
                @foreach (__('mejorada.venue.event_types') as $value => $label)
                    <option value="{{ $value }}" @selected(old('event_type', 'wedding') === $value)>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </x-club.field>

        <x-club.field
            name="venue_additional_information"
            :label="__('mejorada.venue.additional_information')"
            :required="false"
            class="md:col-span-2"
            label-class="type-b2 text-black-500"
        >
            <textarea
                id="club-venue_additional_information"
                class="contact-input"
                name="additional_information"
                placeholder="{{ __('mejorada.venue.placeholder_additional') }}"
            >{{ old('additional_information') }}</textarea>
        </x-club.field>
    </div>

    <div class="mt-12">
        <button
            type="submit"
            class="type-btn-md no-underline w-full rounded-[16px] bg-green-mejorada-500 py-3.5 uppercase text-white transition-colors duration-300 hover:bg-green-mejorada-300"
        >
            {{ __('mejorada.venue.submit') }}
        </button>
    </div>
</form>
