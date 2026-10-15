<?php

namespace App\Filament\Resources\VenueInquiries\Tables;

use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class VenueInquiriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable(['first_name', 'last_name'])
                    ->sortable(['first_name']),
                TextColumn::make('email')
                    ->label('Correo')
                    ->searchable(),
                TextColumn::make('event_date')
                    ->label('Fecha del evento')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('event_type')
                    ->label('Tipo')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Recibido')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([]);
    }
}
