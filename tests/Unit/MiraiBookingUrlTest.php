<?php

namespace Tests\Unit;

use App\Support\MiraiBookingUrl;
use Tests\TestCase;

class MiraiBookingUrlTest extends TestCase
{
    public function test_it_builds_the_mirai_booking_url(): void
    {
        $url = MiraiBookingUrl::make()->url([
            'hotel' => 'cigno-mejorada',
            'checkin' => '2026-09-09',
            'checkout' => '2026-09-11',
            'rooms' => 1,
            'adults' => 4,
            'promotion' => '',
            'locale' => 'es',
        ]);

        $this->assertStringStartsWith('https://www.cignohotel.com/es/bookingstep1/?', $url);
        $this->assertStringContainsString('chainSelectorValue=76818', $url);
        $this->assertStringContainsString('checkin=09%2F09%2F2026', $url);
        $this->assertStringContainsString('nights=2', $url);
        $this->assertStringContainsString('idchain=522722', $url);
        $this->assertStringContainsString('idtokenprovider=100380967', $url);
        $this->assertStringContainsString('hsri=02080', $url);
        $this->assertStringContainsString('clientCode=test', $url);
        $this->assertStringContainsString('lang=es', $url);
        $this->assertStringContainsString('type=chain', $url);
        $this->assertStringContainsString('home=https%3A%2F%2Fwww.cignohotel.com%2F', $url);
        $this->assertStringNotContainsString('localhost', $url);
        $this->assertStringContainsString('parties='.urlencode(base64_encode('[{"adults":4,"children":[]}]')), $url);
    }

    public function test_it_uses_the_promotion_code_as_client_code(): void
    {
        $url = MiraiBookingUrl::make()->url([
            'hotel' => 'cigno-ermita',
            'checkin' => '2026-09-09',
            'checkout' => '2026-09-10',
            'rooms' => 2,
            'adults' => 2,
            'promotion' => 'CIGNO5',
            'locale' => 'en',
        ]);

        $this->assertStringContainsString('/en/bookingstep1/', $url);
        $this->assertStringContainsString('clientCode=CIGNO5', $url);
        $this->assertStringContainsString('nights=1', $url);
        $this->assertStringContainsString(
            'parties='.urlencode(base64_encode('[{"adults":2,"children":[]},{"adults":2,"children":[]}]')),
            $url,
        );
    }
}
