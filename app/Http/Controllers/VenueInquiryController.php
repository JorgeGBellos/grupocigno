<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVenueInquiryRequest;
use App\Models\VenueInquiry;
use Illuminate\Http\RedirectResponse;

class VenueInquiryController
{
    public function __invoke(StoreVenueInquiryRequest $request): RedirectResponse
    {
        $hotel = $request->input('hotel') === 'cigno-mejorada' || $request->routeIs('cigno-mejorada.*')
            ? 'cigno-mejorada'
            : 'cigno-ermita';

        VenueInquiry::query()->create([
            ...$request->safe()->only([
                'first_name',
                'last_name',
                'email',
                'event_date',
                'event_type',
                'additional_information',
            ]),
            'locale' => app()->getLocale(),
            'hotel' => $hotel,
            'ip_address' => $request->ip(),
            'user_agent' => (string) $request->userAgent(),
        ]);

        $redirectRoute = $hotel === 'cigno-mejorada'
            ? 'cigno-mejorada.venue.thank-you'
            : 'cigno-ermita.venue.thank-you';

        return redirect()
            ->route($redirectRoute)
            ->with('venue_submitted', true);
    }
}
