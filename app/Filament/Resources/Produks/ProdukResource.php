<?php

namespace App\Filament\Resources\Produks;

use App\Models\Produk;
use BackedEnum;
use Filament\Actions;
use Filament\Forms;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\TextSize;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

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

                        Forms\Components\RichEditor::make('deskripsi')
                            ->label('Deskripsi')
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
                            ->appendFiles()
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
                Section::make('Informasi Produk')
                    ->schema([
                        TextEntry::make('nama')
                            ->label('Nama Produk')
                            ->columnSpanFull()
                            ->size(TextSize::Large)
                            ->weight(FontWeight::Bold),
                        TextEntry::make('slug')
                            ->label('Slug URL')
                            ->copyable()
                            ->copyMessage('Slug berhasil disalin')
                            ->copyMessageDuration(1500),
                        TextEntry::make('badge')
                            ->label('Label Badge')
                            ->badge()
                            ->color('primary'),
                        TextEntry::make('harga')
                            ->label('Harga')
                            ->formatStateUsing(fn($state) => $state
                                ? 'Rp ' . number_format($state, 0, ',', '.')
                                : 'Harga belum ditentukan')
                            ->icon('heroicon-m-banknotes'),
                        IconEntry::make('is_active')
                            ->label('Status Tampil')
                            ->boolean()
                            ->trueIcon('heroicon-o-eye')
                            ->falseIcon('heroicon-o-eye-slash')
                            ->trueColor('success')
                            ->falseColor('danger'),
                        TextEntry::make('urutan')
                            ->label('Urutan Tampil')
                            ->icon('heroicon-m-bars-3'),
                    ])
                    ->columns(2),

                Section::make('Deskripsi & Manfaat')
                    ->schema([
                        TextEntry::make('deskripsi')
                            ->label('Deskripsi Produk')
                            ->columnSpanFull()
                            ->formatStateUsing(fn (string $state): string => $state)
                            ->html(),
                        RepeatableEntry::make('manfaat')
                            ->label('Manfaat Produk')
                            ->schema([
                                TextEntry::make('item')
                                    ->label('')
                                    ->icon('heroicon-m-check-circle')
                                    ->color('success'),
                            ])
                            ->columns(1)
                            ->columnSpanFull(),
                    ]),

                Section::make('Galeri Produk')
                    ->schema([
                        ImageEntry::make('gambar')
                            ->disk('public'),
                        // RepeatableEntry::make('gambar')
                        //     ->label('Foto Produk')
                        //     ->schema([])
                        //     ->columns(3)
                        //     ->columnSpanFull(),
                    ])
                    ->collapsible(),

                Section::make('Informasi Sistem')
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Tanggal Dibuat')
                            ->dateTime('d F Y, H:i')
                            ->icon('heroicon-m-calendar-days'),
                        TextEntry::make('updated_at')
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
                    ->getStateUsing(fn($record) => $record->gambar[0] ?? null)
                    ->disk('public'),

                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Produk')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('harga')
                    ->label('Harga')
                    ->formatStateUsing(fn($state) => $state
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
