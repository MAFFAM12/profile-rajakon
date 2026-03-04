<?php

namespace App\Console\Commands;

use App\Models\Hero;
use App\Models\Produk;
use App\Models\Promo;
use App\Models\Testimoni;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CleanupUnusedUploads extends Command
{
    protected $signature = 'uploads:cleanup';
    protected $description = 'Hapus file upload yang tidak lagi digunakan oleh database';

    public function handle()
    {
        $disk = Storage::disk('public_upload');

        // Mapping: folder → model → kolom
        $map = [
            'promo' => [Promo::class, 'gambar'],
            'produk' => [Produk::class, 'media'],
            'hero' => [Hero::class, 'hero_image'],
            'testimoni' => [Testimoni::class, 'video'],
        ];

        foreach ($map as $folder => [$model, $column]) {
            $this->info("📂 Memeriksa folder: $folder");

            $files = $disk->files($folder);

            // Ambil semua path dari database (handle array vs string)
            $pathsInUse = collect($model::pluck($column))
                ->flatten()
                ->filter()
                ->map(fn($path) => is_array($path) ? $path : [$path])
                ->flatten()
                ->unique()
                ->toArray();

            foreach ($files as $file) {
                if (!in_array($file, $pathsInUse)) {
                    $this->warn("🗑 Menghapus: $file");
                    $disk->delete($file);
                }
            }
        }

        $this->info("✅ Pembersihan selesai.");
    }
}
