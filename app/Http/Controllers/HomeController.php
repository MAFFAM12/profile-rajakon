<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Partner;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $galleries = Gallery::orderBy('order')->get();

        $mapped = $galleries->map(function ($item) {
            return [
                'id'    => $item->id,
                'image' => Storage::url($item->image),
                'title' => $item->title ?? null,
                'year'  => $item->year ?? null,
            ];
        });

        $partners = Partner::where('is_active', true)
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
            'galleries' => $galleries,
            'partners'  => $partners,
            'produks'   => $produks,
        ]);
    }
}
