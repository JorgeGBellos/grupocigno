<?php

namespace App\Http\Controllers;

use App\Enums\CmsPageSlug;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;

class ErmitaRoomController extends Controller
{
    public function show(string $slug): View
    {
        $cms = cms(CmsPageSlug::ErmitaRooms);
        $rooms = $cms->ermitaRooms();
        $room = collect($rooms)->firstWhere('slug', $slug);

        abort_unless(is_array($room), 404);

        return view('ermita.room-show', [
            'cms' => $cms,
            'room' => $room,
            'sharedAmenities' => Arr::wrap(__('ermita.rooms_page.shared_amenities')),
            'offers' => Arr::wrap($room['offers'] ?? __('ermita.rooms_page.offers')),
        ]);
    }
}
