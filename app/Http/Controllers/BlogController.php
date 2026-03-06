<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $kategori = $request->query('kategori');

        $query = Blog::where('is_published', true)
            ->orderBy('published_at', 'desc');

        if ($kategori) {
            $query->where('kategori', $kategori);
        }

        $blogs = $query->paginate(9)->through(function ($item) {
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

        $kategoris = Blog::where('is_published', true)
            ->whereNotNull('kategori')
            ->distinct()
            ->pluck('kategori');

        return Inertia::render('Blog', [
            'blogs'     => $blogs,
            'kategoris' => $kategoris,
            'aktifKategori' => $kategori,
        ]);
    }

    public function show(string $slug)
    {
        $blog = Blog::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        $related = Blog::where('is_published', true)
            ->where('id', '!=', $blog->id)
            ->where('kategori', $blog->kategori)
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

        return Inertia::render('BlogDetail', [
            'blog' => [
                'id'           => $blog->id,
                'judul'        => $blog->judul,
                'slug'         => $blog->slug,
                'excerpt'      => $blog->excerpt,
                'konten'       => $blog->konten,
                'thumbnail'    => $blog->thumbnail ? Storage::url($blog->thumbnail) : null,
                'kategori'     => $blog->kategori,
                'published_at' => $blog->published_at?->format('d M Y'),
            ],
            'related' => $related,
        ]);
    }
}