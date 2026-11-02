<?php

namespace App\Http\Controllers;

use App\Models\HeroSlide;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Tampilkan Katalog Produk untuk Publik (Home)
    // Tampilkan Katalog Produk untuk Publik (Home)
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%'.$request->search.'%');
        }

        if ($request->filled('category')) {
            $query->whereRaw('LOWER(category) = ?', [strtolower($request->category)]);
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

    public function reviews()
    {
        $reviews = Order::with('user')
            ->where('status', 'completed')
            ->where('payment_status', 'paid')
            ->whereNotNull('rating')
            ->whereNotNull('review')
            ->latest('reviewed_at')
            ->get();

        return view('reviews.index', compact('reviews'));
    }

    // Tampilkan Dashboard Admin untuk Kelola Produk
    public function adminIndex(Request $request)
    {
        $query = Product::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%'.$request->search.'%');
        }

        $products = $query->latest()->get();

        return view('admin.products', compact('products'));
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    // Simpan Produk Baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category' => 'required|in:bunga,snack,uang,kado,wisuda',
            'description' => 'nullable|string|max:2000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'category' => $request->category ?? 'Umum',
            'description' => $request->description,
            'image' => $imagePath,
            'status' => $request->stock > 0 ? 'Ready' : 'Habis',
        ]);

        return redirect()->back()->with('success', 'Produk baru berhasil ditambahkan!');
    }

    // Update Produk
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category' => 'required|in:bunga,snack,uang,kado,wisuda',
            'description' => 'nullable|string|max:2000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imagePath = $product->image;
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'category' => $request->category ?? $product->category,
            'description' => $request->description,
            'image' => $imagePath,
            'status' => $request->stock > 0 ? 'Ready' : 'Habis',
        ]);

        return redirect()->back()->with('success', 'Data produk berhasil diperbarui!');
    }

    // Hapus Produk
    public function destroy(Product $product)
    {
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->back()->with('success', 'Produk berhasil dihapus dari sistem!');
    }
}
