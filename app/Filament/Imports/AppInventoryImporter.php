<?php

namespace App\Filament\Imports;

use App\Models\AppInventory;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Number;

class AppInventoryImporter extends Importer
{
    protected static ?string $model = AppInventory::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('app_name')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('link')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('username')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('password')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
        ];
    }

    public function resolveRecord(): AppInventory
    {
        return AppInventory::firstOrNew([
            'app_name' => $this->data['app_name'],
        ]);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your app inventory import has completed and ' . Number::format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
