<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $kategori = $request->query('kategori');


        $query = Produk::where('is_active', true)
            ->orderBy('urutan');

        if ($kategori) {
            $query->where('badge', ucfirst($kategori));
        }

        $produks = $query->paginate(9)->through(function ($item) {
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

        return Inertia::render('Katalog', [
            'produks' => $produks,
            'aktifKategori' => $kategori,
        ]);
    }

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
