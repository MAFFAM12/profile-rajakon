<?php

namespace App\Filament\Resources\Heroes\Pages;

use App\Filament\Resources\Heroes\HeroResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions;

class CreateHero extends CreateRecord
{
    protected static string $resource = HeroResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['hero_image'] = $data['image_type'] === 'upload'
            ? $data['image_upload'] // bisa jadi string (path) atau array
            : $data['image_url'];   // pasti string

        unset($data['image_upload'], $data['image_url'], $data['image_type']); // opsional, untuk kebersihan

        return $data;
    }
}
