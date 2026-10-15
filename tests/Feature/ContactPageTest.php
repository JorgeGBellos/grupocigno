<?php

namespace Tests\Feature;

use Tests\TestCase;

class ContactPageTest extends TestCase
{
    public function test_the_contact_page_renders_the_form(): void
    {
        $this->get(route('contact'))
            ->assertOk()
            ->assertSee('images/footer/Swan.svg', false)
            ->assertSee(__('nav.contact'), false)
            ->assertSee(__('contact.lead_1'), false)
            ->assertSee(__('contact.lead_2'), false)
            ->assertSee(__('contact.placeholder_name'), false)
            ->assertSee(__('contact.placeholder_phone'), false)
            ->assertSee(__('contact.placeholder_subject'), false)
            ->assertSee(__('contact.placeholder_message'), false)
            ->assertSee(__('contact.submit'), false);
    }
}
