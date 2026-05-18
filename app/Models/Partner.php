<?php

namespace App\Models;

use App\Traits\DeletesUploadedFile;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use DeletesUploadedFile;
    
    protected $fillable = ['name', 'logo', 'order', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected function uploadAttributes(): array
    {
        return ['logo'];
    }
}