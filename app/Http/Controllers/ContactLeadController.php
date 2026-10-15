<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactLeadRequest;
use App\Models\ContactLead;
use Illuminate\Http\RedirectResponse;

class ContactLeadController
{
    public function __invoke(StoreContactLeadRequest $request): RedirectResponse
    {
        ContactLead::query()->create([
            ...$request->safe()->only(['name', 'email', 'phone', 'subject', 'message']),
            'locale' => app()->getLocale(),
            'ip_address' => $request->ip(),
            'user_agent' => (string) $request->userAgent(),
        ]);

        $source = $request->input('source');
        $redirectRoute = match ($source) {
            'ermita', 'cigno-ermita' => 'cigno-ermita.contact.thank-you',
            'mejorada', 'cigno-mejorada' => 'cigno-mejorada.contact.thank-you',
            default => 'contact.thank-you',
        };

        return redirect()
            ->route($redirectRoute)
            ->with('contact_submitted', true);
    }
}
