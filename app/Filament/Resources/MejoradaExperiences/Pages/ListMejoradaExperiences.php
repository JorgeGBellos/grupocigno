<?php

namespace App\Filament\Resources\MejoradaExperiences\Pages;

use App\Filament\Resources\MejoradaExperiences\MejoradaExperienceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMejoradaExperiences extends ListRecords
{
    protected static string $resource = MejoradaExperienceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}