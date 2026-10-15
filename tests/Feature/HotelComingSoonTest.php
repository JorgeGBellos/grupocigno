<?php

namespace Tests\Feature;

use Tests\TestCase;

class HotelComingSoonTest extends TestCase
{
    public function test_cigno_ermita_is_not_coming_soon(): void
    {
        $this->get(route('cigno-ermita'))
            ->assertOk()
            ->assertSee(__('nav.ermita'), false)
            ->assertDontSee(__('pages.coming_soon.eyebrow'), false);
    }

    public function test_cigno_mejorada_shows_coming_soon(): void
    {
        $this->get(route('cigno-mejorada'))
            ->assertOk()
            ->assertSee(__('nav.mejorada'), false)
            ->assertSee(__('pages.coming_soon.eyebrow'), false)
            ->assertSee(__('pages.coming_soon.lead_1'), false);
    }

    public function test_cigno_mejorada_nested_routes_show_coming_soon(): void
    {
        foreach ([
            'cigno-mejorada.rooms',
            'cigno-mejorada.restaurant',
            'cigno-mejorada.experiences',
            'cigno-mejorada.venue',
            'cigno-mejorada.daypass',
            'cigno-mejorada.contact',
            'cigno-mejorada.offers',
            'cigno-mejorada.story',
        ] as $route) {
            $this->get(route($route))
                ->assertOk()
                ->assertSee(__('pages.coming_soon.eyebrow'), false);
        }
    }
}
