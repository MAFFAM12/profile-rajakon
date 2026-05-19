<?php

namespace App\Models;

use App\Traits\DeletesUploadedFile;
use App\Traits\FileUploadTrait;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Hero extends Model
{
    use HasFactory, HasUuids, DeletesUploadedFile, FileUploadTrait;

    protected $fillable = [
        'heading',
        'sub_heading',
        'cta_link',
        'cta_label',
        'hero_image',
        'images',
        'images_display_type',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'status' => 'boolean',
        'images' => 'array',
    ];

    // Optionally, add relationships to User for created_by and updated_by
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Automatically set created_by and updated_by
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (Auth::check()) {
                $model->created_by = Auth::user()->id;
                $model->updated_by = Auth::user()->id;
            }
        });
        static::updating(function ($model) {
            if (Auth::check()) {
                $model->updated_by = Auth::user()->id;
            }
        });
    }

    public function uploadAttributes(): array
    {
        return ['images'];
    }
}
