<?php

namespace App\Http\Requests;

use Carbon\CarbonImmutable;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class BookingSearchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $maxAdvance = now()->addDays((int) config('booking.max_advance_days'))->toDateString();
        $maxNights = (int) config('booking.max_nights');

        return [
            'hotel' => ['required', 'string', Rule::in(array_keys(config('booking.hotels')))],
            'checkin' => ['required', 'date', 'after_or_equal:today', 'before_or_equal:'.$maxAdvance],
            'checkout' => ['required', 'date', 'after:checkin'],
            'rooms' => ['required', 'integer', 'min:1', 'max:'.config('booking.max_rooms')],
            'adults' => ['required', 'integer', 'min:1', 'max:'.config('booking.max_adults_per_room')],
            'room_adults' => ['nullable', 'array', 'max:'.config('booking.max_rooms')],
            'room_adults.*' => ['integer', 'min:1', 'max:'.config('booking.max_adults_per_room')],
            'promotion_code' => ['nullable', 'string', 'max:40', 'regex:/^[A-Za-z0-9_-]*$/'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            $checkin = $this->input('checkin');
            $checkout = $this->input('checkout');
            $rooms = (int) $this->input('rooms');
            $roomAdults = $this->input('room_adults');
            $adults = (int) $this->input('adults');

            if ($checkin && $checkout) {
                $nights = max(1, (int) CarbonImmutable::parse($checkin)->diffInDays(CarbonImmutable::parse($checkout)));

                if ($nights > (int) config('booking.max_nights')) {
                    $validator->errors()->add('checkout', __('home.booking.validation.max_nights'));
                }
            }

            $totalGuests = is_array($roomAdults) && $roomAdults !== []
                ? array_sum(array_map('intval', $roomAdults))
                : $rooms * $adults;

            if ($totalGuests > (int) config('booking.max_total_guests')) {
                $validator->errors()->add('adults', __('home.booking.validation.max_guests'));
            }
        });
    }

    public function messages(): array
    {
        return [
            'hotel.required' => __('home.booking.validation.hotel_required'),
            'hotel.in' => __('home.booking.validation.hotel_invalid'),
            'checkin.required' => __('home.booking.validation.checkin_required'),
            'checkin.after_or_equal' => __('home.booking.validation.checkin_past'),
            'checkin.before_or_equal' => __('home.booking.validation.checkin_too_far'),
            'checkout.required' => __('home.booking.validation.checkout_required'),
            'checkout.after' => __('home.booking.validation.checkout_before_checkin'),
            'rooms.required' => __('home.booking.validation.rooms_required'),
            'rooms.min' => __('home.booking.validation.rooms_min'),
            'rooms.max' => __('home.booking.validation.rooms_max'),
            'adults.required' => __('home.booking.validation.adults_required'),
            'adults.min' => __('home.booking.validation.adults_min'),
            'adults.max' => __('home.booking.validation.adults_max'),
            'promotion_code.regex' => __('home.booking.validation.promotion_invalid'),
        ];
    }
}
