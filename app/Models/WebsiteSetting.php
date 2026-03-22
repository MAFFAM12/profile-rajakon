<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class WebsiteSetting extends Model
{
    use HasUuids;

    protected $fillable = [
        'phone',
        'email',
        'address',
        'social_media',
        'company_name',
        'company_description',
        'logo',
        'is_active',
    ];

    protected $casts = [
        'social_media' => 'array',
        'is_active' => 'boolean',
    ];
}
