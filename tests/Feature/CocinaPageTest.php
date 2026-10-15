<?php

namespace Tests\Feature;

use Tests\TestCase;

class CocinaPageTest extends TestCase
{
    public function test_the_cocina_vidente_page_renders_both_sections(): void
    {
        $this->get(route('cocina-vidente'))
            ->assertOk()
            ->assertSee(__('cocina.title'), false)
            ->assertSee(__('cocina.lead'), false)
            ->assertSee(__('cocina.book_ermita'), false)
            ->assertSee(__('cocina.book_mejorada'), false)
            ->assertSee(__('cocina.see_menu'), false)
            ->assertSee('images/home/Cocina%20Vidente.svg', false)
            ->assertSee('images/cocina/766674731_1038934385408593_3915687115600101391_n.jpg', false)
            ->assertSee(__('cocina.chef.title'), false)
            ->assertSee(__('cocina.chef.body_1'), false)
            ->assertSee(__('cocina.chef.body_2'), false)
            ->assertSee('images/ermita/restaurant/Rectangle%204%20(6).png', false)
            ->assertSee(route('cigno-ermita.restaurant', absolute: false), false)
            ->assertSee(route('cigno-mejorada.restaurant', absolute: false), false);
    }

    public function test_main_navigation_points_to_group_cocina_page(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee(route('cocina-vidente', absolute: false), false);
    }
}
