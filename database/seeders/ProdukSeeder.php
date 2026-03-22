<?php

namespace Database\Seeders;

use App\Models\Produk;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProdukSeeder extends Seeder
{
    public function run(): void
    {
        Produk::insert([
            [
                'nama' => 'Pompa Industri X1',
                'badge' => 'Produk',
                'deskripsi' => 'Pompa industri performa tinggi untuk aplikasi berat.',
                'manfaat' => json_encode(['Hemat energi', 'Konsumsi rendah', 'Tahan korosi']),
                'harga' => 25000000,
                'gambar' => json_encode(['produk1-1.jpg', 'produk1-2.jpg']),
                'slug' => Str::slug('Pompa Industri X1'),
                'is_active' => true,
                'urutan' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Panel Distribusi E400',
                'badge' => 'Produk',
                'deskripsi' => 'Panel distribusi modular serbaguna untuk sistem elektrik.',
                'manfaat' => json_encode(['Mudah dimodifikasi', 'Keamanan tinggi', 'Monitoring real-time']),
                'harga' => 18000000,
                'gambar' => json_encode(['produk2-1.jpg']),
                'slug' => Str::slug('Panel Distribusi E400'),
                'is_active' => true,
                'urutan' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Sistem Kontrol M300',
                'badge' => 'Produk',
                'deskripsi' => 'Sistem kontrol PLC untuk otomasi pabrik.',
                'manfaat' => json_encode(['Integrasi mudah', 'Respon cepat', 'Skalabilitas tinggi']),
                'harga' => 42000000,
                'gambar' => json_encode(['produk3-1.jpg', 'produk3-2.jpg']),
                'slug' => Str::slug('Sistem Kontrol M300'),
                'is_active' => false,
                'urutan' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
