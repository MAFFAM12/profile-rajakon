<?php

namespace App\Filament\Resources\Heroes\Schemas;

use App\Models\Hero;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

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
                Toggle::make('status')
                    ->label('Active')
                    ->default(true),
                FileUpload::make('images')
                    ->disk('public')
                    ->directory('hero-images')
                    ->acceptedFileTypes(['image/jpg', 'image/jpeg', 'image/png', 'image/webp'])
                    ->maxSize(51200) // 50MB
                    ->multiple()
                    ->reorderable()
                    ->appendFiles()
                    ->downloadable()
                    ->columnSpanFull()
                    ->label('Upload Gambar (Multiple)')
                    ->saveUploadedFileUsing(function (TemporaryUploadedFile $file): string {
                        return (new Hero())->uploadFile($file, 'hero-images');
                    }),
                Radio::make('images_display_type')
                    ->label('Tipe Tampilan Gambar Multiple')
                    ->options([
                        'slide' => 'Slide (Carousel)',
                        'card' => 'Card (Grid)',
                    ])
                    ->default('slide')
                    ->columnSpanFull()
                    ->descriptions([
                        'slide' => 'Gambar berganti otomatis seperti carousel',
                        'card' => 'Gambar ditampilkan dalam grid',
                    ]),
            ]);
    }
}
