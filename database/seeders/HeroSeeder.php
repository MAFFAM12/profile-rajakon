<?php

namespace Database\Seeders;

use App\Models\Hero;
use Illuminate\Database\Seeder;

class HeroSeeder extends Seeder
{
    public function run(): void
    {
        Hero::insert([
            [
                'id' => (string) \Illuminate\Support\Str::uuid(),
                'heading' => 'Solusi Konstruksi Terdepan',
                'sub_heading' => 'Kualitas, Kecepatan, dan Keandalan',
                'cta_link' => '/contact',
                'cta_label' => 'Hubungi Kami',
                'hero_image' => 'hero1.jpg',
                'images' => json_encode(['hero1.jpg', 'hero2.jpg', 'hero3.jpg']),
                'images_display_type' => 'slide',
                'status' => true,
                'created_by' => null,
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) \Illuminate\Support\Str::uuid(),
                'heading' => 'Tingkatkan Efisiensi Pabrik Anda',
                'sub_heading' => 'Pemeliharaan dan Otomasi Terpercaya',
                'cta_link' => '/service',
                'cta_label' => 'Pelajari Lebih Lanjut',
                'hero_image' => 'hero4.jpg',
                'images' => json_encode(['hero4.jpg', 'hero5.jpg']),
                'images_display_type' => 'card',
                'status' => true,
                'created_by' => null,
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
