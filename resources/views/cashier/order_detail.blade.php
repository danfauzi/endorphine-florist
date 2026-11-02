<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-pink-600">Detail Pemesanan</p>
                <h2 class="mt-1 text-xl font-black text-slate-800">#{{ $order->order_number }}</h2>
            </div>
            <a href="{{ route('kasir.orders') }}" class="rounded-xl bg-slate-100 px-4 py-2 text-xs font-bold text-slate-600 hover:bg-pink-50 hover:text-pink-600">← Kembali</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto grid max-w-7xl grid-cols-1 gap-6 px-4 sm:px-6 lg:grid-cols-3 lg:px-8">
            <div class="space-y-6 lg:col-span-2">
                <section class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm">
                    <h3 class="mb-5 border-b border-slate-100 pb-4 text-base font-extrabold text-slate-800">Produk yang Dipesan</h3>
                    <div class="divide-y divide-slate-100">
                        @foreach($order->items as $item)
                            <div class="flex items-center justify-between gap-4 py-4 first:pt-0 last:pb-0">
                                <div>
                                    <p class="font-bold text-slate-800">{{ $item->product->name ?? 'Produk' }}</p>
                                    <p class="mt-1 text-xs text-slate-400">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>
                                <p class="font-black text-pink-600">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                            </div>
                        @endforeach
                    </div>
                </section>

                <section class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm">
                    <h3 class="mb-4 border-b border-slate-100 pb-4 text-base font-extrabold text-slate-800">Catatan Pelanggan / Toko</h3>
                    <div class="rounded-2xl bg-amber-50 p-4 text-sm leading-relaxed text-slate-700">
                        {{ $order->greeting_card ?: 'Tidak ada catatan untuk pesanan ini.' }}
                    </div>
                </section>

                <section class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm">
                    <h3 class="mb-4 border-b border-slate-100 pb-4 text-base font-extrabold text-slate-800">Catatan Buket</h3>
                    <div class="space-y-3">
                        @forelse($order->items as $item)
                            <div class="rounded-2xl bg-pink-50 p-4 text-sm leading-relaxed text-slate-700">
                                <p class="font-bold text-slate-800">{{ $item->product->name ?? 'Produk' }}</p>
                                <p class="mt-1">{{ $item->note ?: 'Tidak ada catatan buket.' }}</p>
                            </div>
                        @empty
                            <div class="rounded-2xl bg-pink-50 p-4 text-sm leading-relaxed text-slate-700">
                                Tidak ada catatan buket.
                            </div>
                        @endforelse
                    </div>
                </section>
            </div>

            <section class="h-fit rounded-3xl border border-slate-100 bg-white p-6 shadow-sm">
                <h3 class="mb-5 border-b border-slate-100 pb-4 text-base font-extrabold text-slate-800">Informasi Pelanggan</h3>
                <dl class="space-y-4 text-sm">
                    <div>
                        <dt class="text-xs font-bold uppercase tracking-wider text-slate-400">Nama Pelanggan</dt>
                        <dd class="mt-1 font-bold text-slate-800">{{ $order->customer_name ?? $order->user->name ?? 'Pelanggan Walk-in' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-bold uppercase tracking-wider text-slate-400">No. WhatsApp</dt>
                        <dd class="mt-1 font-semibold text-slate-700">{{ $order->recipient_phone ?: '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-bold uppercase tracking-wider text-slate-400">Alamat Pengantaran</dt>
                        <dd class="mt-1 leading-relaxed text-slate-700">{{ $order->shipping_address ?: 'Tidak ada alamat pengantaran.' }}</dd>
                    </div>
                    <div class="border-t border-slate-100 pt-4">
                        <dt class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Pembayaran</dt>
                        <dd class="mt-1 text-xl font-black text-pink-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</dd>
                        <dd class="mt-1 text-xs font-semibold text-slate-500">{{ $order->payment_method }} · {{ $order->payment_status }}</dd>
                    </div>
                </dl>
            </section>
        </div>
    </div>
</x-app-layout>
