<?php

namespace Tests\Feature;

use Tests\TestCase;

class MejoradaNavigationTest extends TestCase
{
    public function test_mejorada_marks_brand_tab_as_current(): void
    {
        $this->get(route('cigno-mejorada'))
            ->assertOk()
            ->assertSee(__('nav.brand_mejorada'), false)
            ->assertSee(__('nav.book_in_mejorada'), false)
            ->assertSee('has-branch-row', false);
    }

    public function test_mejorada_shows_mejorada_menu(): void
    {
        $this->get(route('cigno-mejorada'))
            ->assertOk()
            ->assertSee(__('nav.mejorada_home'))
            ->assertSee(__('nav.mejorada_rooms'))
            ->assertSee(__('nav.mejorada_gastronomy'))
            ->assertSee(__('nav.mejorada_daypass'))
            ->assertSee(__('nav.mejorada_experiences'))
            ->assertSee(__('nav.mejorada_venue'))
            ->assertSee(__('nav.mejorada_contact'))
            ->assertSee(route('cigno-mejorada.rooms', absolute: false), false)
            ->assertSee(route('cigno-mejorada.daypass', absolute: false), false)
            ->assertSee(__('pages.coming_soon.eyebrow'), false)
            ->assertDontSee(__('nav.club'), false);
    }

    public function test_mejorada_lang_files_have_same_keys_as_ermita(): void
    {
        $ermitaEs = require resource_path('../lang/es/ermita.php');
        $mejoradaEs = require resource_path('../lang/es/mejorada.php');
        $ermitaEn = require resource_path('../lang/en/ermita.php');
        $mejoradaEn = require resource_path('../lang/en/mejorada.php');

        $this->assertSame(array_keys($ermitaEs), array_keys($mejoradaEs));
        $this->assertSame(array_keys($ermitaEn), array_keys($mejoradaEn));
        $this->assertSame(array_keys($ermitaEs['rooms']), array_keys($mejoradaEs['rooms']));
        $this->assertSame(array_keys($ermitaEs['restaurant']), array_keys($mejoradaEs['restaurant']));
        $this->assertSame(array_keys($ermitaEs['experiences']), array_keys($mejoradaEs['experiences']));
        $this->assertSame(array_keys($ermitaEs['daypass']), array_keys($mejoradaEs['daypass']));
        $this->assertSame(array_keys($ermitaEs['contact']), array_keys($mejoradaEs['contact']));
        $this->assertSame(array_keys($ermitaEs['venue']), array_keys($mejoradaEs['venue']));
    }
}
