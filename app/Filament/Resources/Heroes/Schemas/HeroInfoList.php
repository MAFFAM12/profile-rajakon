<?php

namespace App\Filament\Resources\Heroes\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class HeroInfoList
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Infolists\Components\Section::make('Konten Hero')
                    ->schema([
                        \Filament\Infolists\Components\TextEntry::make('heading')
                            ->label('Judul Utama')
                            ->columnSpanFull()
                            ->size(\Filament\Support\Enums\FontSize::Large)
                            ->weight(\Filament\Support\Enums\FontWeight::Bold),
                        \Filament\Infolists\Components\TextEntry::make('sub_heading')
                            ->label('Sub Judul')
                            ->columnSpanFull()
                            ->size(\Filament\Support\Enums\FontSize::Medium),
                        \Filament\Infolists\Components\TextEntry::make('cta_label')
                            ->label('Label Tombol CTA')
                            ->icon('heroicon-m-cursor-arrow-rays'),
                        \Filament\Infolists\Components\TextEntry::make('cta_link')
                            ->label('Link Tombol CTA')
                            ->icon('heroicon-m-link')
                            ->copyable()
                            ->copyMessage('Link berhasil disalin')
                            ->copyMessageDuration(1500),
                    ])
                    ->columns(2),

                \Filament\Infolists\Components\Section::make('Media & Status')
                    ->schema([
                        \Filament\Infolists\Components\IconEntry::make('status')
                            ->label('Status Aktif')
                            ->boolean()
                            ->trueIcon('heroicon-o-check-circle')
                            ->falseIcon('heroicon-o-x-circle')
                            ->trueColor('success')
                            ->falseColor('danger'),
                        \Filament\Infolists\Components\ImageEntry::make('hero_image')
                            ->label('Gambar Hero')
                            ->disk('public')
                            ->width(300)
                            ->height(200),
                        \Filament\Infolists\Components\TextEntry::make('images_display_type')
                            ->label('Tipe Tampilan Gambar')
                            ->badge()
                            ->color('primary')
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'slide' => 'Slide Show',
                                'card' => 'Card Grid',
                            }),
                    ])
                    ->columns(3),

                \Filament\Infolists\Components\Section::make('Informasi Sistem')
                    ->schema([
                        \Filament\Infolists\Components\TextEntry::make('creator.name')
                            ->label('Dibuat Oleh')
                            ->icon('heroicon-m-user-plus')
                            ->placeholder('Tidak diketahui'),
                        \Filament\Infolists\Components\TextEntry::make('updater.name')
                            ->label('Terakhir Diubah Oleh')
                            ->icon('heroicon-m-user')
                            ->placeholder('Belum pernah diubah'),
                        \Filament\Infolists\Components\TextEntry::make('created_at')
                            ->label('Tanggal Dibuat')
                            ->dateTime('d F Y, H:i')
                            ->icon('heroicon-m-calendar-days'),
                        \Filament\Infolists\Components\TextEntry::make('updated_at')
                            ->label('Terakhir Diubah')
                            ->dateTime('d F Y, H:i')
                            ->icon('heroicon-m-clock'),
                    ])
                    ->columns(2)
                    ->collapsed(),
            ]);
    }
}
