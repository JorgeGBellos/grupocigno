<?php

namespace Tests\Feature;

use Tests\TestCase;

class LocaleSwitchTest extends TestCase
{
    public function test_the_language_switcher_is_rendered(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Español', false)
            ->assertSee('English', false)
            ->assertSee('id="language-menu"', false)
            ->assertSee(route('locale.update', 'es'), false)
            ->assertSee(route('locale.update', 'en'), false);
    }

    public function test_the_default_locale_is_spanish(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('<html lang="es"', false)
            ->assertSee(__('home.hero.line_1', [], 'es'), false)
            ->assertSee(__('ui.open_menu', [], 'es'), false)
            ->assertDontSee(__('home.hero.line_1', [], 'en'), false);
    }

    public function test_the_locale_can_be_switched_to_english(): void
    {
        $this->from(route('home'))
            ->get(route('locale.update', 'en'))
            ->assertRedirect(route('home'));

        $this->assertSame('en', session('locale'));

        $this->withSession(['locale' => 'en'])
            ->get(route('home'))
            ->assertOk()
            ->assertSee('<html lang="en"', false)
            ->assertSee(__('home.hero.line_1', [], 'en'), false)
            ->assertSee(__('ui.open_menu', [], 'en'), false)
            ->assertSee(__('nav.press', [], 'en'), false)
            ->assertDontSee(__('home.hero.line_1', [], 'es'), false);
    }

    public function test_an_invalid_locale_is_rejected(): void
    {
        $this->get('/locale/fr')->assertNotFound();
    }
}
