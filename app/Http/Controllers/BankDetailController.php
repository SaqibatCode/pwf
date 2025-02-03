<?php

namespace App\Http\Controllers;

use App\Models\BankDetail;
use Illuminate\Http\Request;

class BankDetailController extends Controller
{
    public function index()
    {
        $bankDetails = BankDetail::all();
        return view('dashboard.admin.payments.index', compact('bankDetails'));
    }

    public function create()
    {
        return view('dashboard.admin.payments.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'branch_code' => 'nullable|string|max:255',
            'iban' => 'nullable|string|max:255',
            'account_title' => 'required|string|max:255',
            'swift_code' => 'nullable|string|max:255',
        ]);

        BankDetail::create($validated);

        return redirect()->route('admin.bank_details.index')->with('success', 'Bank Detail created successfully');
    }

    public function edit($id)
    {
        $bankDetail = BankDetail::findOrFail($id);
        return view('dashboard.admin.payments.edit', compact('bankDetail'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'branch_code' => 'nullable|string|max:255',
            'iban' => 'nullable|string|max:255',
            'account_title' => 'required|string|max:255',
            'swift_code' => 'nullable|string|max:255',
        ]);

        $bankDetail = BankDetail::findOrFail($id);
        $bankDetail->update($validated);

        return redirect()->route('admin.bank_details.index')->with('success', 'Bank Detail updated successfully');
    }

    public function destroy($id)
    {
        $bankDetail = BankDetail::findOrFail($id);
        $bankDetail->delete();

        return redirect()->route('admin.bank_details.index')->with('success', 'Bank Detail deleted successfully');
    }
}



