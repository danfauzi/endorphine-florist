<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - Endorphine Florist</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="min-h-screen bg-rose-50/30 text-slate-800">
    <nav class="border-b border-pink-100 bg-white/90 px-4 py-5">
        <div class="mx-auto flex max-w-7xl items-center justify-between">
            <a href="{{ route('home') }}" class="text-xl font-black text-pink-600">🌸 Endorphine<span class="text-slate-800">Florist</span></a>
            <div class="flex items-center gap-2.5">
                @auth
                    <a href="{{ route('cart.index') }}" class="group inline-flex items-center gap-2 rounded-full border border-pink-100 bg-gradient-to-r from-pink-50 to-rose-50 px-4 py-2.5 text-xs font-extrabold text-pink-600 shadow-[0_8px_18px_rgba(236,72,153,0.10)] transition-all duration-200 hover:-translate-y-0.5 hover:border-pink-200 hover:from-pink-100 hover:to-rose-100 hover:shadow-[0_12px_24px_rgba(236,72,153,0.18)]">
                        <span class="flex h-6 w-6 items-center justify-center rounded-full bg-white text-pink-500 shadow-sm transition group-hover:bg-pink-500 group-hover:text-white">
                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4h2l2.2 10.2a2 2 0 0 0 2 1.6h7.6a2 2 0 0 0 1.9-1.4L20 8H6M10 20a1 1 0 1 1-2 0 1 1 0 0 1 2 0Zm8 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0Z"></path></svg>
                        </span>
                        <span>Keranjang</span>
                    </a>
                @endauth
                <a href="{{ route('home') }}" class="group inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-4 py-2.5 text-xs font-extrabold text-slate-600 shadow-[0_8px_18px_rgba(15,23,42,0.06)] transition-all duration-200 hover:-translate-y-0.5 hover:border-pink-200 hover:bg-pink-50 hover:text-pink-600 hover:shadow-[0_12px_24px_rgba(236,72,153,0.12)]">
                    <svg class="h-3.5 w-3.5 transition-transform duration-200 group-hover:-translate-x-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m6 6-6-6 6-6"></path></svg>
                    <span>Kembali ke Katalog</span>
                </a>
            </div>
        </div>
    </nav>

    <main class="mx-auto grid max-w-5xl grid-cols-1 gap-8 px-4 py-10 md:grid-cols-2">
        @if(session('success'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-bold text-emerald-700 md:col-span-2">
                ✅ {{ session('success') }}
            </div>
        @endif
        <div class="overflow-hidden rounded-3xl border border-slate-100 bg-white shadow-sm">
            @if($product->image)
                <img src="{{ str_starts_with($product->image, 'http') || str_starts_with($product->image, 'data:') ? $product->image : asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-full min-h-[360px] w-full object-cover">
            @else
                <div class="flex min-h-[360px] items-center justify-center text-6xl">🌸</div>
            @endif
        </div>
        <div class="flex flex-col justify-center space-y-5">
            <span class="w-fit rounded-full bg-pink-50 px-3 py-1 text-xs font-bold uppercase tracking-wider text-pink-600">{{ ucfirst($product->category) }}</span>
            <h1 class="text-3xl font-black text-slate-800">{{ $product->name }}</h1>
            <p class="text-sm leading-relaxed text-slate-500">{{ $product->description ?? 'Buket eksklusif dirangkai khusus untuk momen spesialmu.' }}</p>
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Harga</p>
                <p class="text-3xl font-black text-pink-600">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
            </div>
            <p class="text-sm font-bold {{ $product->stock > 0 ? 'text-emerald-600' : 'text-rose-600' }}">{{ $product->stock > 0 ? 'Ready - ' . $product->stock . ' stok tersedia' : 'Out Of Stock' }}</p>
            @auth
                @if($product->stock > 0)
                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full rounded-2xl bg-gradient-to-r from-pink-500 to-rose-500 px-5 py-3.5 text-sm font-extrabold text-white shadow-lg shadow-pink-200 hover:from-pink-600 hover:to-rose-600">🛒 Tambahkan ke Keranjang</button>
                    </form>
                @endif
            @else
                @if($product->stock > 0)
                    <a href="{{ route('login') }}" class="block w-full rounded-2xl bg-gradient-to-r from-pink-500 to-rose-500 px-5 py-3.5 text-center text-sm font-extrabold text-white shadow-lg shadow-pink-200">🔑 Masuk untuk Membeli</a>
                @endif
            @endauth
        </div>
    </main>
</body>
</html>
