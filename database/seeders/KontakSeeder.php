<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class KontakSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('kontaks')->insert([
            [
                'id' => (string) Str::uuid(),
                'nama' => 'Siti Nurhayati',
                'email' => 'siti@example.com',
                'perusahaan' => 'PT Maju Jaya',
                'telepon' => '081234567890',
                'layanan_minat' => 'construction',
                'pesan' => 'Saya tertarik dengan layanan konstruksi dan ingin berkonsultasi lebih lanjut.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::uuid(),
                'nama' => 'Budi Santoso',
                'email' => 'budi@example.com',
                'perusahaan' => 'PT Elektrik Sukses',
                'telepon' => '082345678901',
                'layanan_minat' => 'electrical',
                'pesan' => 'Perlu penawaran untuk instalasi listrik pabrik baru.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::uuid(),
                'nama' => 'Indah Permata',
                'email' => 'indah@example.com',
                'perusahaan' => null,
                'telepon' => '083456789012',
                'layanan_minat' => 'other',
                'pesan' => 'Saya ingin mengetahui paket perawatan rutin.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
