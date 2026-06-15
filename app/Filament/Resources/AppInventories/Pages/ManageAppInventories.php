<?php

namespace App\Filament\Resources\AppInventories\Pages;

use App\Filament\Imports\AppInventoryImporter;
use App\Filament\Resources\AppInventories\AppInventoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageAppInventories extends ManageRecords
{
    protected static string $resource = AppInventoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Buat baru'),
            Actions\ImportAction::make()
                ->label('Impor data')
                ->importer(AppInventoryImporter::class)
        ];
    }
}
