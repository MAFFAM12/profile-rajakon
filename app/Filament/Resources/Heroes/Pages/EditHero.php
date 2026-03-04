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

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['hero_image'] = $data['image_type'] === 'upload'
            ? $data['image_upload'] // bisa jadi string (path) atau array
            : $data['image_url'];   // pasti string

        unset($data['image_upload'], $data['image_url'], $data['image_type']); // opsional, untuk kebersihan

        return $data;
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        if (isset($data['hero_image']) && is_string($data['hero_image']) && (str_starts_with($data['hero_image'], 'http://') || str_starts_with($data['hero_image'], 'https://'))) {
            $data['image_type'] = 'url';
            $data['image_url'] = $data['hero_image'];
        } else {
            $data['image_type'] = 'upload';
            $data['image_upload'] = $data['hero_image'];
        }

        return $data;
    }
}
