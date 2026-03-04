<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Produk extends Model
{
    protected $fillable = [
        'nama', 'badge', 'deskripsi', 'manfaat',
        'harga', 'gambar', 'slug', 'is_active', 'urutan'
    ];

    protected $casts = [
        'gambar'   => 'array',
        'manfaat'  => 'array',
        'is_active' => 'boolean',
    ];

    public function getFirstGambarAttribute(): ?string
    {
        return isset($this->gambar[0]) 
            ? asset('storage/' . $this->gambar[0]) 
            : null;
    }
}