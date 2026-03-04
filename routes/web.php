<?php

use App\Http\Controllers\KontakController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ProdukController;
use App\Models\Hero;
use App\Models\Produk;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    $heroes = Hero::where('status', true)
        ->latest()
        ->get()
        ->map(function ($hero) {
            return [
                'id'          => $hero->id,
                'heading'     => $hero->heading,
                'sub_heading' => $hero->sub_heading,
                'cta_label'   => $hero->cta_label,
                'cta_link'    => $hero->cta_link,
                'hero_image'  => $hero->hero_image
                    ? \Illuminate\Support\Facades\Storage::url($hero->hero_image)
                    : null,
                'status'      => $hero->status,
            ];
        })
        ->filter()
        ->values();

    $galleries = \App\Models\Gallery::where('is_active', true)
        ->orderBy('order')
        ->get()
        ->map(function ($item) {
            return [
                'id'    => $item->id,
                'image' => Storage::url($item->image),
                'title' => $item->title ?? null,
                'year'  => $item->year ?? null,
            ];
        });

    $partners = \App\Models\Partner::where('is_active', true)
        ->orderBy('order')
        ->get()
        ->map(function ($item) {
            return [
                'id'   => $item->id,
                'name' => $item->name,
                'logo' => Storage::url($item->logo),
            ];
        });

    $produks = Produk::where('is_active', true)
        ->orderBy('urutan')
        ->get()
        ->map(function ($item) {
            return [
                'id'        => $item->id,
                'nama'      => $item->nama,
                'badge'     => $item->badge,
                'deskripsi' => $item->deskripsi,
                'manfaat'   => $item->manfaat,
                'harga'     => $item->harga,
                'gambar'    => $item->gambar,
                'slug'      => $item->slug,
            ];
        });

    return Inertia::render('Index', [
        'heroes'   => $heroes,
        'galleries' => $galleries,
        'partners' => $partners,
        'produks'  => $produks,
    ]);
});

Route::post('/contact-message', [KontakController::class, 'store'])
    ->name('contact.store')
    ->middleware('throttle:10,1');

Route::prefix('admin')->group(function () {
    Route::get('/gallery', [GalleryController::class, 'adminIndex'])->name('admin.gallery.index');
    Route::post('/gallery', [GalleryController::class, 'store'])->name('admin.gallery.store');
    Route::delete('/gallery/{id}', [GalleryController::class, 'destroy'])->name('admin.gallery.destroy');
});

Route::get('/produk/{slug}', [ProdukController::class, 'show'])->name('produk.show');
