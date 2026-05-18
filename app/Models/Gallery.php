<?php

namespace App\Models;

use App\Traits\DeletesUploadedFile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory, DeletesUploadedFile;

    protected $fillable = [
        'image',
        'title',
        'description',
        'year',
        'order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',  // ← tambahkan ini
        'year' => 'integer',
        'order' => 'integer',
    ];

    protected function uploadAttributes(): array
    {
        return ['image'];
    }
}
