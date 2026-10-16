<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomePageTest extends TestCase
{
    public function test_the_homepage_returns_a_successful_response(): void
    {
        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee(config('app.name'), false);
        $response->assertSee(__('ui.open_menu'), false);
        $response->assertSee(__('ui.select_language'), false);
        $response->assertSee('id="site-menu"', false);
        $response->assertSee('images/home/Home (1).png', false);
        $response->assertSee('videos/01. WEB Cignos (1).mp4', false);
        $response->assertSee(__('home.booking.where'), false);
        $response->assertSee(__('home.booking.when'), false);
        $response->assertSee(__('home.booking.who'), false);
        $response->assertSee(__('home.booking.promotion'), false);
        $response->assertSee(__('nav.mejorada'), false);
        $response->assertSee(__('home.booking.search'), false);
        $response->assertSee('images/home/form/1.svg', false);
        $response->assertSee(__('home.story.lead_1'), false);
        $response->assertSee(__('home.story.lead_2'), false);
        $response->assertSee('images/mejorada/home/story-2.png', false);
        $response->assertSee('images/home/seccion1.2.png', false);
        $response->assertSee(__('home.destination.title'), false);
        $response->assertSee('images/home/Vector (15).svg', false);
        $response->assertSee('images/home/destinos.png', false);
        $response->assertSee('images/cocina/725621555_982617504576688_4481192901537941310_n.jpg', false);
        $response->assertSee(__('home.hotels.title'), false);
        $response->assertSee('images/home/Ermitaback.png', false);
        $response->assertSee('images/home/mejoradaback.png', false);
        $response->assertSee('images/home/Logotipo.svg', false);
        $response->assertSee('images/home/mejorada.svg', false);
        $response->assertSee(__('home.hotels.explore_ermita'), false);
        $response->assertSee(__('pages.coming_soon.eyebrow'), false);
        $response->assertSee(__('home.club.title'), false);
        $response->assertSee(__('home.club.line_1'), false);
        $response->assertSee('bg-yellow-gold-300', false);
        $response->assertSee('images/home/Layer_1 (55).svg', false);
        $response->assertSee(__('home.club.vip_note'), false);
        $response->assertSee('Cocina Vidente.svg', false);
        $response->assertSee('images/home/About (1).png', false);
        $response->assertSee(__('home.cocina.book_ermita'), false);
        $response->assertSee(__('home.cocina.see_more'), false);
        $response->assertSee('Tiendita', false);
        $response->assertSee(__('home.tiendita.body'), false);
        $response->assertSee(__('home.tiendita.cta'), false);
        $response->assertSee('images/home/Experience Collection.png', false);
        $response->assertSee(__('home.press.body'), false);
        $response->assertSee(__('home.press.cta'), false);
        $response->assertSee('images/home/Cigno Club.png', false);
    }
}
