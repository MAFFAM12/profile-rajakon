<?php

use App\Http\Controllers\KontakController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\BlogController;
use App\Jobs\ConvertImages;
use App\Models\Hero;
use App\Models\Produk;
use App\Models\Blog;
use App\Models\Gallery;
use App\Models\Partner;
use App\Models\WebsiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Str;

Route::get('/', function () {
    $heroes = Hero::where('status', true)
        ->latest()
        ->get()
        ->map(function ($hero) {
            // Check if hero has images in array or hero_image field
            $hasImages = !empty($hero->images) || !empty($hero->hero_image);

            if (!$hasImages) {
                return null;
            }

            // Process images array if exists
            if (!empty($hero->images) && is_array($hero->images)) {
                $hero->images = array_map(function ($image) {
                    return (str_starts_with($image, 'http://') || str_starts_with($image, 'https://'))
                        ? $image
                        : Storage::disk('public')->url($image);
                }, $hero->images);

                $hero->hero_image = $hero->images[0];
            } elseif (!empty($hero->hero_image)) {
                // Process single hero_image field
                $hero->hero_image = (str_starts_with($hero->hero_image, 'http://') || str_starts_with($hero->hero_image, 'https://'))
                    ? $hero->hero_image
                    : Storage::disk('public')->url($hero->hero_image);
            }

            return $hero;
        })
        ->filter()
        ->values();

    $galleries = Gallery::whereIn('id', function ($query) {
        $query->selectRaw('MIN(id)')
            ->from('galleries')
            ->groupBy('title', 'year');
    })
        ->orderBy('year', 'desc')
        ->get();

    $partners = Partner::where('is_active', true)
        ->orderBy('order')
        ->get()
        ->map(function ($item) {
            return [
                'id'   => $item->id,
                'name' => $item->name,
                'logo' => Storage::disk('public')->url($item->logo),
            ];
        });

    $produks = Produk::where('is_active', true)
        ->orderBy('urutan', 'asc')
        ->limit(5)
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
                'thumbnail'    => $item->thumbnail ? Storage::disk('public')->url($item->thumbnail) : null,
                'kategori'     => $item->kategori,
                'published_at' => $item->published_at?->format('d M Y'),
            ];
        });

    // Website settings untuk footer dan informasi perusahaan
    $websiteSettings = WebsiteSetting::where('is_active', true)
        ->first();

    $settingsData = null;
    if ($websiteSettings) {
        $settingsData = [
            'id'                  => $websiteSettings->id,
            'company_name'        => $websiteSettings->company_name,
            'company_description' => $websiteSettings->company_description,
            'phone'               => $websiteSettings->phone,
            'email'               => $websiteSettings->email,
            'address'             => $websiteSettings->address,
            'logo'                => $websiteSettings->logo ? Storage::disk('public')->url($websiteSettings->logo) : null,
            'social_media'        => $websiteSettings->social_media ?? [],
        ];
    }

    return Inertia::render('Index', [
        'heroes'   => $heroes,
        'galleries' => $galleries,
        'partners' => $partners,
        'produks'  => $produks,
        'blogs'    => $blogs,
        'websiteSettings' => $settingsData,
    ]);
});

Route::post('/contact-message', [KontakController::class, 'store'])
    ->name('contact.store')
    ->middleware('throttle:10,1');

Route::get('/katalog', [ProdukController::class, 'index'])->name('produk.index');
Route::get('/produk/{slug}', [ProdukController::class, 'show'])->name('produk.show');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

Route::get('/tentang', function () {
    // Website settings untuk footer dan informasi perusahaan
    $websiteSettings = WebsiteSetting::where('is_active', true)
        ->first();

    $settingsData = null;
    if ($websiteSettings) {
        $settingsData = [
            'id'                  => $websiteSettings->id,
            'company_name'        => $websiteSettings->company_name,
            'company_description' => $websiteSettings->company_description,
            'phone'               => $websiteSettings->phone,
            'email'               => $websiteSettings->email,
            'address'             => $websiteSettings->address,
            'logo'                => $websiteSettings->logo ? Storage::disk('public')->url($websiteSettings->logo) : null,
            'social_media'        => $websiteSettings->social_media ?? [],
        ];
    }

    return Inertia::render('Tentang', [
        'websiteSettings' => $settingsData,
    ]);
});

Route::get('/dokumentasi/{slug}', function ($slug) {
    // Find a gallery with this slug to get title and year
    $gallery = Gallery::where('is_active', true)
        ->get()
        ->first(function ($item) use ($slug) {
            $itemSlug = Str::slug($item->title . '-' . $item->year);
            return $itemSlug === $slug;
        });

    if (!$gallery) {
        abort(404, 'Dokumentasi tidak ditemukan');
    }

    // Get all galleries with the same title and year
    $galleries = Gallery::where('title', $gallery->title)
        ->where('year', $gallery->year)
        ->where('is_active', true)
        ->get()
        ->map(function ($item) {
            return [
                'id'    => $item->id,
                'image' => Storage::disk('public')->url($item->image),
                'title' => $item->title ?? null,
                'year'  => $item->year ?? null,
            ];
        });

    return Inertia::render('DocumentationDetail', [
        'title' => $gallery->title,
        'year' => $gallery->year,
        'galleries' => $galleries
    ]);
});
