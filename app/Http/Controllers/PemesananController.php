<?php

namespace App\Http\Controllers;

use Filament\Actions\Action;
use App\Filament\Resources\Pemesanans\PemesananResource;
use App\Mail\NewOrder;
use App\Models\Pemesanan;
use App\Models\Produk;
use App\Models\Subscription;
use Exception;
use Filament\Notifications\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class PemesananController extends Controller
{
    public function index(): Response
    {
        $produks = Produk::orderBy('nama_produk', 'asc')->get(['id', 'nama_produk', 'harga']);
        return Inertia::render('Pemesanan/Index', [
            'produks' => $produks
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'produk_id' => ['required', 'uuid', 'exists:produks,id'],
                'nama' => ['required', 'max:255', 'string'],
                'email' => ['required', 'email', 'max:255', 'string'],
                'no_wa' => ['required', 'numeric'],
                'jumlah_unit' => ['required', 'numeric', 'min:1'],
                'alamat_pengiriman' => ['required'],
                'total' => ['required', 'numeric'],
                'is_subscribe' => ['nullable'],
            ]);

            $insertedData = Arr::except($validated, 'is_subscribe');

            $order = Pemesanan::create($insertedData);

            if ($request->get('is_subscribe') === 'on') {
                Subscription::create([
                    'email' => $validated['email']
                ]);
            }

            return redirect()->back()
                ->with('success', 'Checkout berhasil, anda akan dialihkan untuk konfirmasi pesanan!')
                ->with('order_id', $order->id);
        } catch (ValidationException $e) {
            return redirect()->back()->with('validation-error', $e->errors());
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error: Failed to create order.' . $e->getMessage());
        }
    }

    public function confirm(Request $request): Response | RedirectResponse
    {
        try {
            $order = Pemesanan::with('produk')->findOrFail($request->id);
            $order->produk->media = collect($order->produk->media)->map(function ($media) {
                return config('app.url') . "/$media";
            });

            return Inertia::render('Pemesanan/Konfirmasi', [
                'pemesanan' => $order
            ]);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error: Failed to get order.' . $e->getMessage());
        }
    }

    public function update(Request $request): Response | RedirectResponse
    {
        try {
            $order = Pemesanan::findOrFail($request->id);

            $validated = $request->validate([
                'nama' => ['required', 'max:255', 'string'],
                'email' => ['required', 'email', 'max:255', 'string'],
                'no_wa' => ['required', 'numeric'],
                'jumlah_unit' => ['required', 'numeric', 'min:1'],
                'alamat_pengiriman' => ['required'],
                'total' => ['required', 'numeric'],
                'bukti_transfer' => ['required', 'file', 'mimes:jpg,png,jpeg,pdf']
            ]);

            $path = $request->file('bukti_transfer')->store('bukti-transfer/' . $order->id, 'public_upload');
            $validated['bukti_transfer'] = $path;

            if ($order->status_pesanan === 'menunggu konfirmasi pembeli') {
                $validated['status_pesanan'] = 'baru';
                $order->update($validated);
            }

            $this->notifyBuyer($order);

            return redirect()->route('order.success', ['id' => $order->id]);
        } catch (ValidationException $e) {
            return redirect()->back()->with('validation-error', $e->errors());
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error: Failed to update order.' . $e->getMessage());
        }
    }

    public function success(Request $request): Response
    {
        $order = Pemesanan::findOrFail($request->id);

        return Inertia::render('Pemesanan/Sukses', [
            'pemesanan' => $order,
            'message' => 'Pesanan berhasil dibuat, Temukan detail pengiriman dalam email pemberitahuan setelah peletakan order'
        ]);
    }

    public function detail(Request $request): Response
    {
        $order = Pemesanan::with('produk')->findOrFail($request->id);

        $order->bukti_transfer = config('app.url') . "/$order->bukti_transfer";
        $order->produk->media = collect($order->produk->media)->map(function ($media) {
            return config('app.url') . "/$media";
        });

        return Inertia::render('Pemesanan/Detail', [
            'pemesanan' => $order,
        ]);
    }

    protected function notifyBuyer(Pemesanan $order): void
    {
        Mail::to($order->email)->queue(new NewOrder($order));

        $user = auth()->user();

        Notification::make()
            ->title('Pesanan baru')
            ->icon('heroicon-o-shopping-bag')
            ->body("**{$order?->nama} memesan {$order->jumlah_unit} produk {$order->produk->nama_produk}.**")
            ->actions([
                Action::make('View')
                    ->url(PemesananResource::getUrl('edit', ['record' => $order])),
            ])
            ->sendToDatabase($user);
    }
}
