<?php

use App\Http\Controllers\KontakController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\BlogController;
use App\Models\Hero;
use App\Models\Produk;
use App\Models\Blog;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    $heroes = Hero::where('status', true)
        ->latest()
        ->get()
        ->map(function ($hero) {
            if ($hero->hero_image === null) {
                return null;
            }
            $hero->hero_image = (str_starts_with($hero->hero_image, 'http://') || str_starts_with($hero->hero_image, 'https://'))
                ? $hero->hero_image
                : Storage::url($hero->hero_image);
            return $hero;
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

    // 3 artikel terbaru untuk preview di homepage
    $blogs = Blog::where('is_published', true)
        ->latest('published_at')
        ->take(3)
        ->get()
        ->map(function ($item) {
            return [
                'id'           => $item->id,
                'judul'        => $item->judul,
                'slug'         => $item->slug,
                'excerpt'      => $item->excerpt,
                'thumbnail'    => $item->thumbnail ? Storage::url($item->thumbnail) : null,
                'kategori'     => $item->kategori,
                'published_at' => $item->published_at?->format('d M Y'),
            ];
        });

    return Inertia::render('Index', [
        'heroes'   => $heroes,
        'galleries' => $galleries,
        'partners' => $partners,
        'produks'  => $produks,
        'blogs'    => $blogs,
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

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');