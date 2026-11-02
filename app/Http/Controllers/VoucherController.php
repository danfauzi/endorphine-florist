<?php

namespace App\Http\Controllers;

use App\Models\Voucher; // Pastikan baris ini ada
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::latest()->get()->each->refreshStatus();

        return view('dashboard.vouchers', compact('vouchers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:vouchers,code|max:50',
            'type' => 'required|in:fixed,percent',
            'discount_value' => 'required|numeric|min:0',
            'min_order_price' => 'nullable|numeric|min:0',
            'quota' => 'required|integer|min:1',
            'expired_date' => 'required|date|after_or_equal:today',
        ]);

        Voucher::create([
            'code' => strtoupper($request->code),
            'type' => $request->type,
            'discount_amount' => $request->discount_value, // Mengisi kolom discount_amount jika ada di DB
            'discount_value' => $request->discount_value,
            'min_order_price' => $request->min_order_price ?? 0,
            'quota' => $request->quota,
            'expired_date' => $request->expired_date,
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', 'Voucher Promo berhasil ditambahkan!');
    }

    public function destroy(Voucher $voucher)
    {
        $voucher->delete();
        return redirect()->back()->with('success', 'Voucher berhasil dihapus!');
    }

    public function toggleStatus(Voucher $voucher)
    {
        $voucher->toggleStatusByOwner();

        return redirect()->back()->with('success', 'Status voucher berhasil diperbarui!');
    }
}