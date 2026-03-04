<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SubscriptionController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function subscribe(Request $request): RedirectResponse
    {
        try {
            $validate = $request->validate([
                'email' => ['required', 'email', 'max:255', 'unique:subscriptions,email'],
            ]);

            Subscription::create($validate);

            return redirect()->back()->with('success', 'Terima kasih telah berlangganan! Kami akan mengirimkan update terbaru langsung ke email Anda.');
        } catch (ValidationException $e) {
            return redirect()->back()->with('validation-error', $e->errors());
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error: Failed to subscribe.' . $e->getMessage());
        }
    }
}
