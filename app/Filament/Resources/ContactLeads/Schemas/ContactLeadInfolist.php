<?php

namespace App\Filament\Resources\ContactLeads\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactLeadInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Lead')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('name')->label('Nombre'),
                        TextEntry::make('email')->label('Correo'),
                        TextEntry::make('phone')->label('Teléfono'),
                        TextEntry::make('subject')->label('Asunto'),
                        TextEntry::make('locale')->label('Idioma'),
                        TextEntry::make('created_at')->label('Recibido')->dateTime('d/m/Y H:i'),
                        TextEntry::make('message')
                            ->label('Mensaje')
                            ->columnSpanFull()
                            ->prose(),
                        TextEntry::make('ip_address')->label('IP')->placeholder('—'),
                        TextEntry::make('user_agent')
                            ->label('User agent')
                            ->columnSpanFull()
                            ->placeholder('—'),
                    ]),
            ]);
    }
}
