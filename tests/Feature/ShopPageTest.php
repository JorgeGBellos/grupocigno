<?php

namespace Tests\Feature;

use Tests\TestCase;

class ShopPageTest extends TestCase
{
    public function test_the_shop_page_renders_tiendita(): void
    {
        $this->get(route('shop'))
            ->assertOk()
            ->assertDontSee('images/home/Isolation_Mode (6).svg', false)
            ->assertSee(__('shop.title'), false)
            ->assertSee(__('shop.lead_1'), false)
            ->assertSee(__('shop.lead_2'), false)
            ->assertSee('type-h1', false)
            ->assertSee('type-b2', false)
            ->assertSee('type-h3', false)
            ->assertSee('type-b1', false)
            ->assertSee('type-b3', false)
            ->assertSee(__('shop.items.0.products.0.brand'), false)
            ->assertSee(__('shop.items.1.products.0.brand'), false)
            ->assertSee(__('shop.items.2.products.0.brand'), false)
            ->assertSee('images/store/Rectangle 4 (3).png', false)
            ->assertSee('images/store/Rectangle 4 (4).png', false)
            ->assertSee('images/store/Rectangle 4 (5).png', false);
    }
}
