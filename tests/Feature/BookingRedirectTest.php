<?php

namespace Tests\Feature;

use Tests\TestCase;

class BookingRedirectTest extends TestCase
{
    public function test_the_booking_search_redirects_to_mirai(): void
    {
        $checkin = now()->addDays(10)->toDateString();
        $checkout = now()->addDays(12)->toDateString();

        $response = $this->get(route('booking.search', [
            'hotel' => 'cigno-mejorada',
            'checkin' => $checkin,
            'checkout' => $checkout,
            'rooms' => 1,
            'adults' => 4,
        ]));

        $location = $response->headers->get('Location');

        $response->assertRedirect();
        $this->assertSame('no-referrer', $response->headers->get('Referrer-Policy'));
        $this->assertStringContainsString('https://www.cignohotel.com/es/bookingstep1/', $location);
        $this->assertStringContainsString('nights=2', $location);
        $this->assertStringContainsString('home=https%3A%2F%2Fwww.cignohotel.com%2F', $location);
        $this->assertStringNotContainsString('localhost', $location);
    }

    public function test_invalid_booking_dates_are_rejected(): void
    {
        $this->from(route('home'))
            ->get(route('booking.search', [
                'hotel' => 'cigno-mejorada',
                'checkin' => now()->addDays(12)->toDateString(),
                'checkout' => now()->addDays(10)->toDateString(),
                'rooms' => 1,
                'adults' => 2,
            ]))
            ->assertRedirect(route('home'))
            ->assertSessionHasErrors(['checkout']);
    }

    public function test_booking_rejects_too_many_guests(): void
    {
        $this->from(route('home'))
            ->get(route('booking.search', [
                'hotel' => 'cigno-mejorada',
                'checkin' => now()->addDay()->toDateString(),
                'checkout' => now()->addDays(3)->toDateString(),
                'rooms' => 4,
                'adults' => 4,
            ]))
            ->assertRedirect(route('home'))
            ->assertSessionHasErrors(['adults']);
    }
}
