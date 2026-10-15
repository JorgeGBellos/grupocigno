<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreVenueInquiryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:120'],
            'last_name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255'],
            'event_date' => ['required', 'date', 'after_or_equal:today'],
            'event_type' => ['required', 'string', Rule::in(array_unique([
                ...array_keys((array) __('ermita.venue.event_types')),
                ...array_keys((array) __('mejorada.venue.event_types')),
            ]))],
            'additional_information' => ['nullable', 'string', 'max:5000'],
            'hotel' => ['nullable', 'string', 'in:cigno-ermita,cigno-mejorada'],
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => __('ermita.venue.validation.first_name_required'),
            'last_name.required' => __('ermita.venue.validation.last_name_required'),
            'email.required' => __('ermita.venue.validation.email_required'),
            'email.email' => __('ermita.venue.validation.email_invalid'),
            'event_date.required' => __('ermita.venue.validation.event_date_required'),
            'event_date.after_or_equal' => __('ermita.venue.validation.event_date_future'),
            'event_type.required' => __('ermita.venue.validation.event_type_required'),
            'event_type.in' => __('ermita.venue.validation.event_type_invalid'),
        ];
    }
}
