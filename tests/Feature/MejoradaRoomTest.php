<?php

namespace Tests\Feature;

use App\Filament\Resources\MejoradaRooms\MejoradaRoomResource;
use App\Models\MejoradaRoom;
use App\Models\User;
use Database\Seeders\MejoradaRoomSeeder;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MejoradaRoomTest extends TestCase
{
    use RefreshDatabase;

    public function test_mejorada_rooms_fallback_to_lang_when_database_is_empty(): void
    {
        $rooms = cms('cigno-mejorada')->mejoradaRooms();

        $this->assertNotEmpty($rooms);
        $this->assertSame('classic-room-king', $rooms[0]['slug']);
    }

    public function test_mejorada_rooms_can_be_retrieved_from_database(): void
    {
        MejoradaRoom::query()->create([
            'slug' => 'suite-presidencial-test',
            'sort_order' => 1,
            'is_published' => true,
            'people' => 2,
            'beds' => 1,
            'exclusive' => ['Alberca privada'],
            'image' => 'images/home/ermita.png',
            'title' => ['es' => 'Suite Presidencial Test', 'en' => 'Presidential Suite Test'],
            'body' => ['es' => 'Descripción prueba', 'en' => 'Test description'],
            'detail' => ['es' => 'Detalle prueba', 'en' => 'Test detail'],
            'price' => ['es' => 'Desde $500', 'en' => 'From $500'],
            'size' => ['es' => '80 m²', 'en' => '80 sqm'],
        ]);

        $rooms = cms('cigno-mejorada')->mejoradaRooms();

        $this->assertCount(1, $rooms);
        $this->assertSame('suite-presidencial-test', $rooms[0]['slug']);
        $this->assertSame('Suite Presidencial Test', $rooms[0]['title']);

        $teasers = cms('cigno-mejorada')->mejoradaRoomTeasers();
        $this->assertCount(1, $teasers);
        $this->assertSame('Suite Presidencial Test', $teasers[0]['title']);
    }

    public function test_room_show_page_shows_coming_soon_while_property_is_hidden(): void
    {
        MejoradaRoom::query()->create([
            'slug' => 'custom-room-test',
            'sort_order' => 1,
            'is_published' => true,
            'people' => 3,
            'beds' => 2,
            'exclusive' => ['Balcón privado'],
            'image' => 'images/home/ermita.png',
            'title' => ['es' => 'Habitación Personalizada Especial', 'en' => 'Custom Special Room'],
            'body' => ['es' => 'Cuerpo prueba', 'en' => 'Body test'],
            'detail' => ['es' => 'Detalle largo prueba', 'en' => 'Long detail test'],
            'price' => ['es' => 'Desde $350', 'en' => 'From $350'],
            'size' => ['es' => '45 m²', 'en' => '45 sqm'],
        ]);

        $this->get(route('cigno-mejorada.rooms.show', 'custom-room-test'))
            ->assertOk()
            ->assertSee(__('pages.coming_soon.eyebrow'), false)
            ->assertDontSee('Habitación Personalizada Especial', false);
    }

    public function test_mejorada_room_seeder_populates_rooms(): void
    {
        $this->seed(MejoradaRoomSeeder::class);

        $this->assertDatabaseHas('mejorada_rooms', [
            'slug' => 'classic-room-king',
            'is_published' => true,
        ]);

        $this->assertDatabaseHas('mejorada_rooms', [
            'slug' => 'villa-deluxe-bathtub',
            'is_published' => true,
        ]);

        $this->assertSame(10, MejoradaRoom::query()->count());
    }

    public function test_mejorada_room_admin_resource_is_accessible_to_authenticated_user(): void
    {
        Filament::setCurrentPanel('admin');

        $user = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);

        $this->actingAs($user)
            ->get(MejoradaRoomResource::getUrl('index'))
            ->assertOk();
    }
}
