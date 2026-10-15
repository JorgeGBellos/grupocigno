@props([
    'lockedHotel' => null,
    'accent' => 'gold',
])

@php
    $isHotelLocked = filled($lockedHotel);
    $bookingHotels = $isHotelLocked
        ? [[
            'value' => $lockedHotel,
            'label' => match ($lockedHotel) {
                'cigno-ermita' => __('nav.ermita'),
                'cigno-mejorada' => __('nav.mejorada'),
                default => $lockedHotel,
            },
        ]]
        : [
            ['value' => 'cigno-mejorada', 'label' => __('nav.mejorada')],
            ['value' => 'cigno-ermita', 'label' => __('nav.ermita')],
        ];
    $accentSolid = match ($accent) {
        'ermita' => 'border border-blue-ermita-300 bg-blue-ermita-300 hover:border-blue-ermita-500 hover:bg-blue-ermita-500',
        'mejorada' => 'border border-blue-mejorada-300 bg-blue-mejorada-300 hover:border-blue-mejorada-500 hover:bg-blue-mejorada-500',
        default => 'border border-yellow-gold-300 bg-yellow-gold-300 hover:border-yellow-gold-500 hover:bg-yellow-gold-500',
    };
    $accentBorder = match ($accent) {
        'ermita' => 'border-blue-ermita-300 text-blue-ermita-300',
        'mejorada' => 'border-blue-mejorada-300 text-blue-mejorada-300',
        default => 'border-yellow-gold-500 text-yellow-gold-500',
    };
    $accentOutline = match ($accent) {
        'ermita' => 'border-blue-ermita-300 bg-white text-blue-ermita-300 hover:bg-beige-100',
        'mejorada' => 'border-blue-mejorada-300 bg-white text-blue-mejorada-300 hover:bg-beige-100',
        default => 'border-yellow-gold-500 bg-white text-yellow-gold-500 hover:bg-beige-100',
    };
@endphp

<form
    class="relative mx-auto w-full max-w-[900px] bg-off-white-100 text-black-500"
    :class="{
        'rounded-[24px] lg:rounded-none lg:bg-transparent': panel,
        'rounded-full lg:rounded-[24px]': ! panel,
        'max-lg:fixed max-lg:inset-x-0 max-lg:bottom-0 max-lg:z-50 max-lg:mx-0 max-lg:max-h-[calc(100dvh-var(--header-height))] max-lg:overflow-y-auto max-lg:px-6 max-lg:pb-8': panel,
    }"
    action="{{ route('booking.search') }}"
    method="get"
    aria-label="{{ __('home.booking.aria') }}"
    x-data="bookingBar({
        locale: {{ \Illuminate\Support\Js::from(str_replace('_', '-', app()->getLocale())) }},
        labels: {{ \Illuminate\Support\Js::from([
            'people_one' => __('home.booking.people_one'),
            'people_other' => __('home.booking.people_other'),
            'rooms_one' => __('home.booking.rooms_one'),
            'rooms_other' => __('home.booking.rooms_other'),
            'room_number' => __('home.booking.room_number'),
            'validation' => __('home.booking.validation'),
        ]) }},
        hotels: {{ \Illuminate\Support\Js::from($bookingHotels) }},
        lockHotel: {{ $isHotelLocked ? 'true' : 'false' }},
        limits: {{ \Illuminate\Support\Js::from([
            'maxNights' => (int) config('booking.max_nights'),
            'maxAdvanceDays' => (int) config('booking.max_advance_days'),
            'maxRooms' => (int) config('booking.max_rooms'),
            'maxAdults' => (int) config('booking.max_adults_per_room'),
            'maxTotalGuests' => (int) config('booking.max_total_guests'),
        ]) }},
        old: {{ \Illuminate\Support\Js::from([
            'checkin' => old('checkin'),
            'checkout' => old('checkout'),
            'rooms' => old('rooms'),
            'adults' => old('adults'),
            'hotel' => old('hotel', $lockedHotel),
            'promotion_code' => old('promotion_code'),
        ]) }},
    })"
    @keydown.escape.window="panel = null"
    @click.outside="panel = null"
    @submit="onSubmit($event)"
    novalidate
