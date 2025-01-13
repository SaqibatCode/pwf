<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerPaymentMethodController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'branch_code' => 'required|string|max:255',
            'iban' => 'required|string|max:255',
            'account_title' => 'required|string|max:255',
            'swift_code' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $user->payment_methods()->create($validated);

        return redirect()->back()->with('success', 'Payment Method added successfully!');
    }

    // Destroy a payment method
    public function destroy($id)
    {
        $user = Auth::user();
        $paymentMethod = $user->payment_methods()->findOrFail($id);
        $paymentMethod->delete();

        return redirect()->back()->with('success', 'Payment Method deleted successfully!');
    }
}
