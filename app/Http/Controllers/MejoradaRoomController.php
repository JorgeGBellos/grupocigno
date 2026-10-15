<?php

namespace App\Http\Controllers;

use App\Enums\CmsPageSlug;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;

class MejoradaRoomController extends Controller
{
    public function show(string $slug): View
    {
        $cms = cms(CmsPageSlug::MejoradaRooms);
        $rooms = $cms->mejoradaRooms();
        $room = collect($rooms)->firstWhere('slug', $slug);

        abort_unless(is_array($room), 404);

        return view('mejorada.room-show', [
            'cms' => $cms,
            'room' => $room,
            'sharedAmenities' => Arr::wrap(__('mejorada.rooms_page.shared_amenities')),
            'offers' => Arr::wrap($room['offers'] ?? __('mejorada.rooms_page.offers')),
        ]);
    }
}
