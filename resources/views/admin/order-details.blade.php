<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-pink-600">Detail Pesanan</p>
                <h2 class="mt-1 text-xl font-black text-slate-800">#ORD-{{ $order->id }}</h2>
            </div>
            <a href="{{ route('admin.orders') }}"
                class="rounded-xl bg-slate-100 px-4 py-2 text-xs font-bold text-slate-600 transition hover:bg-pink-50 hover:text-pink-600">
                ← Kembali ke Pesanan
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto grid max-w-7xl grid-cols-1 gap-6 px-4 sm:px-6 lg:grid-cols-3 lg:px-8">
            <div class="space-y-6 lg:col-span-2">
                <section class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm">
                    <h3 class="mb-5 border-b border-slate-100 pb-4 text-base font-extrabold text-slate-800">Produk yang Dipesan</h3>
                    <div class="divide-y divide-slate-100">
                        @forelse($order->items as $item)
                            <div class="flex items-center justify-between gap-4 py-4 first:pt-0 last:pb-0">
                                <div>
                                    <p class="font-bold text-slate-800">{{ $item->product->name ?? 'Produk' }}</p>
                                    <p class="mt-1 text-xs text-slate-400">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>
                                <p class="font-black text-pink-600">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                            </div>
                        @empty
                            <p class="py-2 text-sm text-slate-500">Tidak ada detail produk pada pesanan ini.</p>
                        @endforelse
                    </div>
                </section>

                <section class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm">
                    <h3 class="mb-5 border-b border-slate-100 pb-4 text-base font-extrabold text-slate-800">Permintaan Pembeli</h3>
                    <div class="space-y-4">
                        <div class="rounded-2xl bg-amber-50 p-4">
                            <p class="text-xs font-bold uppercase tracking-wider text-amber-700">Pesan Kartu Ucapan</p>
                            <p class="mt-2 whitespace-pre-line text-sm leading-relaxed text-slate-700">{{ $order->greeting_card ?: 'Tidak ada pesan kartu ucapan.' }}</p>
                        </div>
                        <div>
                            <p class="mb-2 text-xs font-bold uppercase tracking-wider text-slate-400">Catatan per Produk</p>
                            <div class="space-y-2">
                                @forelse($order->items as $item)
                                    <div class="rounded-2xl bg-pink-50 p-4">
                                        <p class="font-bold text-slate-800">{{ $item->product->name ?? 'Produk' }}</p>
                                        <p class="mt-1 whitespace-pre-line text-sm leading-relaxed text-slate-700">{{ $item->note ?: 'Tidak ada permintaan khusus untuk produk ini.' }}</p>
                                    </div>
                                @empty
                                    <p class="text-sm text-slate-500">Tidak ada catatan produk.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <section class="h-fit rounded-3xl border border-slate-100 bg-white p-6 shadow-sm">
                <h3 class="mb-5 border-b border-slate-100 pb-4 text-base font-extrabold text-slate-800">Informasi Pembeli</h3>
                <dl class="space-y-4 text-sm">
                    <div>
                        <dt class="text-xs font-bold uppercase tracking-wider text-slate-400">Nama Pembeli</dt>
                        <dd class="mt-1 font-bold text-slate-800">{{ $order->customer_name ?? $order->user->name ?? 'Pelanggan' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-bold uppercase tracking-wider text-slate-400">No. WhatsApp</dt>
                        <dd class="mt-1 font-semibold text-slate-700">{{ $order->recipient_phone ?: '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-bold uppercase tracking-wider text-slate-400">Alamat Pengantaran</dt>
                        <dd class="mt-1 whitespace-pre-line leading-relaxed text-slate-700">{{ $order->shipping_address ?: 'Tidak ada alamat pengantaran.' }}</dd>
                    </div>
                    <div class="border-t border-slate-100 pt-4">
                        <dt class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Pembayaran</dt>
                        <dd class="mt-1 text-xl font-black text-pink-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</dd>
                        <dd class="mt-1 text-xs font-semibold text-slate-500">{{ $order->payment_method ?? '-' }}</dd>
                    </div>
                </dl>
            </section>
        </div>
    </div>
</x-app-layout>
