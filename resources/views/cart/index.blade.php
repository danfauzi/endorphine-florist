<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - Endorphine Florist</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="flex min-h-screen flex-col justify-between bg-[radial-gradient(circle_at_top_left,_#fff1f7,_transparent_34%),#fffafb] text-slate-800">

    <!-- Header / Navbar -->
    <nav class="sticky top-0 z-50 border-b border-pink-100/80 bg-white/85 shadow-[0_8px_24px_rgba(190,24,93,0.06)] backdrop-blur-md">
        <div class="mx-auto flex h-20 max-w-7xl items-center justify-between px-4">
            <a href="{{ route('home') }}" class="flex items-center gap-2 text-2xl font-black tracking-tight text-pink-600 transition hover:opacity-80">
                <span>🌸</span> Endorphine<span class="text-slate-800">Florist</span>
            </a>
            <a href="{{ route('home') }}"
                class="group inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-4 py-2.5 text-xs font-extrabold text-slate-600 shadow-sm transition hover:-translate-y-0.5 hover:border-pink-200 hover:bg-pink-50 hover:text-pink-600">
                <svg class="h-3.5 w-3.5 transition-transform group-hover:-translate-x-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m6 6-6-6 6-6"></path></svg>
                <span>Lanjut Belanja</span>
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="mx-auto w-full max-w-5xl px-4 py-10">
        <div class="mb-8 flex items-center justify-between gap-4">
            <div>
                <span
                    class="rounded-full border border-pink-100 bg-pink-50 px-3 py-1 text-xs font-extrabold text-pink-600">Checkout
                    Step 1</span>
                <h1 class="mt-2 text-2xl font-black tracking-tight text-slate-800 sm:text-3xl">Keranjang Belanjaanmu</h1>
            </div>

            @if($cartItems->count() > 0)
                <form action="{{ route('cart.clear') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Yakin ingin mengosongkan seluruh keranjang?')"
                        class="inline-flex items-center gap-2 rounded-full border border-rose-200 bg-rose-50 px-3.5 py-2.5 text-xs font-extrabold text-rose-500 transition hover:bg-rose-100 hover:text-rose-700">
                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M10 11v6m4-6v6M6 7l1 13h10l1-13M9 7V4h6v3"></path></svg>
                        <span>Kosongkan Keranjang</span>
                    </button>
                </form>
            @endif
        </div>

        @if(session('success'))
            <div
                class="mb-6 flex items-center gap-2 rounded-2xl border border-emerald-100 bg-emerald-50 p-4 text-xs font-bold text-emerald-700 shadow-sm">
                <span>✅</span> <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($cartItems->count() > 0)
            <div class="grid grid-cols-1 items-start gap-7 lg:grid-cols-3">
                <!-- Daftar Item Cart -->
                <div class="lg:col-span-2 space-y-4">
                    @foreach($cartItems as $item)
                        <div
                            class="flex flex-col items-start justify-between gap-4 rounded-[1.75rem] border border-pink-100/70 bg-white p-4 shadow-[0_12px_30px_rgba(190,24,93,0.06)] transition hover:-translate-y-0.5 hover:shadow-[0_16px_34px_rgba(190,24,93,0.10)] sm:flex-row sm:items-center sm:p-5">
                            <div class="flex items-center gap-4 w-full sm:w-auto flex-1">
                                <img src="{{ str_starts_with($item->product->image ?? '', 'http') || str_starts_with($item->product->image ?? '', 'data:') ? $item->product->image : asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}"
                                    class="h-20 w-20 rounded-2xl bg-slate-100 object-cover ring-4 ring-pink-50 sm:h-24 sm:w-24">
                                <div class="flex-1">
                                    <span
                                        class="rounded-full border border-pink-100 bg-pink-50 px-2.5 py-0.5 text-[10px] font-bold text-pink-600">
                                        {{ ucfirst($item->product->category) }}
                                    </span>
                                    <h3 class="font-bold text-slate-800 text-sm sm:text-base mt-1 line-clamp-1">
                                        {{ $item->product->name }}
                                    </h3>
                                    <p class="text-xs text-pink-600 font-extrabold mt-0.5">Rp
                                        {{ number_format($item->product->price, 0, ',', '.') }}
                                    </p>

                                    <!-- Form Update Kuantitas & Catatan -->
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="mt-2 space-y-2">
                                        @csrf
                                        @method('PATCH')

                                        <!-- Tombol Kuantitas -->
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="flex items-center overflow-hidden rounded-xl border border-slate-200 bg-slate-50 shadow-sm">
                                                <button type="submit" name="action" value="decrease" aria-label="Kurangi jumlah"
                                                    class="px-2.5 py-1 text-xs font-bold text-slate-600 transition-colors hover:bg-pink-100 hover:text-pink-600">−</button>
                                                <span
                                                    class="px-3 py-1 text-xs font-bold text-slate-800 bg-white">{{ $item->quantity }}</span>
                                                <button type="submit" name="action" value="increase" aria-label="Tambah jumlah"
                                                    class="px-2.5 py-1 text-xs font-bold text-slate-600 transition-colors hover:bg-pink-100 hover:text-pink-600">+</button>
                                            </div>
                                            <span class="text-xs text-pink-600 font-extrabold">Rp
                                                {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</span>
                                        </div>

                                        <!-- Catatan Buket -->
                                        <div>
                                            <input type="text" name="note"
                                                placeholder="Catatan buket (opsional, misal: warna pita)"
                                                value="{{ $item->note ?? '' }}" onchange="this.form.submit()"
                                                class="w-full text-[11px] px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:border-pink-500 text-slate-700">
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Tombol Hapus -->
                            <form action="{{ route('cart.destroy', $item->id) }}" method="POST" class="self-end sm:self-center">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('Hapus buket {{ $item->product->name }} ini dari keranjang?')"
                                    class="group flex h-10 w-10 items-center justify-center rounded-2xl bg-rose-50 text-rose-600 shadow-sm transition-all duration-200 hover:bg-rose-500 hover:text-white hover:shadow-md hover:shadow-rose-200">
                                    <svg class="h-4 w-4 transition-transform group-hover:scale-110" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M10 11v6m4-6v6M6 7l1 13h10l1-13M9 7V4h6v3"></path></svg>
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>

                <!-- Ringkasan Pesanan -->
                <div class="space-y-5 rounded-[1.75rem] border border-pink-100/70 bg-white p-6 shadow-[0_14px_34px_rgba(190,24,93,0.08)] sm:p-7 lg:sticky lg:top-28">
                    <h2 class="font-extrabold text-slate-800 text-lg border-b border-slate-100 pb-3.5">Ringkasan Pesanan
                    </h2>

                    @php
                        $discount = session('voucher')['discount'] ?? 0;
                        $finalTotal = max(0, $total - $discount);
                    @endphp

                    <div class="space-y-3 text-sm text-slate-600">
                        <div class="flex justify-between items-center">
                            <span>Total Item</span>
                            <span class="font-bold text-slate-800">{{ $cartItems->sum('quantity') }} Buket</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span>Subtotal</span>
                            <span class="font-bold text-slate-800">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Input Kode Promo / Voucher -->
                    <div class="pt-3 border-t border-slate-100">
                        <label class="block text-xs font-bold text-slate-700 mb-2">Punya Kode Promo?</label>

                        @if(session('error'))
                            <p class="text-xs text-rose-500 font-bold mb-2">❌ {{ session('error') }}</p>
                        @endif

                        @if(session('voucher'))
                            <div
                                    class="flex items-center justify-between rounded-2xl border border-emerald-200 bg-emerald-50 p-3 text-xs font-bold text-emerald-700">
                                <span class="flex items-center gap-1">{{ session('voucher')['code'] }} (-Rp
                                    {{ number_format($discount, 0, ',', '.') }})</span>
                                <form action="{{ route('cart.removeVoucher') }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="text-rose-500 hover:text-rose-700 font-bold text-xs hover:underline">Hapus</button>
                                </form>
                            </div>
                        @else
                            <form action="{{ route('cart.applyVoucher') }}" method="POST" class="flex gap-2">
                                @csrf
                                <input type="text" name="code" placeholder="Masukkan kode (misal: ENDORPHINE10)"
                                    class="w-full text-xs px-3.5 py-2.5 border border-slate-200 rounded-xl focus:outline-none focus:border-pink-500 uppercase font-bold text-slate-700 placeholder:font-normal placeholder:normal-case"
                                    required>
                                <button type="submit"
                                    class="bg-slate-800 hover:bg-pink-600 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition shadow-sm">Pakai</button>
                            </form>
                        @endif
                    </div>

                    <!-- Potongan Diskon -->
                    @if($discount > 0)
                        <div class="flex justify-between items-center text-sm text-emerald-600 font-bold pt-1">
                            <span>Potongan Voucher</span>
                            <span>-Rp {{ number_format($discount, 0, ',', '.') }}</span>
                        </div>
                    @endif

                    <!-- Total Pembayaran Akhir -->
                    <div class="border-t border-slate-100 pt-4 flex justify-between items-center">
                        <span class="font-bold text-slate-800 text-sm">Total Pembayaran</span>
                        <span class="font-black text-pink-600 text-xl">Rp
                            {{ number_format($finalTotal, 0, ',', '.') }}</span>
                    </div>

                    <a href="{{ route('checkout') }}"
                        class="relative z-20 mt-2 flex w-full items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-pink-500 via-rose-500 to-fuchsia-500 py-4 text-sm font-extrabold text-white shadow-[0_14px_28px_rgba(236,72,153,0.28)] ring-1 ring-pink-300/60 transition hover:-translate-y-0.5 hover:shadow-[0_18px_32px_rgba(236,72,153,0.38)]">
                        <span>Lanjut ke Checkout</span>
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"></path></svg>
                    </a>
                </div>
            </div>
        @else
            <div
                class="mx-auto my-8 max-w-md rounded-[1.75rem] border border-dashed border-pink-200 bg-white py-16 text-center shadow-[0_12px_30px_rgba(190,24,93,0.06)]">
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-pink-50 text-pink-500">
                    <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4h2l2.2 10.2a2 2 0 0 0 2 1.6h7.6a2 2 0 0 0 1.9-1.4L20 8H6M10 20a1 1 0 1 1-2 0 1 1 0 0 1 2 0Zm8 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0Z"></path></svg>
                </div>
                <h3 class="font-bold text-slate-800 text-base">Keranjangmu Masih Kosong</h3>
                <p class="text-slate-400 text-xs mt-1 mb-6">Yuk, pilih buket favoritmu di katalog dulu!</p>
                <a href="{{ route('home') }}"
                    class="inline-flex rounded-full bg-pink-600 px-5 py-3 text-xs font-extrabold text-white shadow-md shadow-pink-100 transition hover:-translate-y-0.5 hover:bg-pink-700">
                    Lihat Katalog Buket
                </a>
            </div>
        @endif
    </main>

    <!-- Footer Simple -->
    <footer class="bg-white border-t border-pink-100 py-6 text-center text-xs text-slate-400 mt-12">
        <p>&copy; {{ date('Y') }} Endorphine Florist. All rights reserved.</p>
    </footer>

</body>

</html>