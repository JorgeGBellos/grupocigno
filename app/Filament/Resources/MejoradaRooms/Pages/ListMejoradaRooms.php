<?php

namespace App\Filament\Resources\MejoradaRooms\Pages;

use App\Filament\Resources\MejoradaRooms\MejoradaRoomResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMejoradaRooms extends ListRecords
{
    protected static string $resource = MejoradaRoomResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
