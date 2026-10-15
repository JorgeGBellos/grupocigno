<?php

namespace App\Filament\Resources\ErmitaExperiences\Pages;

use App\Filament\Resources\ErmitaExperiences\ErmitaExperienceResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditErmitaExperience extends EditRecord
{
    protected static string $resource = ErmitaExperienceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
