<?php

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/gallery', function (Request $request) {
    $results = Gallery::latest()
        ->paginate(10)
        ->through(function ($item) {
            return [
                'id'    => $item->id,
                'image' => Storage::url($item->image),
                'title' => $item->title ?? null,
                'year'  => $item->year ?? null,
            ];
        });

    return response()->json([
        'success' => true,
        'results' => $results,
    ]);
});
