<?php

namespace Tests\Feature;

use Tests\TestCase;

class PressPageTest extends TestCase
{
    public function test_the_press_page_renders_the_archive(): void
    {
        $this->get(route('press'))
            ->assertOk()
            ->assertDontSee('images/home/Union (3)2.svg', false)
            ->assertSee(__('nav.press'), false)
            ->assertSee(__('press.intro'), false)
            ->assertSee(route('contact'), false)
            ->assertSee(__('press.articles.0.title'), false)
            ->assertSee(__('press.articles.0.publication'), false)
            ->assertSee('images/home/newyork.svg', false)
            ->assertSee(__('press.articles.1.publication'), false)
            ->assertSee(__('press.articles.2.title'), false)
            ->assertSee('Cigno es más que una colección de hoteles', false)
            ->assertSee('images/press/Chilango.png', false)
            ->assertSee('images/press/The%20Happening.png', false)
            ->assertSee(__('press.read_article'), false);
    }
}
