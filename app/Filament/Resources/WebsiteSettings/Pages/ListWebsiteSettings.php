<?php

namespace App\Filament\Resources\WebsiteSettings\Pages;

use App\Filament\Resources\WebsiteSettings\WebsiteSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWebsiteSettings extends ListRecords
{
    protected static string $resource = WebsiteSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
