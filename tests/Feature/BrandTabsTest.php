<?php

namespace Tests\Feature;

use Tests\TestCase;

class BrandTabsTest extends TestCase
{
    public function test_home_shows_cigno_header_and_menu_brands(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('images/Logotipo (3).svg', false)
            ->assertSee(__('nav.menu_cigno_ermita'), false)
            ->assertSee(__('nav.menu_cigno_mejorada'), false)
            ->assertSee(__('nav.book_in_cigno'), false)
            ->assertSee('id="site-menu"', false);
    }

    public function test_home_menu_links_to_hotel_homes(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee(route('cigno-ermita', absolute: false), false)
            ->assertSee(route('cigno-mejorada', absolute: false), false);
    }

    public function test_ermita_pages_show_ermita_menu(): void
    {
        $this->get(route('cigno-ermita'))
            ->assertOk()
            ->assertSee(__('nav.brand_ermita'), false)
            ->assertSee(__('nav.ermita_home'), false)
            ->assertSee(__('nav.ermita_rooms'))
            ->assertSee(__('nav.ermita_gastronomy'), false)
            ->assertSee(__('nav.ermita_daypass'), false)
            ->assertSee(__('nav.ermita_experiences'), false)
            ->assertSee(__('nav.ermita_venue'), false)
            ->assertSee(__('nav.ermita_contact'), false)
            ->assertSee(route('cigno-ermita.rooms', absolute: false), false)
            ->assertSee(route('cigno-ermita.daypass', absolute: false), false)
            ->assertDontSee(__('nav.club'), false);
    }

    public function test_ermita_child_page_keeps_ermita_menu(): void
    {
        $this->get(route('cigno-ermita.rooms'))
            ->assertOk()
            ->assertSee(__('nav.brand_ermita'), false)
            ->assertSee(__('nav.ermita_rooms'))
            ->assertSee(__('nav.ermita_venue'), false)
            ->assertSee(__('nav.ermita_daypass'), false);
    }

    public function test_ermita_homepage_renders_sections(): void
    {
        $this->get(route('cigno-ermita'))
            ->assertOk()
            ->assertSee(__('ermita.hero.line_1'), false)
            ->assertSee(__('ermita.story.title'), false)
            ->assertSee(__('ermita.barrio.title'), false)
            ->assertSee(__('ermita.rooms.title'), false)
            ->assertSee(__('ermita.amenities.title'), false)
            ->assertSee(__('ermita.cocina.body'), false)
            ->assertSee(__('nav.ermita_home'), false)
            ->assertDontSee(__('nav.club'), false);
    }
}
