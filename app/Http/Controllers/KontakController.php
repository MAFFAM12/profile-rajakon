<?php

namespace App\Http\Controllers;

use App\Enums\Layanan;
use App\Models\Kontak;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class KontakController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        try {

            $rules = [
                'nama' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255'],
                'perusahaan' => ['nullable', 'string', 'max:255'],
                'telepon' => ['nullable', 'string', 'max:20'],
                'layanan_minat' => ['required', Rule::enum(Layanan::class)],
                'pesan' => ['required', 'string'],
            ];

            $validated = $request->validate($rules);

            Kontak::create($validated);

            return redirect()->back()->with('success', 'Pesan Anda telah terkirim. Terima kasih!');
        } catch (ValidationException $e) {
            return redirect()->back()->with('validation-error', $e->errors());
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error: Failed to create order.' . $e->getMessage());
        }
    }
}
