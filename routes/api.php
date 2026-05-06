<?php

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/gallery', function(Request $request) {
    $results = Gallery::latest()->paginate(10);

    return response()->json([
        'success' => true,
        'results' => $results,
    ]);
});
