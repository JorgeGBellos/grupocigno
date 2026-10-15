<?php

namespace Tests\Feature;

use Tests\TestCase;

class DesignSystemPageTest extends TestCase
{
    public function test_the_design_system_page_can_be_rendered(): void
    {
        $response = $this->get(route('design-system'));

        $response->assertOk();
        $response->assertSee('Design System', false);
        $response->assertSee('type-h1', false);
        $response->assertSee('off-white-100', false);
        $response->assertSee('blue-ermita-500', false);
        $response->assertSee('blue-mejorada-500', false);
        $response->assertSee('type-btn-lg', false);
    }
}
