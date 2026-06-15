<?php

namespace App\Models;

use App\Traits\DeletesUploadedFile;
use App\Traits\FileUploadTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory, DeletesUploadedFile, FileUploadTrait;

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

    public function uploadAttributes(): array
    {
        return ['image'];
    }
}
