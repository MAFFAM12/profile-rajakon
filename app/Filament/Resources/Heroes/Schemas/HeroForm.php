<?php

namespace App\Filament\Resources\Heroes\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class HeroForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('heading')
                    ->label('Judul')
                    ->required(),
                Textarea::make('sub_heading')
                    ->label('Sub Judul'),
                TextInput::make('cta_link')
                    ->label('CTA Link'),
                TextInput::make('cta_label')
                    ->label('CTA Label'),
                Select::make('image_type')
                    ->label('Tipe Input Gambar')
                    ->options([
                        'upload' => 'Upload File',
                        'url' => 'Embed URL',
                    ])
                    ->default('upload')
                    ->reactive(),
                Toggle::make('status')
                    ->label('Active')
                    ->default(true),
                FileUpload::make('image_upload')
                    ->disk('public')
                    ->directory('main-hero')
                    ->acceptedFileTypes(['image/jpg', 'image/jpeg', 'image/png', 'image/webp'])
                    ->maxSize(51200) // 50MB
                    ->downloadable()
                    ->columnSpanFull()
                    ->label('Upload Gambar')
                    ->visible(fn($get) => $get('image_type') === 'upload'),
                TextInput::make('image_url')
                    ->label('URL Gambar')
                    ->placeholder('https://www.something.com/embed/xyz')
                    ->url()
                    ->columnSpanFull()
                    ->prefixIcon(Heroicon::Link)
                    ->visible(fn($get) => $get('image_type') === 'url'),
            ]);
    }
}
