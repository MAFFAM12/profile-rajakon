<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
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
}