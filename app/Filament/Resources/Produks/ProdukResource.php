<?php

namespace App\Filament\Resources\Produks;

use App\Models\Produk;
use BackedEnum;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Infolists;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;

class ProdukResource extends Resource
{
    protected static ?string $model = Produk::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShoppingBag;

    protected static ?string $navigationLabel = 'Produk';

    protected static ?string $modelLabel = 'Produk';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Informasi Produk')
                    ->schema([
                        Forms\Components\TextInput::make('nama')
                            ->label('Nama Produk')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, $set, $record) {
                                if (!$record) {
                                    $set('slug', Str::slug($state));
                                }
                            }),

                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->helperText('URL produk. Contoh: ema-gt'),

                        Forms\Components\TextInput::make('badge')
                            ->label('Badge Label')
                            ->default('Produk'),

                        Forms\Components\TextInput::make('harga')
                            ->label('Harga')
                            ->numeric()
                            ->prefix('Rp')
                            ->nullable(),

                        Forms\Components\TextInput::make('urutan')
                            ->label('Urutan Tampil')
                            ->numeric()
                            ->default(0),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Tampilkan di Website')
                            ->default(true),

                        Forms\Components\Textarea::make('deskripsi')
                            ->label('Deskripsi')
                            ->rows(5)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Manfaat Produk')
                    ->schema([
                        Forms\Components\Repeater::make('manfaat')
                            ->label('')
                            ->schema([
                                Forms\Components\TextInput::make('item')
                                    ->label('Poin Manfaat')
                                    ->required()
                                    ->placeholder('Contoh: Membantu menghemat konsumsi bahan bakar'),
                            ])
                            ->addActionLabel('+ Tambah Manfaat')
                            ->columnSpanFull()
                            ->defaultItems(0),
                    ]),

                Section::make('Foto Produk')
                    ->schema([
                        Forms\Components\FileUpload::make('gambar')
                            ->label('Upload Foto (bisa lebih dari 1)')
                            ->multiple()
                            ->reorderable()
                            ->image()
                            ->disk('public')
                            ->directory('produk')
                            ->columnSpanFull()
                            ->helperText('Foto pertama akan menjadi thumbnail di halaman utama'),
                    ]),
            ]);
    }
    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Infolists\Components\Section::make('Informasi Produk')
                    ->schema([
                        Infolists\Components\TextEntry::make('nama')
                            ->label('Nama Produk')
                            ->columnSpanFull()
                            ->size(\Filament\Support\Enums\FontSize::Large)
                            ->weight(\Filament\Support\Enums\FontWeight::Bold),
                        Infolists\Components\TextEntry::make('slug')
                            ->label('Slug URL')
                            ->copyable()
                            ->copyMessage('Slug berhasil disalin')
                            ->copyMessageDuration(1500),
                        Infolists\Components\TextEntry::make('badge')
                            ->label('Label Badge')
                            ->badge()
                            ->color('primary'),
                        Infolists\Components\TextEntry::make('harga')
                            ->label('Harga')
                            ->formatStateUsing(fn ($state) => $state
                                ? 'Rp ' . number_format($state, 0, ',', '.')
                                : 'Harga belum ditentukan')
                            ->icon('heroicon-m-banknotes'),
                        Infolists\Components\IconEntry::make('is_active')
                            ->label('Status Tampil')
                            ->boolean()
                            ->trueIcon('heroicon-o-eye')
                            ->falseIcon('heroicon-o-eye-slash')
                            ->trueColor('success')
                            ->falseColor('danger'),
                        Infolists\Components\TextEntry::make('urutan')
                            ->label('Urutan Tampil')
                            ->icon('heroicon-m-bars-3'),
                    ])
                    ->columns(2),

                Infolists\Components\Section::make('Deskripsi & Manfaat')
                    ->schema([
                        Infolists\Components\TextEntry::make('deskripsi')
                            ->label('Deskripsi Produk')
                            ->columnSpanFull()
                            ->formatStateUsing(fn (string $state): string => nl2br(e($state)))
                            ->html(),
                        Infolists\Components\RepeatableEntry::make('manfaat')
                            ->label('Manfaat Produk')
                            ->schema([
                                Infolists\Components\TextEntry::make('item')
                                    ->label('')
                                    ->icon('heroicon-m-check-circle')
                                    ->color('success'),
                            ])
                            ->columns(1)
                            ->columnSpanFull(),
                    ]),

                Infolists\Components\Section::make('Galeri Produk')
                    ->schema([
                        Infolists\Components\RepeatableEntry::make('gambar')
                            ->label('Foto Produk')
                            ->schema([
                                ImageEntry::make('')
                                    ->disk('public')
                                    ->width(200)
                                    ->height(150),
                            ])
                            ->columns(3)
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),

                Infolists\Components\Section::make('Informasi Sistem')
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
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('no')
                    ->rowIndex(),
                Tables\Columns\ImageColumn::make('gambar')
                    ->label('Foto')
                    ->getStateUsing(fn ($record) => $record->gambar[0] ?? null)
                    ->disk('public'),

                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Produk')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('harga')
                    ->label('Harga')
                    ->formatStateUsing(fn ($state) => $state
                        ? 'Rp ' . number_format($state, 0, ',', '.')
                        : '-')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),

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
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Tampil'),
            ])
            ->recordActions([
                Actions\ViewAction::make(),
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->toolbarActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('urutan');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListProduks::route('/'),
            'create' => Pages\CreateProduk::route('/create'),
            'view'   => Pages\ViewProduk::route('/{record}'),
            'edit'   => Pages\EditProduk::route('/{record}/edit'),
        ];
    }
}