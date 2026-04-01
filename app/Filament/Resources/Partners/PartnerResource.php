<?php

namespace App\Filament\Resources\Partners;

use App\Filament\Resources\Partners\Pages;
use App\Models\Partner;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Infolists;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Support\Enums\TextSize;
use Filament\Tables\Filters\TernaryFilter;

class PartnerResource extends Resource
{
    protected static ?string $model = Partner::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $label = 'Klien';

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nama Partner')
                    ->required()
                    ->maxLength(255),
                FileUpload::make('logo')
                    ->label('Logo')
                    ->image()
                    ->required()
                    ->disk('public')
                    ->directory('partners')
                    ->imageEditor()
                    ->maxSize(2048),
                TextInput::make('order')
                    ->label('Urutan')
                    ->numeric()
                    ->default(0),
                Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('no')
                    ->rowIndex(),
                ImageColumn::make('logo')
                    ->label('Logo')
                    ->disk('public')
                    ->square(),
                TextColumn::make('name')
                    ->label('Nama Partner')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('order')
                    ->label('Urutan')
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            // ->defaultSort('order')  ← HAPUS/KOMEN BARIS INI
            ->filters([
                TernaryFilter::make('is_active')
                    ->label('Status Tampil'),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Partner')
                    ->schema([
                        Infolists\Components\TextEntry::make('name')
                            ->label('Nama Partner')
                            ->columnSpanFull()
                            ->size(TextSize::Large)
                            ->weight(\Filament\Support\Enums\FontWeight::Bold),
                        Infolists\Components\TextEntry::make('order')
                            ->label('Urutan Tampil')
                            ->icon('heroicon-m-bars-3'),
                        Infolists\Components\IconEntry::make('is_active')
                            ->label('Status Aktif')
                            ->boolean()
                            ->trueIcon('heroicon-o-eye')
                            ->falseIcon('heroicon-o-eye-slash')
                            ->trueColor('success')
                            ->falseColor('danger'),
                    ])
                    ->columns(2),

                Section::make('Logo Partner')
                    ->schema([
                        ImageEntry::make('logo')
                            ->label('Logo Partner')
                            ->disk('public')
                            ->width(200)
                            ->height(200),
                    ])
                    ->collapsible(),

                Section::make('Informasi Sistem')
                    ->schema([
                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Tanggal Dibuat')
                            ->dateTime('d F Y, H:i')
                            ->icon('heroicon-m-calendar-days'),
                        Infolists\Components\TextEntry::make('updated_at')
                            ->label('Terakhir Diubah')
                            ->dateTime('d F Y, H:i')
                            ->icon('heroicon-m-clock'),
                    ])
                    ->columns(2)
                    ->collapsed(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPartners::route('/'),
            'create' => Pages\CreatePartner::route('/create'),
            'view' => Pages\ViewPartner::route('/{record}'),
            'edit' => Pages\EditPartner::route('/{record}/edit'),
        ];
    }
}
