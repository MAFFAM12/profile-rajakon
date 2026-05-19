<?php

namespace App\Models;

use App\Traits\DeletesUploadedFile;
use App\Traits\FileUploadTrait;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use DeletesUploadedFile, FileUploadTrait;
    
    protected $fillable = ['name', 'logo', 'order', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function uploadAttributes(): array
    {
        return ['logo'];
    }
}