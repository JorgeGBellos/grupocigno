<?php

namespace App\Filament\Resources\VenueInquiries\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class VenueInquiryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Consulta de venue')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('name')->label('Nombre'),
                        TextEntry::make('email')->label('Correo'),
                        TextEntry::make('event_date')->label('Fecha del evento')->date('d/m/Y'),
                        TextEntry::make('event_type')->label('Tipo de evento'),
                        TextEntry::make('hotel')->label('Hotel'),
                        TextEntry::make('locale')->label('Idioma'),
                        TextEntry::make('created_at')->label('Recibido')->dateTime('d/m/Y H:i'),
                        TextEntry::make('additional_information')
                            ->label('Información adicional')
                            ->columnSpanFull()
                            ->prose()
                            ->placeholder('—'),
                        TextEntry::make('ip_address')->label('IP')->placeholder('—'),
                        TextEntry::make('user_agent')
                            ->label('User agent')
                            ->columnSpanFull()
                            ->placeholder('—'),
                    ]),
            ]);
    }
}
