<?php

namespace Tests\Feature;

use App\Models\ContactLead;
use Tests\TestCase;

class ContactLeadTest extends TestCase
{
    public function test_contact_form_stores_lead_and_redirects_to_thank_you_page(): void
    {
        $response = $this->post(route('contact.store'), [
            'name' => 'Jorge Test',
            'email' => 'jorge@example.com',
            'phone' => '+52 999 123 4567',
            'subject' => 'Reserva',
            'message' => 'Me gustaría reservar una habitación para dos noches.',
        ]);

        $response->assertRedirect(route('contact.thank-you'));

        $this->assertDatabaseHas('contact_leads', [
            'email' => 'jorge@example.com',
            'subject' => 'Reserva',
        ]);
    }

    public function test_contact_form_validation_rejects_invalid_payload(): void
    {
        $this->from(route('contact'))
            ->post(route('contact.store'), [
                'name' => '',
                'email' => 'not-an-email',
                'phone' => '',
                'subject' => '',
                'message' => 'corto',
            ])
            ->assertRedirect(route('contact'))
            ->assertSessionHasErrors(['name', 'email', 'phone', 'subject', 'message']);

        $this->assertSame(0, ContactLead::query()->count());
    }

    public function test_thank_you_page_renders(): void
    {
        $this->get(route('contact.thank-you'))
            ->assertOk()
            ->assertSee(__('contact.thank_you.title'), false);
    }
}
