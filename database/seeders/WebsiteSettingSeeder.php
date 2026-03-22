<?php

namespace Database\Seeders;

use App\Models\WebsiteSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class WebsiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        WebsiteSetting::create([
            'id' => Str::uuid(),
            'phone' => '+62 21 1234 5678',
            'email' => 'info@rajakon.com',
            'address' => 'Jl. Industri No. 123, Jakarta Pusat, DKI Jakarta 10110, Indonesia',
            'social_media' => [
                'facebook' => 'https://facebook.com/rajakon',
                'instagram' => 'https://instagram.com/rajakon',
                'linkedin' => 'https://linkedin.com/company/rajakon',
                'twitter' => 'https://twitter.com/rajakon',
                'youtube' => 'https://youtube.com/@rajakon',
            ],
            'company_name' => 'PT Raja Konstruksi Indonesia',
            'company_description' => 'Perusahaan konstruksi terkemuka yang menyediakan layanan konstruksi, mekanikal, elektrikal, safety, maintenance, logistik, dan solusi industri lainnya.',
            'logo' => 'logo-rajakon.png',
            'is_active' => true,
        ]);
    }
}
