<?php

namespace App\Filament\Resources\Heroes\Schemas;

use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class HeroTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('no')
                    ->rowIndex(),
                TextColumn::make('heading')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('sub_heading')
                    ->limit(30),
                TextColumn::make('cta_label')
                    ->label('CTA label'),
                TextColumn::make('cta_link')
                    ->label('CTA link'),
                IconColumn::make('status')
                    ->boolean(),
                TextColumn::make('creator.name')
                    ->label('Dibuat oleh'),
                TextColumn::make('updater.name')
                    ->label('Diubah oleh'),
                TextColumn::make('created_at')
                    ->dateTime(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        true => 'Aktif',
                        false => 'Non Aktif',
                    ])
                    ->native(false)
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ]);
    }
}
