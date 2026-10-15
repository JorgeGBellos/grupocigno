<?php

namespace App\Filament\Resources\ErmitaRooms;

use App\Filament\Resources\ErmitaRooms\Pages\CreateErmitaRoom;
use App\Filament\Resources\ErmitaRooms\Pages\EditErmitaRoom;
use App\Filament\Resources\ErmitaRooms\Pages\ListErmitaRooms;
use App\Filament\Resources\ErmitaRooms\Schemas\ErmitaRoomForm;
use App\Filament\Resources\ErmitaRooms\Tables\ErmitaRoomsTable;
use App\Models\ErmitaRoom;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ErmitaRoomResource extends Resource
{
    protected static ?string $model = ErmitaRoom::class;

    protected static ?string $navigationLabel = 'Habitaciones Ermita';

    protected static ?string $modelLabel = 'habitación';

    protected static ?string $pluralModelLabel = 'Habitaciones Ermita';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHomeModern;

    protected static string|\UnitEnum|null $navigationGroup = 'Cigno Ermita';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'title.es';

    public static function form(Schema $schema): Schema
    {
        return ErmitaRoomForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ErmitaRoomsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListErmitaRooms::route('/'),
            'create' => CreateErmitaRoom::route('/create'),
            'edit' => EditErmitaRoom::route('/{record}/edit'),
        ];
    }
}
