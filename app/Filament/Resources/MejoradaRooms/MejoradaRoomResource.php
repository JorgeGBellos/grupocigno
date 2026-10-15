<?php

namespace App\Filament\Resources\MejoradaRooms;

use App\Filament\Resources\MejoradaRooms\Pages\CreateMejoradaRoom;
use App\Filament\Resources\MejoradaRooms\Pages\EditMejoradaRoom;
use App\Filament\Resources\MejoradaRooms\Pages\ListMejoradaRooms;
use App\Filament\Resources\MejoradaRooms\Schemas\MejoradaRoomForm;
use App\Filament\Resources\MejoradaRooms\Tables\MejoradaRoomsTable;
use App\Models\MejoradaRoom;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MejoradaRoomResource extends Resource
{
    protected static ?string $model = MejoradaRoom::class;

    protected static ?string $navigationLabel = 'Habitaciones Mejorada';

    protected static ?string $modelLabel = 'habitación';

    protected static ?string $pluralModelLabel = 'Habitaciones Mejorada';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHomeModern;

    protected static string|\UnitEnum|null $navigationGroup = 'Cigno Mejorada';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'title.es';

    public static function form(Schema $schema): Schema
    {
        return MejoradaRoomForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MejoradaRoomsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMejoradaRooms::route('/'),
            'create' => CreateMejoradaRoom::route('/create'),
            'edit' => EditMejoradaRoom::route('/{record}/edit'),
        ];
    }
}
