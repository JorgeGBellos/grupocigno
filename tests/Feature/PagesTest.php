<?php

namespace Tests\Feature;

use Tests\TestCase;

class PagesTest extends TestCase
{
    public function test_public_pages_can_be_rendered(): void
    {
        $pages = [
            'home' => 'images/footer/Swan.svg',
            'cigno-ermita' => 'nav.ermita',
            'cigno-mejorada' => 'nav.mejorada',
            'cigno-club' => 'nav.club',
            'cocina-vidente' => 'cocina.title',
            'press' => 'nav.press',
            'shop' => 'shop.title',
            'contact' => 'nav.contact',
            'legal-notice' => 'pages.legal_notice',
            'cookies-policy' => 'pages.cookies_policy',
            'cookie-settings' => 'pages.cookie_settings',
        ];

        foreach ($pages as $route => $copy) {
            $expected = str_contains($copy, '/') ? $copy : __($copy);

            $response = $this->get(route($route))
                ->assertOk()
                ->assertSee($expected, false)
                ->assertSee('images/footer/Swan.svg', false);

            if ($route === 'cigno-mejorada') {
                $response->assertSee(__('pages.coming_soon.eyebrow'), false);
            }
        }
    }
}
