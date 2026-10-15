<?php

namespace App\Filament\Resources\MejoradaRooms\Pages;

use App\Filament\Resources\MejoradaRooms\MejoradaRoomResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMejoradaRoom extends EditRecord
{
    protected static string $resource = MejoradaRoomResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
