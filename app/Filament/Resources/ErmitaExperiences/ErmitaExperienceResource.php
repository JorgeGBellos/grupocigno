<?php

namespace App\Filament\Resources\ErmitaExperiences;

use App\Filament\Resources\ErmitaExperiences\Pages\CreateErmitaExperience;
use App\Filament\Resources\ErmitaExperiences\Pages\EditErmitaExperience;
use App\Filament\Resources\ErmitaExperiences\Pages\ListErmitaExperiences;
use App\Filament\Resources\ErmitaExperiences\Schemas\ErmitaExperienceForm;
use App\Filament\Resources\ErmitaExperiences\Tables\ErmitaExperiencesTable;
use App\Models\ErmitaExperience;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ErmitaExperienceResource extends Resource
{
    protected static ?string $model = ErmitaExperience::class;

    protected static ?string $navigationLabel = 'Experiencias Ermita';

    protected static ?string $modelLabel = 'experiencia';

    protected static ?string $pluralModelLabel = 'Experiencias Ermita';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSparkles;

    protected static string|\UnitEnum|null $navigationGroup = 'Cigno Ermita';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'title.es';

    public static function form(Schema $schema): Schema
    {
        return ErmitaExperienceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ErmitaExperiencesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListErmitaExperiences::route('/'),
            'create' => CreateErmitaExperience::route('/create'),
            'edit' => EditErmitaExperience::route('/{record}/edit'),
        ];
    }
}
