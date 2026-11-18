<?php

namespace App\Filament\Resources\VenueInquiries\Tables;

use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class VenueInquiriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('hotel')
                    ->label('Hotel')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'cigno-mejorada' => 'Mejorada',
                        'cigno-ermita' => 'Ermita',
                        default => $state ?: '—',
                    })
                    ->color(fn (?string $state): string => match ($state) {
                        'cigno-mejorada' => 'success',
                        'cigno-ermita' => 'info',
                        default => 'gray',
                    })
                    ->sortable()
                    ->searchable(),
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
            ->filters([
                SelectFilter::make('hotel')
                    ->label('Hotel')
                    ->options([
                        'cigno-ermita' => 'Ermita',
                        'cigno-mejorada' => 'Mejorada',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([]);
    }
}
