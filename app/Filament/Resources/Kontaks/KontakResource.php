<?php

namespace App\Filament\Resources\Kontaks;

use App\Models\Kontak;
use BackedEnum;
use Filament\Actions;
use Filament\Forms;
use Filament\Infolists;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class KontakResource extends Resource
{
    protected static ?string $model = Kontak::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUser;

    protected static ?string $recordTitleAttribute = 'nama';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                // 
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Kontak')
                    ->schema([
                        Infolists\Components\TextEntry::make('id')
                            ->label('ID Kontak')
                            ->copyable()
                            ->copyMessage('ID berhasil disalin')
                            ->copyMessageDuration(1500),
                        Infolists\Components\TextEntry::make('nama')
                            ->label('Nama Lengkap')
                            ->icon('heroicon-m-user'),
                        Infolists\Components\TextEntry::make('email')
                            ->label('Alamat Email')
                            ->icon('heroicon-m-envelope')
                            ->copyable()
                            ->copyMessage('Email berhasil disalin')
                            ->copyMessageDuration(1500),
                        Infolists\Components\TextEntry::make('perusahaan')
                            ->label('Nama Perusahaan')
                            ->icon('heroicon-m-building-office')
                            ->placeholder('Tidak ada perusahaan'),
                        Infolists\Components\TextEntry::make('telepon')
                            ->label('Nomor Telepon')
                            ->icon('heroicon-m-phone')
                            ->copyable()
                            ->copyMessage('Nomor telepon berhasil disalin')
                            ->copyMessageDuration(1500),
                    ])
                    ->columns(2),

                Section::make('Detail Permintaan')
                    ->schema([
                        Infolists\Components\TextEntry::make('layanan_minat')
                            ->label('Layanan yang Diminati')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'construction' => 'success',
                                'mechanical' => 'warning',
                                'electrical' => 'info',
                                'safety' => 'danger',
                                'maintenance' => 'gray',
                                'logistics' => 'primary',
                                'other' => 'secondary',
                            })
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'construction' => 'Konstruksi',
                                'mechanical' => 'Mekanikal',
                                'electrical' => 'Listrik',
                                'safety' => 'Keselamatan',
                                'maintenance' => 'Pemeliharaan',
                                'logistics' => 'Logistik',
                                'other' => 'Lainnya',
                            }),
                        Infolists\Components\TextEntry::make('pesan')
                            ->label('Pesan')
                            ->columnSpanFull()
                            ->formatStateUsing(fn (string $state): string => nl2br(e($state)))
                            ->html(),
                    ]),

                Section::make('Informasi Sistem')
                    ->schema([
                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Tanggal Dibuat')
                            ->dateTime('d F Y, H:i')
                            ->icon('heroicon-m-calendar'),
                        Infolists\Components\TextEntry::make('updated_at')
                            ->label('Terakhir Diubah')
                            ->dateTime('d F Y, H:i')
                            ->icon('heroicon-m-clock'),
                    ])
                    ->columns(2)
                    ->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nama')
            ->columns([
                Tables\Columns\TextColumn::make('no')
                    ->label('No')
                    ->rowIndex(),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('perusahaan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('telepon')
                    ->searchable(),
                Tables\Columns\TextColumn::make('layanan_minat'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Actions\ViewAction::make(),
                // Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->toolbarActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKontaks::route('/'),
            'create' => Pages\CreateKontak::route('/create'),
            'view' => Pages\ViewKontak::route('/{record}'),
            'edit' => Pages\EditKontak::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }
}
