<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Inertia\Inertia;

class ProdukController extends Controller
{
    public function show(string $slug)
    {
        $produk = Produk::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return Inertia::render('ProdukDetail', [
            'produk' => [
                'id'        => $produk->id,
                'nama'      => $produk->nama,
                'badge'     => $produk->badge,
                'deskripsi' => $produk->deskripsi,
                'manfaat'   => $produk->manfaat,
                'harga'     => $produk->harga,
                'gambar'    => $produk->gambar,
                'slug'      => $produk->slug,
            ],
        ]);
    }
}