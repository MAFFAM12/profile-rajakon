<?php

namespace App\Models;

use App\Traits\DeletesUploadedFile;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Testimoni extends Model
{
    use HasUuids, DeletesUploadedFile;

    public function uploadAttributes(): array
    {
        return ['video'];
    }
}
