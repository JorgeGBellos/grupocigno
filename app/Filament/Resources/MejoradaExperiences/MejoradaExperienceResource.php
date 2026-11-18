<?php

namespace App\Filament\Resources\MejoradaExperiences;

use App\Filament\Resources\MejoradaExperiences\Pages\CreateMejoradaExperience;
use App\Filament\Resources\MejoradaExperiences\Pages\EditMejoradaExperience;
use App\Filament\Resources\MejoradaExperiences\Pages\ListMejoradaExperiences;
use App\Filament\Resources\MejoradaExperiences\Schemas\MejoradaExperienceForm;
use App\Filament\Resources\MejoradaExperiences\Tables\MejoradaExperiencesTable;
use App\Models\MejoradaExperience;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MejoradaExperienceResource extends Resource
{
    protected static ?string $model = MejoradaExperience::class;

    protected static ?string $navigationLabel = 'Experiencias Mejorada';

    protected static ?string $modelLabel = 'experiencia';

    protected static ?string $pluralModelLabel = 'Experiencias Mejorada';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSparkles;

    protected static string|\UnitEnum|null $navigationGroup = 'Mejorada';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'title.es';

    public static function form(Schema $schema): Schema
    {
        return MejoradaExperienceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MejoradaExperiencesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMejoradaExperiences::route('/'),
            'create' => CreateMejoradaExperience::route('/create'),
            'edit' => EditMejoradaExperience::route('/{record}/edit'),
        ];
    }
}