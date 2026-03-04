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
                TextEntry::make('heading'),
                TextEntry::make('sub_heading'),
                TextEntry::make('cta_label')
                    ->label('CTA label'),
                TextEntry::make('cta_link')
                    ->label('CTA link'),
                IconEntry::make('status')
                    ->boolean(),
                ImageEntry::make('hero_image')
                    ->disk('public'),
                TextEntry::make('creator.name')
                    ->label('Dibuat oleh'),
                TextEntry::make('updater.name')
                    ->label('Diubah oleh'),
                TextEntry::make('created_at')
                    ->dateTime(),
            ]);
    }
}
