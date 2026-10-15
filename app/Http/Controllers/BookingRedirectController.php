<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingSearchRequest;
use App\Support\MiraiBookingUrl;
use Illuminate\Http\RedirectResponse;

class BookingRedirectController
{
    public function __invoke(BookingSearchRequest $request): RedirectResponse
    {
        $data = $request->validated();

        return redirect()
            ->away(MiraiBookingUrl::make()->url([
                'hotel' => $data['hotel'],
                'checkin' => $data['checkin'],
                'checkout' => $data['checkout'],
                'rooms' => $data['rooms'],
                'adults' => $data['adults'],
                'room_adults' => $data['room_adults'] ?? null,
                'promotion' => $data['promotion_code'] ?? '',
                'locale' => app()->getLocale(),
            ]))
            ->header('Referrer-Policy', 'no-referrer');
    }
}
