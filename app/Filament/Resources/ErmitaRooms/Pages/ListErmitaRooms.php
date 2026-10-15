<?php

namespace App\Filament\Resources\ErmitaRooms\Pages;

use App\Filament\Resources\ErmitaRooms\ErmitaRoomResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListErmitaRooms extends ListRecords
{
    protected static string $resource = ErmitaRoomResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
