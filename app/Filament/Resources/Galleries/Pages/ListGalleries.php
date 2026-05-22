<?php

namespace App\Filament\Resources\Galleries\Pages;

use App\Filament\Resources\Galleries\GalleryResource;
use App\Models\Gallery;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ListGalleries extends ListRecords
{
    protected static string $resource = GalleryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('bulk_upload')
                        ->icon(Heroicon::CloudArrowUp)
                        ->color('info')
                        ->schema([
                            FileUpload::make('image')
                                ->label('Gambar')
                                ->image()
                                ->required()
                                ->disk('public')
                                ->preserveFilenames()
                                ->imageEditor()
                                ->multiple()
                                ->saveUploadedFileUsing(function (TemporaryUploadedFile $file): string {
                                    return (new Gallery())->uploadFile($file, 'galleries');
                                }),
                            TextInput::make('title')
                                ->label('Judul')
                                ->required()
                                ->maxLength(255),
                            TextInput::make('year')
                                ->label('Tahun')
                                ->numeric()
                                ->minValue(1900)
                                ->maxValue(Carbon::now()->year),
                        ])
                        ->action(function ($data) {
                            $images = collect($data['image']);

                            $images->map(function ($item, $key) use ($data) {
                                $this->getModel()::create([
                                    'image' => $item,
                                    'title' => $data['title'],
                                    'year' => $data['year'],
                                ]);
                            });
                        })
                        ->successNotificationTitle('Files Uploaded Successfully'),
        ];
    }
}
