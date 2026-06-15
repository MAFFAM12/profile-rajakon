<?php

namespace Database\Seeders;

use App\Models\Blog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        Blog::insert([
            [
                'judul' => 'Panduan Lengkap Keamanan Listrik Industri',
                'slug' => Str::slug('Panduan Lengkap Keamanan Listrik Industri'),
                'excerpt' => 'Langkah-langkah praktis memastikan keamanan instalasi listrik perusahaan Anda.',
                'konten' => 'Keamanan listrik menjadi prioritas utama... (isi dummy konten).',
                'thumbnail' => 'blog1.jpg',
                'kategori' => 'Electrical',
                'is_published' => true,
                'published_at' => now()->subDays(10),
                'urutan' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Tren Otomasi Pabrik 2026',
                'slug' => Str::slug('Tren Otomasi Pabrik 2026'),
                'excerpt' => 'Teknologi baru otomasi yang mengubah produksi manufaktur.',
                'konten' => 'Dalam beberapa tahun ke depan, otomatisasi akan... (isi dummy konten).',
                'thumbnail' => 'blog2.jpg',
                'kategori' => 'Maintenance',
                'is_published' => true,
                'published_at' => now()->subDays(4),
                'urutan' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Manfaat Inspeksi Rutin untuk Infrastruktur Gedung',
                'slug' => Str::slug('Manfaat Inspeksi Rutin untuk Infrastruktur Gedung'),
                'excerpt' => 'Perbandingan biaya dan manfaat inspeksi berkala.',
                'konten' => 'Inspeksi rutin dapat mencegah kegagalan besar...',
                'thumbnail' => 'blog3.jpg',
                'kategori' => 'Safety',
                'is_published' => false,
                'published_at' => null,
                'urutan' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
