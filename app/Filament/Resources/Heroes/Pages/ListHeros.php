<?php

namespace App\Filament\Resources\Heroes\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\Heroes\HeroResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHeros extends ListRecords
{
    protected static string $resource = HeroResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Buat'),
        ];
    }
}
