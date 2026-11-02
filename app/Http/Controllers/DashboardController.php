<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\HeroSlide;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Redirect universal berdasarkan role
    public function index(Request $request)
    {
        $role = strtolower(auth()->user()->role ?? '');

        if ($role === 'admin') {
            return $this->admin();
        } elseif ($role === 'kasir' || $role === 'cashier') {
            return $this->kasir();
        } elseif ($role === 'owner') {
            return redirect()->route('owner.dashboard');
        } elseif ($role === 'pelanggan') {
            return $this->pelanggan($request);
        }

        return redirect()->route('home');
    }

    // Dashboard khusus Kasir
    public function kasir()
    {
        // Ambil data pesanan riil untuk tabel dan rekap harian
        $orders = Order::with(['user', 'items.product'])->latest()->get();

        $rekapHarian = [
            'total_transaksi'  => Order::whereDate('created_at', today())->count(),
            'total_pendapatan' => Order::whereDate('created_at', today())
                ->where(function ($query) {
                    $query->where('payment_status', 'paid')->orWhere('status', 'completed');
                })->sum('total_price'),
            'total_tunai'      => Order::whereDate('created_at', today())
                ->where(function ($query) {
                    $query->where('payment_status', 'paid')->orWhere('status', 'completed');
                })->whereIn('payment_method', ['Cash', 'Tunai'])->sum('total_price'),
            'total_qris'       => Order::whereDate('created_at', today())
                ->where(function ($query) {
                    $query->where('payment_status', 'paid')->orWhere('status', 'completed');
                })->whereNotIn('payment_method', ['Cash', 'Tunai'])->sum('total_price'),
        ];

        return view('dashboard.kasir', compact('orders', 'rekapHarian'));
    }

    // Dashboard khusus Admin
    public function admin()
    {
        $products = Product::latest()->get();
        return view('dashboard.admin', compact('products'));
    }

    // Dashboard khusus Pelanggan -> Langsung ke Katalog Produk Beranda
    public function pelanggan(Request $request)
    {
        $query = Product::query();

        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        $products = $query->latest()->get();
        $heroSlides = HeroSlide::where('is_active', true)->orderBy('slot')->get();
        $reviews = Order::with('user')
            ->where('status', 'completed')
            ->where('payment_status', 'paid')
            ->whereNotNull('rating')
            ->whereNotNull('review')
            ->latest('reviewed_at')
            ->take(5)
            ->get();
        $reviewCount = Order::where('status', 'completed')
            ->where('payment_status', 'paid')
            ->whereNotNull('rating')
            ->whereNotNull('review')
            ->count();

        return view('index', compact('products', 'heroSlides', 'reviews', 'reviewCount'));
    }
}