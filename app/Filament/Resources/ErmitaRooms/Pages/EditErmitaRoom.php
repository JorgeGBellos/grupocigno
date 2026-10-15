<?php

namespace App\Filament\Resources\ErmitaRooms\Pages;

use App\Filament\Resources\ErmitaRooms\ErmitaRoomResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditErmitaRoom extends EditRecord
{
    protected static string $resource = ErmitaRoomResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
