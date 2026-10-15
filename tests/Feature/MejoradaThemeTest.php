<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Blade;
use Tests\TestCase;

class MejoradaThemeTest extends TestCase
{
    use RefreshDatabase;

    public function test_mejorada_pages_show_coming_soon_while_property_is_hidden(): void
    {
        $routes = [
            'cigno-mejorada',
            'cigno-mejorada.rooms',
            'cigno-mejorada.restaurant',
            'cigno-mejorada.daypass',
            'cigno-mejorada.experiences',
            'cigno-mejorada.venue',
            'cigno-mejorada.contact',
        ];

        foreach ($routes as $route) {
            $response = $this->get(route($route));
            $response->assertOk();
            $response->assertSee(__('pages.coming_soon.eyebrow'), false);
            $response->assertSee('blue-mejorada-300', false);
        }

        $roomShow = $this->get(route('cigno-mejorada.rooms.show', 'classic-room-king'));
        $roomShow->assertOk();
        $roomShow->assertSee(__('pages.coming_soon.eyebrow'), false);
        $roomShow->assertSee('blue-mejorada-300', false);
    }

    public function test_ermita_pages_preserve_blue_ermita_and_contain_no_blue_mejorada(): void
    {
        $routes = [
            'cigno-ermita',
            'cigno-ermita.barrio',
            'cigno-ermita.offers',
            'cigno-ermita.rooms',
            'cigno-ermita.restaurant',
            'cigno-ermita.daypass',
            'cigno-ermita.experiences',
            'cigno-ermita.venue',
            'cigno-ermita.contact',
        ];

        foreach ($routes as $route) {
            $response = $this->get(route($route));
            $response->assertOk();
            $response->assertSee('blue-ermita-300', false);
            $response->assertDontSee('blue-mejorada', false);
        }
    }

    public function test_booking_bar_renders_correct_accent_classes(): void
    {
        view()->share('errors', new \Illuminate\Support\ViewErrorBag);

        $htmlMejorada = Blade::render('<x-home.booking-bar accent="mejorada" locked-hotel="cigno-mejorada" />');
        $this->assertStringContainsString('bg-blue-mejorada-300', $htmlMejorada);
        $this->assertStringContainsString('border-blue-mejorada-300 text-blue-mejorada-300', $htmlMejorada);

        $htmlErmita = Blade::render('<x-home.booking-bar accent="ermita" locked-hotel="cigno-ermita" />');
        $this->assertStringContainsString('bg-blue-ermita-300', $htmlErmita);
        $this->assertStringContainsString('border-blue-ermita-300 text-blue-ermita-300', $htmlErmita);

        $htmlGold = Blade::render('<x-home.booking-bar accent="gold" />');
        $this->assertStringContainsString('bg-yellow-gold-500', $htmlGold);
        $this->assertStringContainsString('border-yellow-gold-500 text-yellow-gold-500', $htmlGold);
    }

    public function test_contact_form_renders_correct_accent_classes(): void
    {
        view()->share('errors', new \Illuminate\Support\ViewErrorBag);

        $htmlMejorada = Blade::render('<x-contact.form accent="mejorada" source="mejorada" />');
        $this->assertStringContainsString('bg-blue-mejorada-300', $htmlMejorada);

        $htmlErmita = Blade::render('<x-contact.form accent="ermita" source="ermita" />');
        $this->assertStringContainsString('bg-blue-ermita-300', $htmlErmita);

        $htmlGold = Blade::render('<x-contact.form accent="gold" source="grupo" />');
        $this->assertStringContainsString('bg-yellow-gold-500', $htmlGold);

        // When errors exist, verify errorClass is applied
        $errorsWithMsg = new \Illuminate\Support\ViewErrorBag;
        $errorsWithMsg->put('default', new \Illuminate\Support\MessageBag(['name' => 'El nombre es obligatorio']));
        view()->share('errors', $errorsWithMsg);

        $htmlMejoradaWithErrors = Blade::render('<x-contact.form accent="mejorada" source="mejorada" />');
        $this->assertStringContainsString('border-blue-mejorada-300 text-blue-mejorada-300', $htmlMejoradaWithErrors);

        $htmlErmitaWithErrors = Blade::render('<x-contact.form accent="ermita" source="ermita" />');
        $this->assertStringContainsString('border-blue-ermita-300 text-blue-ermita-300', $htmlErmitaWithErrors);

        $htmlGoldWithErrors = Blade::render('<x-contact.form accent="gold" source="grupo" />');
        $this->assertStringContainsString('border-yellow-gold-500 text-yellow-gold-500', $htmlGoldWithErrors);
    }
}
