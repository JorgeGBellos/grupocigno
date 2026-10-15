<?php

namespace App\Filament\Resources\ContactLeads;

use App\Filament\Resources\ContactLeads\Pages\ListContactLeads;
use App\Filament\Resources\ContactLeads\Pages\ViewContactLead;
use App\Filament\Resources\ContactLeads\Schemas\ContactLeadInfolist;
use App\Filament\Resources\ContactLeads\Tables\ContactLeadsTable;
use App\Models\ContactLead;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ContactLeadResource extends Resource
{
    protected static ?string $model = ContactLead::class;

    protected static ?string $navigationLabel = 'Leads de contacto';

    protected static ?string $modelLabel = 'lead';

    protected static ?string $pluralModelLabel = 'Leads de contacto';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedInbox;

    protected static string|\UnitEnum|null $navigationGroup = 'CMS';

    protected static ?int $navigationSort = 4;

    protected static ?string $recordTitleAttribute = 'name';

    public static function infolist(Schema $schema): Schema
    {
        return ContactLeadInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ContactLeadsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListContactLeads::route('/'),
            'view' => ViewContactLead::route('/{record}'),
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
