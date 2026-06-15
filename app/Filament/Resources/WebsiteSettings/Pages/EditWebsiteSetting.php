<?php

namespace App\Filament\Resources\WebsiteSettings\Pages;

use App\Filament\Resources\WebsiteSettings\WebsiteSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWebsiteSetting extends EditRecord
{
    protected static string $resource = WebsiteSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
