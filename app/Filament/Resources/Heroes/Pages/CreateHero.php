<?php

namespace App\Filament\Resources\Heroes\Pages;

use App\Filament\Resources\Heroes\HeroResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions;

class CreateHero extends CreateRecord
{
    protected static string $resource = HeroResource::class;
}