>
    <input type="hidden" name="checkin" :value="checkin">
    <input type="hidden" name="checkout" :value="checkout">
    <input type="hidden" name="hotel" :value="hotel">
    <input type="hidden" name="rooms" :value="roomGuests.length">
    <input type="hidden" name="adults" :value="roomGuests[0]?.adults || adults">
    <template x-for="(room, index) in roomGuests" :key="`room-adults-${index}`">
        <input type="hidden" name="room_adults[]" :value="room.adults">
    </template>
    <input type="hidden" name="promotion_code" :value="promotionCode">

    @if ($errors->any())
        <div class="type-b3 mx-5 mt-5 rounded-full border {{ $accentBorder }} bg-white px-4 py-3 lg:absolute lg:bottom-full lg:mb-3 lg:w-full lg:px-0" role="alert">
            <ul class="space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div
        x-show="clientError"
        x-cloak
        class="type-b3 mx-5 mt-5 rounded-full border {{ $accentBorder }} bg-white px-4 py-3 lg:absolute lg:bottom-full lg:mb-3 lg:w-full lg:px-0"
        role="alert"
        x-text="clientError"
    ></div>

    {{-- Desktop shell --}}
    <div class="relative z-10 hidden lg:block">
        {{-- WHERE drop-up --}}
        <div
            class="absolute bottom-full left-0 z-20 w-auto min-w-[16rem]"
            x-show="panel === 'where' && ! lockHotel"
            x-cloak
            x-transition.opacity.duration.150ms
        >
            <div class="bg-off-white-100 pt-2">
                <template x-for="option in hotels" :key="`desktop-where-${option.value}`">
                    <button
                        type="button"
                        class="type-btn-md no-underline block w-full px-6 py-3.5 text-left uppercase transition-colors duration-200"
                        :class="option.value === hotel ? 'bg-yellow-gold-500 text-white' : 'bg-transparent text-black-500 hover:bg-black-100/40'"
                        @click="selectHotel(option.value)"
                        x-text="option.label"
                    ></button>
                </template>
            </div>
        </div>

        {{-- WHO drop-up --}}
        <div
            class="absolute bottom-full left-0 z-20 w-full max-w-sm"
            x-show="panel === 'who'"
            x-cloak
            x-transition.opacity.duration.150ms
        >
            <div class="rounded-t-[24px] bg-off-white-100 px-8 pb-7 pt-7">
                <template x-for="(room, index) in roomGuests" :key="`desktop-room-${index}`">
                    <div :class="{ 'mt-8': index > 0 }">
                        <p class="type-btn-sm no-underline uppercase text-black-500" x-text="labels.room_number.replace(':number', index + 1)"></p>
                        <div class="mt-3 border-t border-black-100"></div>

                        <div class="mt-6 flex items-center justify-between gap-4">
                            <span class="type-btn-md no-underline uppercase">{{ __('home.booking.guests') }}</span>
                            <div class="flex items-center gap-4">
                                <button type="button" class="type-btn-md no-underline flex size-8 items-center justify-center rounded-full border border-black-500" @click="room.adults = Math.max(1, room.adults - 1)" aria-label="-">−</button>
                                <span class="type-btn-md no-underline w-4 text-center" x-text="room.adults"></span>
                                <button type="button" class="type-btn-md no-underline flex size-8 items-center justify-center rounded-full border border-black-500" @click="room.adults = Math.min(limits.maxAdults, room.adults + 1)" aria-label="+">+</button>
                            </div>
                        </div>
                    </div>
                </template>

                <div class="mt-8 flex items-center gap-3">
                    <button
                        type="button"
                        class="type-btn-md no-underline flex-1 rounded-[14px] border {{ $accentOutline }} px-4 py-3 uppercase transition-colors duration-300"
                        @click="addRoom()"
                        x-show="roomGuests.length < limits.maxRooms"
                    >
                        {{ __('home.booking.add_room') }}
                    </button>
                    <button
                        type="button"
                        class="type-btn-md no-underline shrink-0 rounded-[14px] {{ $accentSolid }} px-8 py-3 uppercase text-white transition-colors duration-300"
                        @click="applyGuests()"
                    >
                        {{ __('home.booking.apply') }}
                    </button>
                </div>
            </div>
        </div>

        {{-- WHEN calendar drop-up (absolute: does not push hero content) --}}
        <div
            class="absolute inset-x-0 bottom-full z-20"
            x-show="panel === 'when'"
            x-cloak
            x-transition.opacity.duration.150ms
        >
            <div class="rounded-t-[24px] bg-off-white-100 px-8 pb-4 pt-8">
                <div class="grid grid-cols-2 gap-12">
                    <template x-for="(monthKey, monthIndex) in calendarMonths" :key="`desktop-month-${monthKey}`">
                        <div>
                            <div class="mb-5 flex items-center justify-center gap-4">
                                <button
                                    type="button"
                                    class="type-btn-md no-underline px-1 transition-opacity duration-300 hover:opacity-40"
                                    x-show="monthIndex === 0"
                                    @click="prevMonth()"
                                    aria-label="-"
                                >‹</button>
                                <p class="type-btn-md no-underline uppercase" x-text="monthLabel(monthKey)"></p>
                                <button
                                    type="button"
                                    class="type-btn-md no-underline px-1 transition-opacity duration-300 hover:opacity-40"
                                    x-show="monthIndex === 1"
                                    @click="nextMonth()"
                                    aria-label="+"
                                >›</button>
                            </div>

                            <div class="grid grid-cols-7 gap-0 border-b border-black-100 pb-3 text-center">
                                <template x-for="weekday in calendarWeekdays" :key="`${monthKey}-${weekday}`">
                                    <span class="type-label text-black-500" x-text="weekday"></span>
                                </template>
                            </div>

                            <div class="mt-2 grid grid-cols-7 gap-0">
                                <template x-for="cell in daysForMonth(monthKey)" :key="cell.key">
                                    <x-home.booking-calendar-day />
                                </template>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        {{-- Bar stays in flow (fixed height) --}}
        <div
            class="bg-off-white-100"
            :class="{
                'rounded-[24px]': ! panel || panel === 'promotion',
                'rounded-b-[24px] rounded-t-none': panel === 'when',
                'rounded-tr-[24px] rounded-br-[24px] rounded-bl-[24px] rounded-tl-none': panel === 'where' || panel === 'who',
            }"
        >
            <div class="flex items-center gap-6 px-6 py-3">
                <button
                    type="button"
                    class="flex min-w-0 flex-1 items-center gap-3 text-left outline-none focus-visible:outline-none {{ $isHotelLocked ? 'cursor-default' : '' }}"
                    @click="openPanel('where')"
                    :aria-expanded="panel === 'where'"
                    @if ($isHotelLocked) aria-disabled="true" @endif
                >
                    <img src="{{ asset('images/home/form/1.svg') }}" alt="" width="44" height="44" class="size-11 shrink-0">
                    <span class="flex min-w-0 flex-1 flex-col">
                        <span class="type-btn-sm no-underline">{{ __('home.booking.where') }}</span>
                        <span class="type-btn-md no-underline truncate uppercase" x-text="hotelLabel"></span>
                    </span>
                </button>

                <button type="button" class="flex min-w-0 flex-[1.4] items-center gap-3 text-left outline-none focus-visible:outline-none" @click="openPanel('when')" :aria-expanded="panel === 'when'">
                    <img src="{{ asset('images/home/form/2.svg') }}" alt="" width="44" height="44" class="size-11 shrink-0">
                    <span class="flex min-w-0 flex-1 flex-col">
                        <span class="type-btn-sm no-underline">{{ __('home.booking.when') }}</span>
                        <span class="type-btn-md no-underline truncate uppercase" x-text="dateLabel"></span>
                    </span>
                </button>

                <button type="button" class="flex min-w-0 flex-1 items-center gap-3 text-left outline-none focus-visible:outline-none" @click="openPanel('who')" :aria-expanded="panel === 'who'">
                    <img src="{{ asset('images/home/form/3.svg') }}" alt="" width="44" height="44" class="size-11 shrink-0">
                    <span class="flex min-w-0 flex-1 flex-col">
                        <span class="type-btn-sm no-underline">{{ __('home.booking.who') }}</span>
                        <span class="type-btn-md no-underline truncate uppercase" x-text="guestLabel"></span>
                    </span>
                </button>

                <label class="flex min-w-0 flex-1 cursor-text items-center gap-3">
                    <img src="{{ asset('images/home/form/4.svg') }}" alt="" width="44" height="44" class="size-11 shrink-0">
                    <span class="flex min-w-0 flex-1 flex-col">
                        <span class="type-btn-sm no-underline">{{ __('home.booking.promotion') }}</span>
                        <input
                            type="text"
                            x-model="promotionCode"
                            @focus="panel = null"
                            placeholder="{{ __('home.booking.code_placeholder') }}"
                            autocomplete="off"
                            aria-label="{{ __('home.booking.promotion_code') }}"
                            class="type-btn-md no-underline w-full bg-transparent uppercase outline-none placeholder:text-black-500"
                        >
                    </span>
                </label>

                <button
                    type="submit"
                    class="type-btn-md no-underline shrink-0 rounded-[14px] {{ $accentSolid }} px-8 py-3 uppercase text-white transition-colors duration-300"
                >
                    {{ __('home.booking.search') }}
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile compact bar --}}
    <div class="lg:hidden" x-show="! panel">
        <div class="flex items-center py-1.5 pl-2 pr-1.5">
            <button
                type="button"
                class="flex shrink-0 items-center justify-center p-2 outline-none focus-visible:outline-none {{ $isHotelLocked ? 'cursor-default' : '' }}"
                @click="openPanel('where')"
                aria-label="{{ __('home.booking.where') }}"
                @if ($isHotelLocked) aria-disabled="true" @endif
            >
                <img src="{{ asset('images/home/form/1.svg') }}" alt="" width="24" height="24" class="size-6 shrink-0">
            </button>

            <span class="h-5 w-px shrink-0 bg-black-500" aria-hidden="true"></span>

            <button
                type="button"
                class="flex min-w-0 flex-1 items-center justify-center px-2 outline-none focus-visible:outline-none"
                @click="openPanel('when')"
                aria-label="{{ __('home.booking.when') }}"
            >
                <span class="type-btn-sm no-underline truncate uppercase" x-text="compactDateLabel"></span>
            </button>

            <span class="h-5 w-px shrink-0 bg-black-500" aria-hidden="true"></span>

            <button
                type="button"
                class="flex shrink-0 items-center gap-1 px-2 outline-none focus-visible:outline-none"
                @click="openPanel('who')"
                aria-label="{{ __('home.booking.who') }}"
            >
                <img src="{{ asset('images/home/form/3.svg') }}" alt="" width="24" height="24" class="size-6 shrink-0">
                <span class="type-btn-sm no-underline" x-text="totalGuests"></span>
            </button>

            <span class="h-5 w-px shrink-0 bg-black-500" aria-hidden="true"></span>

            <button
                type="button"
                class="flex shrink-0 items-center justify-center p-2 outline-none focus-visible:outline-none"
                @click="openPanel('promotion')"
                aria-label="{{ __('home.booking.promotion') }}"
            >
                <img src="{{ asset('images/home/form/4.svg') }}" alt="" width="24" height="24" class="size-6 shrink-0">
            </button>

            <button
                type="submit"
                class="ml-1 flex size-10 shrink-0 items-center justify-center rounded-full {{ $accentSolid }} text-off-white-100 transition-colors duration-300"
                aria-label="{{ __('home.booking.search') }}"
            >
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="size-5" aria-hidden="true">
                    <circle cx="11" cy="11" r="7"></circle>
                    <path stroke-linecap="round" d="M20 20l-3-3"></path>
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile: WHERE --}}
    <div class="lg:hidden" x-show="panel === 'where'" x-cloak>
        <div class="px-5 py-8">
            <template x-for="option in hotels" :key="`mobile-where-${option.value}`">
                <button
                    type="button"
                    class="type-btn-md no-underline block w-full py-4 text-left uppercase transition-opacity duration-300 hover:opacity-40"
                    :class="option.value === hotel ? 'bg-yellow-gold-500 px-4 text-white' : ''"
                    @click="selectHotel(option.value)"
                    x-text="option.label"
                ></button>
            </template>
        </div>
        <x-home.booking-panel-header icon="1.svg" :label="__('home.booking.where')" />
    </div>

    {{-- Mobile: WHEN --}}
    <div class="lg:hidden" x-show="panel === 'when'" x-cloak>
        <x-home.booking-panel-header icon="2.svg" :label="__('home.booking.when')" position="top" />

        <div class="px-5 pb-5 pt-6">
            <div class="grid grid-cols-7 gap-1 border-b border-black-100 pb-4 text-center">
                <template x-for="weekday in calendarWeekdays" :key="`mobile-${weekday}`">
                    <span class="type-label text-black-500" x-text="weekday"></span>
                </template>
            </div>

            <div class="mt-6 flex items-center justify-between">
                <button type="button" class="type-btn-md no-underline px-2 transition-opacity duration-300 hover:opacity-40" @click="prevMonth()" aria-label="-">‹</button>
                <p class="type-btn-md no-underline uppercase" x-text="calendarMonthLabel"></p>
                <button type="button" class="type-btn-md no-underline px-2 transition-opacity duration-300 hover:opacity-40" @click="nextMonth()" aria-label="+">›</button>
            </div>

            <div class="mt-4 grid grid-cols-7 gap-1">
                <template x-for="cell in calendarDays" :key="cell.key">
                    <x-home.booking-calendar-day />
                </template>
            </div>
        </div>
    </div>

    {{-- Mobile: WHO --}}
    <div class="lg:hidden" x-show="panel === 'who'" x-cloak>
        <x-home.booking-panel-header icon="3.svg" :label="__('home.booking.who')" position="top" />

        <div class="px-5 py-6">
            <template x-for="(room, index) in roomGuests" :key="`mobile-room-${index}`">
                <div class="border-b border-black-100 pb-5" :class="{ 'mt-5': index > 0 }">
                    <p class="type-label text-black-500" x-text="labels.room_number.replace(':number', index + 1)"></p>

                    <div class="mt-4 flex items-center justify-between gap-4">
                        <span class="type-btn-md no-underline uppercase">{{ __('home.booking.guests') }}</span>
                        <div class="flex items-center gap-3">
                            <button type="button" class="type-btn-md no-underline size-8 rounded-full border border-black-500" @click="room.adults = Math.max(1, room.adults - 1)" aria-label="-">−</button>
                            <span class="type-b1 w-4 text-center" x-text="room.adults"></span>
                            <button type="button" class="type-btn-md no-underline size-8 rounded-full border border-black-500" @click="room.adults = Math.min(limits.maxAdults, room.adults + 1)" aria-label="+">+</button>
                        </div>
                    </div>
                </div>
            </template>

            <div class="mt-6 flex items-center gap-3">
                <button
                    type="button"
                    class="type-btn-md no-underline flex-1 rounded-[14px] border {{ $accentOutline }} px-4 py-3 uppercase transition-colors duration-300"
                    @click="addRoom()"
                    x-show="roomGuests.length < limits.maxRooms"
                >
                    {{ __('home.booking.add_room') }}
                </button>
                <button
                    type="button"
                    class="type-btn-md no-underline shrink-0 rounded-[14px] {{ $accentSolid }} px-8 py-3 uppercase text-white transition-colors duration-300"
                    @click="applyGuests()"
                >
                    {{ __('home.booking.apply') }}
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile: PROMOTION --}}
    <div class="lg:hidden" x-show="panel === 'promotion'" x-cloak>
        <x-home.booking-panel-header icon="4.svg" :label="__('home.booking.promotion')" position="top" />

        <div class="flex items-center gap-3 px-5 py-5">
            <input
                type="text"
                x-model="promotionCode"
                placeholder="{{ __('home.booking.code_placeholder') }}"
                autocomplete="off"
                aria-label="{{ __('home.booking.promotion_code') }}"
                class="type-btn-md no-underline min-w-0 flex-1 bg-transparent uppercase outline-none placeholder:text-black-500"
            >
            <button
                type="button"
                class="type-btn-md no-underline shrink-0 rounded-[14px] {{ $accentSolid }} px-6 py-3 uppercase text-white transition-colors duration-300"
                @click="panel = null"
            >
                {{ __('home.booking.apply') }}
            </button>
        </div>
    </div>
</form>
