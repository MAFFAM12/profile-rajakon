<?php

namespace App\Models;

use App\Traits\DeletesUploadedFile;
use App\Traits\FileUploadTrait;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use DeletesUploadedFile, FileUploadTrait;

    protected $fillable = [
        'judul',
        'slug',
        'excerpt',
        'konten',
        'thumbnail',
        'kategori',
        'is_published',
        'published_at',
        'urutan',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function uploadAttributes(): array
    {
        return ['thumbnail'];
    }
}