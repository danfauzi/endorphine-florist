<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard')->with('error', 'Admin tidak dapat melakukan transaksi pembelian.');
        }
        $cartItems = Cart::with('product')->where('user_id', auth()->id())->get();
        $total = $cartItems->sum(fn ($item) => $item->product->price * $item->quantity);

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function addToCart(Request $request, $productId)
    {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard')->with('error', 'Admin tidak dapat melakukan transaksi pembelian.');
        }

        $product = Product::findOrFail($productId);

        if ($product->stock <= 0) {
            return redirect()->back()->with('error', 'Produk '.$product->name.' sedang Out Of Stock.');
        }

        $cart = Cart::firstOrNew([
            'user_id' => auth()->id(),
            'product_id' => $productId,
        ]);

        $quantity = max(1, (int) $request->input('quantity', 1));

        if ($cart->quantity + $quantity > $product->stock) {
            return redirect()->back()->with('error', 'Jumlah melebihi stok yang tersedia. Sisa stok: '.$product->stock.'.');
        }

        $cart->quantity += $quantity;
        $cart->save();

        return redirect()->back()->with('success', 'Berhasil Menambahkan Ke Keranjang');
    }

    public function destroy($id)
    {
        Cart::where('user_id', auth()->id())->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Item dihapus dari keranjang.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'note' => 'nullable|string|max:1000',
        ]);

        $cartItem = Cart::where('user_id', auth()->id())->findOrFail($id);

        if ($request->action == 'increase') {
            $cartItem->quantity += 1;
        } elseif ($request->action == 'decrease' && $cartItem->quantity > 1) {
            $cartItem->quantity -= 1;
        }

        if ($request->has('note')) {
            $cartItem->note = $request->input('note');
        }

        $cartItem->save();

        return redirect()->back()->with('success', 'Jumlah keranjang berhasil diperbarui.');
    }

    public function clear()
    {
        // Menghapus semua item keranjang milik user yang sedang login
        Cart::where('user_id', Auth::id())->delete();

        return redirect()->back()->with('success', 'Seluruh isi keranjang berhasil dikosongkan.');
    }

    public function applyVoucher(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $voucherCode = strtoupper(trim($request->code));

        $voucher = Voucher::whereRaw('UPPER(code) = ?', [$voucherCode])->first();

        if (! $voucher) {
            return back()->with('error', 'Kode voucher tidak valid atau sudah kadaluarsa.');
        }

        if (! $voucher->refreshStatus()) {
            return back()->with('error', 'Kode voucher sudah kadaluarsa atau habis digunakan.');
        }

        // Hitung total keranjang
        $cartItems = Cart::where('user_id', auth()->id())->get();
        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        // Validasi Minimal Pembelian
        if ($subtotal < $voucher->min_order_price) {
            return back()->with('error', 'Minimal pembelian untuk voucher ini adalah Rp '.number_format($voucher->min_order_price, 0, ',', '.'));
        }

        // HITUNG DISKON
        if ($voucher->type === 'percent') {
            $discountAmount = ($voucher->discount_value / 100) * $subtotal;
        } else {
            $discountAmount = $voucher->discount_value;
        }

        // Simpan diskon ke session
        session()->put('voucher', [
            'code' => $voucher->code,
            'discount' => $discountAmount,
        ]);

        return back()->with('success', 'Voucher berhasil dipasang! Potongan harga: Rp '.number_format($discountAmount, 0, ',', '.'));
    }

    public function removeVoucher()
    {
        // Menghapus data voucher yang tersimpan di session
        session()->forget('voucher');

        return redirect()->back()->with('success', 'Kode promo berhasil dihapus.');
    }
}
