<?php

namespace App\Jobs;

use App\Models\Blog;
use App\Models\Gallery;
use App\Models\Hero;
use App\Models\Partner;
use App\Models\Produk;
use App\Models\WebsiteSetting;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\ImageManager;
use Illuminate\Support\Str;

class ConvertImages implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        // 
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $models = [
            Hero::class,
            Gallery::class,
            Partner::class,
            Produk::class,
            Blog::class,
            WebsiteSetting::class
        ];

        foreach ($models as $key => $model) {
            $attribute = (new $model())->uploadAttributes()[0];

            $model::chunk(100, function ($datas) use ($model, $attribute) {
                foreach ($datas as $key => $data) {
                    $pathValue = $data->{$attribute};

                    // Skip if path is empty
                    if (empty($pathValue)) {
                        continue;
                    }

                    // Convert single path to array for uniform processing
                    $paths = is_string($pathValue) ? [$pathValue] : (is_array($pathValue) ? $pathValue : []);

                    $folder = match ($model) {
                        Hero::class => 'hero-images',
                        Gallery::class => 'galleries',
                        Partner::class => 'partner-logos',
                        Produk::class => 'product-photos',
                        Blog::class => 'blog-thumbnails',
                        WebsiteSetting::class => 'logo',
                    };

                    $updatedPaths = [];

                    foreach ($paths as $path) {
                        if (!is_string($path) || empty($path)) {
                            $updatedPaths[] = $path;
                            continue;
                        }

                        if (Storage::disk('public')->exists($path)) {
                            $fileContent = Storage::disk('public')->get($path);
                            $originalExtension = File::extension(storage_path($path));
                            $baseName = pathinfo(storage_path($path), PATHINFO_FILENAME);
                            $mimeType = Storage::disk('public')->mimeType($path);

                            if ($originalExtension !== 'webp') {
                                if (str_starts_with($mimeType, 'image/')) {
                                    $manager = new ImageManager(Driver::class);
                                    $image = $manager->read($fileContent);
                                    $encodedFile = $image->encode(new WebpEncoder());

                                    $newPath = "{$folder}/{$baseName}.webp";
                                    Storage::disk('public')->put($newPath, $encodedFile);
                                    $updatedPaths[] = $newPath;
                                } else {
                                    // Jika file BUKAN gambar (misal PDF, DOCX), simpan aslinya
                                    $newPath = "{$folder}/{$baseName}.{$originalExtension}";
                                    Storage::disk('public')->put($newPath, $fileContent);
                                    $updatedPaths[] = $newPath;
                                }
                            } else {
                                $updatedPaths[] = $path;
                            }
                        } else {
                            $updatedPaths[] = $path;
                        }
                    }

                    // Update with original format (string or array)
                    $updateValue = is_string($pathValue) ? reset($updatedPaths) : $updatedPaths;
                    $data->update([
                        $attribute => $updateValue
                    ]);
                }
            });
        }
    }
}
