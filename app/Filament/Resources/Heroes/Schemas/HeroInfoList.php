<?php

namespace App\Filament\Resources\Heroes\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\TextSize;
use Filament\Tables\Table;

class HeroInfoList
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Konten Hero')
                    ->schema([
                        TextEntry::make('heading')
                            ->label('Judul Utama')
                            ->columnSpanFull()
                            ->size(TextSize::Large)
                            ->weight(FontWeight::Bold),
                        TextEntry::make('sub_heading')
                            ->label('Sub Judul')
                            ->columnSpanFull()
                            ->size(TextSize::Medium),
                        TextEntry::make('cta_label')
                            ->label('Label Tombol CTA')
                            ->icon('heroicon-m-cursor-arrow-rays'),
                        TextEntry::make('cta_link')
                            ->label('Link Tombol CTA')
                            ->icon('heroicon-m-link')
                            ->copyable()
                            ->copyMessage('Link berhasil disalin')
                            ->copyMessageDuration(1500),
                    ])
                    ->columns(2),

                Section::make('Media & Status')
                    ->schema([
                        IconEntry::make('status')
                            ->label('Status Aktif')
                            ->boolean()
                            ->trueIcon('heroicon-o-check-circle')
                            ->falseIcon('heroicon-o-x-circle')
                            ->trueColor('success')
                            ->falseColor('danger'),
                        ImageEntry::make('hero_image')
                            ->label('Gambar Hero')
                            ->disk('public')
                            ->width(300)
                            ->height(200),
                        TextEntry::make('images_display_type')
                            ->label('Tipe Tampilan Gambar')
                            ->badge()
                            ->color('primary')
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'slide' => 'Slide Show',
                                'card' => 'Card Grid',
                            }),
                    ])
                    ->columns(3),

                Section::make('Informasi Sistem')
                    ->schema([
                        TextEntry::make('creator.name')
                            ->label('Dibuat Oleh')
                            ->icon('heroicon-m-user-plus')
                            ->placeholder('Tidak diketahui'),
                        TextEntry::make('updater.name')
                            ->label('Terakhir Diubah Oleh')
                            ->icon('heroicon-m-user')
                            ->placeholder('Belum pernah diubah'),
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
}
