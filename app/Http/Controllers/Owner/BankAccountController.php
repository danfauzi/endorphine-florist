<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BankAccountController extends Controller
{
    public function index()
    {
        $accounts = BankAccount::latest()->get();
        return view('owner.bank_accounts.index', compact('accounts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bank_name' => [$request->hasFile('qris_image') ? 'nullable' : 'required', 'string'],
            'account_number' => [$request->hasFile('qris_image') ? 'nullable' : 'required', 'string'],
            'account_holder' => 'required|string',
            'qris_image' => [$request->hasFile('qris_image') ? 'required' : 'nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
        ]);

        $data = $request->only(['bank_name', 'account_number', 'account_holder']);

        if ($request->hasFile('qris_image')) {
            $data['bank_name'] = $data['bank_name'] ?: 'QRIS';
            $data['account_number'] = '-';
            $data['qris_image'] = $request->file('qris_image')->store('qris', 'public');
        }

        BankAccount::create($data);

        return back()->with('success', 'Rekening bank berhasil ditambahkan!');
    }

    public function destroy(BankAccount $bankAccount)
    {
        if ($bankAccount->qris_image && Storage::disk('public')->exists($bankAccount->qris_image)) {
            Storage::disk('public')->delete($bankAccount->qris_image);
        }

        $bankAccount->delete();
        return back()->with('success', 'Rekening bank berhasil dihapus!');
    }

    public function toggle($id)
    {
        $account = BankAccount::findOrFail($id);
        $account->is_active = !$account->is_active;
        $account->save();

        return back()->with('success', 'Status rekening berhasil diperbarui!');
    }
}