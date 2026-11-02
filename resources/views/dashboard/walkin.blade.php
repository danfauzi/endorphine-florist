<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS Kasir - Transaksi Walk-in</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="flex min-h-screen flex-col bg-[radial-gradient(circle_at_top_left,_#fff1f7,_transparent_34%),#f8fafc] text-slate-800">

    <!-- Header Navigasi -->
    <header class="sticky top-0 z-50 border-b border-pink-100/80 bg-white/85 shadow-[0_8px_24px_rgba(190,24,93,0.06)] backdrop-blur-md">
        <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-2">
                <span class="text-2xl">🌸</span>
                <span class="font-black text-pink-600 text-lg">POS Walk-in <span class="text-slate-800">Endorphine
                        Florist</span></span>
            </div>
            <a href="{{ route('kasir.orders') }}"
                class="group inline-flex items-center gap-2 rounded-full border border-pink-100 bg-pink-50 px-4 py-2.5 text-xs font-extrabold text-pink-600 shadow-sm transition hover:-translate-y-0.5 hover:bg-pink-100">
                <svg class="h-3.5 w-3.5 transition-transform group-hover:-translate-x-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m6 6-6-6 6-6"></path></svg>
                <span>Kembali ke Dashboard Kasir</span>
            </a>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="mx-auto grid w-full max-w-7xl flex-grow grid-cols-1 gap-7 px-4 py-7 sm:px-6 lg:grid-cols-12 lg:px-8"
        x-data="posSystem()">

        <!-- Kolom Kiri: Katalog Bunga/Produk -->
        <div class="lg:col-span-7 xl:col-span-8 space-y-4">
            <div class="flex items-center justify-between rounded-[1.5rem] border border-pink-100/70 bg-white p-5 shadow-[0_12px_28px_rgba(190,24,93,0.06)]">
                <div>
                    <h1 class="font-extrabold text-slate-800 text-base">Pilih Produk Florist</h1>
                    <p class="text-xs text-slate-400">Klik item untuk menambahkannya ke keranjang kasir.</p>
                </div>
            </div>

            <!-- Grid Produk -->
            <div class="grid grid-cols-2 gap-4 sm:grid-cols-3">
                @foreach($products as $product)
                    <div @click="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->price }})"
                        class="group flex cursor-pointer flex-col justify-between rounded-[1.5rem] border border-pink-100/70 bg-white p-3.5 shadow-[0_10px_24px_rgba(190,24,93,0.06)] transition duration-200 hover:-translate-y-1 hover:border-pink-300 hover:shadow-[0_16px_30px_rgba(236,72,153,0.14)] sm:p-4">
                        <div>
                            <div class="mb-3 flex h-32 w-full items-center justify-center overflow-hidden rounded-2xl bg-gradient-to-br from-pink-50 to-slate-50 p-2 sm:h-36">
                                @php
                                    $imgPath = $product->image ?? $product->image_url ?? $product->photo ?? '';
                                @endphp

                                <img src="{{ Str::startsWith($imgPath, ['http://', 'https://']) ? $imgPath : asset('storage/' . ltrim($imgPath, '/')) }}"
                                    alt="{{ $product->name }}"
                                    class="h-full w-full object-contain transition duration-300 group-hover:scale-[1.03]">
                            </div>
                            <h3 class="font-bold text-slate-800 text-xs sm:text-sm line-clamp-1">{{ $product->name }}</h3>
                            <p class="text-xs font-extrabold text-pink-600 mt-1">Rp
                                {{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>
                        <button type="button"
                            class="mt-3 w-full rounded-xl bg-pink-50 py-2 text-[11px] font-extrabold text-pink-600 transition hover:bg-pink-600 hover:text-white">
                            Tambah ke Transaksi
                        </button>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Kolom Kanan: Ringkasan Keranjang Walk-in -->
        <div class="lg:col-span-5 xl:col-span-4">
            <div class="sticky top-20 space-y-4 rounded-[1.75rem] border border-pink-100/70 bg-white p-6 shadow-[0_16px_34px_rgba(190,24,93,0.08)]">
                <div class="flex items-center gap-3 border-b border-slate-100 pb-3">
                    <div class="flex h-8 w-8 items-center justify-center rounded-xl bg-pink-50 text-pink-600">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4h2l2.2 10.2a2 2 0 0 0 2 1.6h7.6a2 2 0 0 0 1.9-1.4L20 8H6M10 20a1 1 0 1 1-2 0 1 1 0 0 1 2 0Zm8 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0Z"></path></svg>
                    </div>
                    <h2 class="font-extrabold text-slate-800 text-base">Ringkasan Transaksi Walk-in</h2>
                </div>

                <form method="POST" action="{{ route('kasir.walkin.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1">Nama Pembeli
                            Offline</label>
                        <input type="text" name="customer_name" placeholder="Pelanggan Walk-in"
                            value="Pelanggan Walk-in" required
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 p-3 text-xs font-semibold outline-none transition focus:border-pink-400 focus:bg-white focus:ring-4 focus:ring-pink-100">
                    </div>

                    <!-- Items Keranjang -->
                    <div class="max-h-56 overflow-y-auto space-y-2 pr-1">
                        <template x-if="cart.length === 0">
                            <div
                                class="text-xs text-slate-400 text-center py-8 border border-dashed border-slate-200 rounded-2xl">
                                Belum ada produk dipilih
                            </div>
                        </template>

                        <template x-for="(item, index) in cart" :key="item.id">
                            <div
                                class="flex items-center justify-between bg-slate-50 p-2.5 rounded-2xl border border-slate-100 text-xs">
                                <div class="flex-grow pr-2">
                                    <p class="font-bold text-slate-800" x-text="item.name"></p>
                                    <p class="text-[10px] text-pink-600 font-semibold"
                                        x-text="'Rp ' + (item.price * item.qty).toLocaleString('id-ID')"></p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button type="button" @click="decreaseQty(index)"
                                        class="w-6 h-6 bg-white border border-slate-200 rounded-lg text-xs font-bold text-slate-600 hover:bg-pink-50 hover:text-pink-600">-</button>
                                    <span class="font-bold text-xs" x-text="item.qty"></span>
                                    <button type="button" @click="increaseQty(index)"
                                        class="w-6 h-6 bg-white border border-slate-200 rounded-lg text-xs font-bold text-slate-600 hover:bg-pink-50 hover:text-pink-600">+</button>
                                </div>
                            </div>
                        </template>
                    </div>

                    <input type="hidden" name="cart_data" :value="JSON.stringify(cart)">

                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1">Metode
                            Pembayaran</label>
                        <select name="payment_method"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 p-3 text-xs font-semibold outline-none transition focus:border-pink-400 focus:bg-white focus:ring-4 focus:ring-pink-100">
                            <option value="Cash">Tunai / Cash</option>
                            <option value="QRIS">QRIS / Transfer Bank</option>
                        </select>
                    </div>

                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-600">Total Pembayaran:</span>
                        <span class="text-lg font-black text-pink-600"
                            x-text="'Rp ' + calculateTotal().toLocaleString('id-ID')"></span>
                    </div>

                    <button type="submit" :disabled="cart.length === 0"
                        class="w-full rounded-2xl bg-gradient-to-r from-pink-500 to-rose-500 py-3.5 text-xs font-extrabold text-white shadow-[0_12px_24px_rgba(236,72,153,0.24)] transition hover:-translate-y-0.5 hover:shadow-lg disabled:bg-slate-300">
                        Selesaikan & Simpan Transaksi
                    </button>
                </form>
            </div>
        </div>

    </main>

    <script>
        function posSystem() {
            return {
                cart: [],
                addToCart(id, name, price) {
                    let existing = this.cart.find(i => i.id === id);
                    if (existing) {
                        existing.qty++;
                    } else {
                        this.cart.push({ id, name, price, qty: 1 });
                    }
                },
                increaseQty(index) {
                    this.cart[index].qty++;
                },
                decreaseQty(index) {
                    if (this.cart[index].qty > 1) {
                        this.cart[index].qty--;
                    } else {
                        this.cart.splice(index, 1);
                    }
                },
                calculateTotal() {
                    return this.cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
                }
            }
        }
    </script>
</body>

</html>