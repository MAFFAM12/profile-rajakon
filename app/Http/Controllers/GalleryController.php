<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class GalleryController extends Controller
{
    // Halaman utama (publik) - sudah ada
    public function index()
    {
        $galleries = Gallery::where('is_active', true)
            ->orderBy('order')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'image' => Storage::url($item->image),
                    'title' => $item->title ?? null,
                    'year' => $item->year ?? null,
                ];
            });

        return Inertia::render('Index', [
            'galleries' => $galleries,
        ]);
    }

    // Halaman admin: daftar + form upload
    public function adminIndex()
    {
        $galleries = Gallery::orderBy('order')->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'image' => Storage::url($item->image),
                'title' => $item->title,
                'order' => $item->order,
                'is_active' => $item->is_active,
            ];
        });

        return Inertia::render('Admin/Gallery', [
            'galleries' => $galleries,
        ]);
    }

    // Upload gambar baru
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:0',
        ]);

        $path = $request->file('image')->store('gallery', 'public');

        Gallery::create([
            'image' => $path,
            'title' => $request->title,
            'order' => $request->order ?? Gallery::max('order') + 1,
            'is_active' => true,
        ]);

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Gambar berhasil diupload!');
    }

    // Hapus gambar
    public function destroy(Gallery $gallery)
    {
        // Hapus file dari storage kalau path ada dan valid
        if ($gallery->image && is_string($gallery->image) && Storage::disk('public')->exists($gallery->image)) {
            Storage::disk('public')->delete($gallery->image);
        }

        // Hapus record dari database
        $gallery->delete();

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Gambar berhasil dihapus!');
    }
}
