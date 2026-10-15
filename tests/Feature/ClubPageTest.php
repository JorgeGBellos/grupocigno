<?php

namespace Tests\Feature;

use Tests\TestCase;

class ClubPageTest extends TestCase
{
    public function test_the_club_page_renders_external_auth_links(): void
    {
        $this->get(route('cigno-club'))
            ->assertOk()
            ->assertSee('images/club/Guia.svg', false)
            ->assertSee(__('nav.club'), false)
            ->assertSee(__('club.lead'), false)
            ->assertSee(__('club.prompt'), false)
            ->assertSee(__('club.sign_up'), false)
            ->assertSee(__('club.sign_in'), false)
            ->assertSee(config('club.sign_up_url'), false)
            ->assertSee(config('club.sign_in_url'), false)
            ->assertDontSee(__('club.name'), false)
            ->assertDontSee(__('club.submit'), false);
    }
}
