<?php

use App\Http\Controllers\GalleryController;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/gallery', [GalleryController::class, 'index']);