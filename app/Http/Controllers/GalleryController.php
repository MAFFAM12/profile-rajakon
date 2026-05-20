<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    // Halaman utama (publik) - sudah ada
    public function index(Request $request)
    {
        $title = $request->query('title');
        $year = $request->query('year');

        $results = Gallery::query()
            ->whereIn('id', function ($query) {
                $query->selectRaw('MIN(id)')
                    ->from('galleries')
                    ->groupBy('title', 'year');
            })
            ->when($title, function ($query, $title) {
                return $query->where('title', $title);
            })
            ->when($year, function ($query, $year) {
                return $query->where('year', $year);
            })
            ->orderBy('year', 'desc');

        $datas = $results->paginate(10)
            ->withQueryString()
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
            'results' => $datas,
        ]);
    }
}
