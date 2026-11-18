<?php

namespace App\Filament\Resources\MejoradaExperiences\Pages;

use App\Filament\Resources\MejoradaExperiences\MejoradaExperienceResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMejoradaExperience extends EditRecord
{
    protected static string $resource = MejoradaExperienceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}