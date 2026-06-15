<?php

namespace App\Models;

use App\Traits\DeletesUploadedFile;
use App\Traits\FileUploadTrait;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Override;

class WebsiteSetting extends Model
{
    use HasUuids, DeletesUploadedFile, FileUploadTrait;

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

    public function uploadAttributes(): array
    {
        return [
            'logo'
        ];
    }
}
