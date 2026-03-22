<?php

namespace App\Filament\Resources\WebsiteSettings;

use App\Models\WebsiteSetting;
use BackedEnum;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class WebsiteSettingResource extends Resource
{
    protected static ?string $model = WebsiteSetting::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::AdjustmentsHorizontal;

    protected static ?string $recordTitleAttribute = 'company_name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Perusahaan')
                    ->schema([
                        TextInput::make('company_name')
                            ->label('Nama Perusahaan')
                            ->required()
                            ->maxLength(255),

                        Textarea::make('company_description')
                            ->label('Deskripsi Perusahaan')
                            ->rows(4)
                            ->columnSpanFull(),

                        FileUpload::make('logo')
                            ->label('Logo Perusahaan')
                            ->image()
                            ->disk('public')
                            ->directory('logos')
                            ->imageEditor()
                            ->maxSize(2048),
                    ])
                    ->columns(2),

                Section::make('Informasi Kontak')
                    ->schema([
                        TextInput::make('phone')
                            ->label('Nomor Telepon')
                            ->tel()
                            ->maxLength(255),

                        TextInput::make('email')
                            ->label('Alamat Email')
                            ->email()
                            ->maxLength(255),

                        Textarea::make('address')
                            ->label('Alamat Lengkap')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Media Sosial')
                    ->schema([
                        Repeater::make('social_media')
                            ->label('Platform Media Sosial')
                            ->schema([
                                TextInput::make('platform')
                                    ->label('Platform')
                                    ->placeholder('Contoh: Facebook, Instagram, LinkedIn')
                                    ->required(),
                                TextInput::make('url')
                                    ->label('URL')
                                    ->url()
                                    ->placeholder('https://...')
                                    ->required(),
                                TextInput::make('username')
                                    ->label('Username/Handle')
                                    ->placeholder('@username atau nama akun'),
                            ])
                            ->addActionLabel('+ Tambah Media Sosial')
                            ->columns(3)
                            ->columnSpanFull()
                            ->defaultItems(0),
                    ]),

                Section::make('Status')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('company_name')
            ->columns([
                ImageColumn::make('logo')
                    ->label('Logo')
                    ->disk('public')
                    ->width(60)
                    ->height(60)
                    ->circular(),

                TextColumn::make('company_name')
                    ->label('Nama Perusahaan')
                    ->searchable()
                    ->sortable()
                    ->limit(30),

                TextColumn::make('phone')
                    ->label('Telepon')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Nomor telepon berhasil disalin'),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Email berhasil disalin'),

                TextColumn::make('address')
                    ->label('Alamat')
                    ->limit(50)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 50) {
                            return null;
                        }
                        return $state;
                    }),

                TextColumn::make('social_media_count')
                    ->label('Media Sosial')
                    ->getStateUsing(function ($record) {
                        return is_array($record->social_media) ? count($record->social_media) : 0;
                    })
                    ->badge()
                    ->color('primary'),

                IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Diubah')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status'),
            ])
            ->recordActions([
                Actions\ViewAction::make(),
                Actions\EditAction::make(),
            ])
            ->toolbarActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Infolists\Components\Section::make('Informasi Perusahaan')
                    ->schema([
                        Infolists\Components\TextEntry::make('company_name')
                            ->label('Nama Perusahaan')
                            ->columnSpanFull()
                            ->size(\Filament\Support\Enums\FontSize::Large)
                            ->weight(\Filament\Support\Enums\FontWeight::Bold),

                        Infolists\Components\TextEntry::make('company_description')
                            ->label('Deskripsi Perusahaan')
                            ->columnSpanFull()
                            ->formatStateUsing(fn (string $state): string => nl2br(e($state)))
                            ->html(),

                        Infolists\Components\ImageEntry::make('logo')
                            ->label('Logo Perusahaan')
                            ->disk('public')
                            ->width(200)
                            ->height(100),
                    ])
                    ->columns(2),

                Infolists\Components\Section::make('Informasi Kontak')
                    ->schema([
                        Infolists\Components\TextEntry::make('phone')
                            ->label('Nomor Telepon')
                            ->icon('heroicon-m-phone')
                            ->copyable()
                            ->copyMessage('Nomor telepon berhasil disalin')
                            ->copyMessageDuration(1500),

                        Infolists\Components\TextEntry::make('email')
                            ->label('Alamat Email')
                            ->icon('heroicon-m-envelope')
                            ->copyable()
                            ->copyMessage('Email berhasil disalin')
                            ->copyMessageDuration(1500),

                        Infolists\Components\TextEntry::make('address')
                            ->label('Alamat Lengkap')
                            ->columnSpanFull()
                            ->formatStateUsing(fn (string $state): string => nl2br(e($state)))
                            ->html(),
                    ])
                    ->columns(2),

                Infolists\Components\Section::make('Media Sosial')
                    ->schema([
                        Infolists\Components\RepeatableEntry::make('social_media')
                            ->label('Platform Media Sosial')
                            ->schema([
                                Infolists\Components\TextEntry::make('platform')
                                    ->label('Platform')
                                    ->badge()
                                    ->color('primary'),
                                Infolists\Components\TextEntry::make('url')
                                    ->label('URL')
                                    ->copyable()
                                    ->copyMessage('URL berhasil disalin')
                                    ->copyMessageDuration(1500),
                                Infolists\Components\TextEntry::make('username')
                                    ->label('Username')
                                    ->placeholder('Tidak ada username'),
                            ])
                            ->columns(3)
                            ->columnSpanFull(),
                    ]),

                Infolists\Components\Section::make('Status & Sistem')
                    ->schema([
                        Infolists\Components\IconEntry::make('is_active')
                            ->label('Status Aktif')
                            ->boolean()
                            ->trueIcon('heroicon-o-check-circle')
                            ->falseIcon('heroicon-o-x-circle')
                            ->trueColor('success')
                            ->falseColor('danger'),

                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Tanggal Dibuat')
                            ->dateTime('d F Y, H:i')
                            ->icon('heroicon-m-calendar-days'),

                        Infolists\Components\TextEntry::make('updated_at')
                            ->label('Terakhir Diubah')
                            ->dateTime('d F Y, H:i')
                            ->icon('heroicon-m-clock'),
                    ])
                    ->columns(3)
                    ->collapsed(),
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
            'index' => Pages\ListWebsiteSettings::route('/'),
            'create' => Pages\CreateWebsiteSetting::route('/create'),
            'view' => Pages\ViewWebsiteSetting::route('/{record}'),
            'edit' => Pages\EditWebsiteSetting::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return WebsiteSetting::count() === 0;
    }
}
