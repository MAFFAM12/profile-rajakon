<?php

namespace App\Filament\Resources\Heroes\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Resources\Heroes\HeroResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions;

class EditHero extends EditRecord
{
    protected static string $resource = HeroResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
