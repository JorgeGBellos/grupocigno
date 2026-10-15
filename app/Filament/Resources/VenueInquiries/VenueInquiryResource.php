<?php

namespace App\Filament\Resources\VenueInquiries;

use App\Filament\Resources\VenueInquiries\Pages\ListVenueInquiries;
use App\Filament\Resources\VenueInquiries\Pages\ViewVenueInquiry;
use App\Filament\Resources\VenueInquiries\Schemas\VenueInquiryInfolist;
use App\Filament\Resources\VenueInquiries\Tables\VenueInquiriesTable;
use App\Models\VenueInquiry;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class VenueInquiryResource extends Resource
{
    protected static ?string $model = VenueInquiry::class;

    protected static ?string $navigationLabel = 'Consultas Venue';

    protected static ?string $modelLabel = 'consulta';

    protected static ?string $pluralModelLabel = 'Consultas Venue';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static string|\UnitEnum|null $navigationGroup = 'Cigno Ermita';

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'name';

    public static function infolist(Schema $schema): Schema
    {
        return VenueInquiryInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VenueInquiriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListVenueInquiries::route('/'),
            'view' => ViewVenueInquiry::route('/{record}'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }
}
