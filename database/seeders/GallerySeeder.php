<?php

namespace Database\Seeders;

use App\Models\Gallery;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        Gallery::insert([
            [
                'title' => 'Proyek Jembatan Antara',
                'description' => 'Dokumentasi pembangunan jembatan modern.',
                'image' => 'gallery1.jpg',
                'year' => 2024,
                'is_active' => true,
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Instalasi Panel Surya',
                'description' => 'Pemasangan panel surya di pabrik energi.',
                'image' => 'gallery2.jpg',
                'year' => 2025,
                'is_active' => true,
                'order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Pabrik Otomatis',
                'description' => 'Konfigurasi sistem otomatisasi tingkat tinggi.',
                'image' => 'gallery3.jpg',
                'year' => 2025,
                'is_active' => false,
                'order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
