<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MejoradaPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_mejorada_pages_show_coming_soon(): void
    {
        $routes = [
            'cigno-mejorada',
            'cigno-mejorada.story',
            'cigno-mejorada.rooms',
            'cigno-mejorada.offers',
            'cigno-mejorada.daypass',
            'cigno-mejorada.contact',
            'cigno-mejorada.contact.thank-you',
            'cigno-mejorada.restaurant',
            'cigno-mejorada.experiences',
            'cigno-mejorada.venue',
            'cigno-mejorada.venue.thank-you',
        ];

        foreach ($routes as $route) {
            $this->get(route($route))
                ->assertOk()
                ->assertSee(__('nav.mejorada'), false)
                ->assertSee(__('pages.coming_soon.eyebrow'), false);
        }
    }

    public function test_ermita_header_does_not_contain_mejorada_branch_row_nav(): void
    {
        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertDontSee(__('nav.book_in_mejorada'));
        $response->assertDontSee(route('cigno-mejorada.story'));
    }

    public function test_room_show_page_shows_coming_soon(): void
    {
        $this->get(route('cigno-mejorada.rooms.show', 'classic-room-king'))
            ->assertOk()
            ->assertSee(__('pages.coming_soon.eyebrow'), false);
    }

    public function test_venue_inquiry_is_blocked_while_coming_soon(): void
    {
        $payload = [
            'hotel' => 'cigno-mejorada',
            'first_name' => 'María',
            'last_name' => 'González',
            'email' => 'maria@example.com',
            'event_date' => now()->addDays(30)->toDateString(),
            'event_type' => 'wedding',
            'additional_information' => 'Evento para 50 personas.',
        ];

        $this->post(route('cigno-mejorada.venue.store'), $payload)
            ->assertRedirect(route('cigno-mejorada'));
    }

    public function test_pages_work_in_english_locale(): void
    {
        $this->get(route('locale.update', 'en'));

        $this->get(route('cigno-mejorada'))
            ->assertOk()
            ->assertSee(__('nav.mejorada'), false)
            ->assertSee(__('pages.coming_soon.eyebrow'), false);
    }
}
