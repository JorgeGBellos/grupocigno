<?php

namespace App\Filament\Resources\ErmitaExperiences\Pages;

use App\Filament\Resources\ErmitaExperiences\ErmitaExperienceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListErmitaExperiences extends ListRecords
{
    protected static string $resource = ErmitaExperienceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
