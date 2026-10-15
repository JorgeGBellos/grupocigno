<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactLeadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:40', 'regex:/^[\d\s+\-().]+$/'],
            'subject' => ['required', 'string', 'max:160'],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
            'source' => ['nullable', 'string', 'max:50'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('contact.validation.name_required'),
            'email.required' => __('contact.validation.email_required'),
            'email.email' => __('contact.validation.email_invalid'),
            'phone.required' => __('contact.validation.phone_required'),
            'phone.regex' => __('contact.validation.phone_invalid'),
            'subject.required' => __('contact.validation.subject_required'),
            'message.required' => __('contact.validation.message_required'),
            'message.min' => __('contact.validation.message_min'),
        ];
    }
}
