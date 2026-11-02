<x-app-layout>
    <x-slot name="header">
        <h2 class="flex items-center gap-3 text-2xl font-black leading-tight text-slate-800">
            <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-pink-50 text-pink-500 shadow-sm">📦</span>
            <span>Kelola Pesanan Masuk</span>
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div
                    class="mb-6 flex items-center gap-2 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-semibold text-emerald-800 shadow-sm">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m5 12 4 4L19 6"></path></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="overflow-hidden rounded-[1.75rem] border border-pink-100/70 bg-white shadow-[0_18px_40px_rgba(190,24,93,0.08)]">
                <div class="flex items-center justify-between gap-4 border-b border-slate-100 bg-gradient-to-r from-white to-pink-50/40 p-6">
                    <div>
                        <h3 class="text-lg font-extrabold tracking-tight text-slate-800">Daftar Transaksi & Orderan</h3>
                        <p class="mt-1 text-xs leading-relaxed text-slate-400">Lihat produk yang dipesan dan permintaan pelanggan.</p>
                    </div>
                    <span
                        class="shrink-0 rounded-full border border-pink-100 bg-pink-50 px-3 py-1.5 text-xs font-extrabold text-pink-600">
                        {{ $orders->count() }} Total Pesanan
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-[900px] w-full border-collapse text-left">
                        <thead>
                            <tr
                                class="border-b border-slate-100 bg-slate-50/80 text-[11px] font-extrabold uppercase tracking-wider text-slate-400">
                                <th class="w-[210px] px-5 py-4">ID / Pemesan</th>
                                <th class="w-[300px] px-5 py-4">Detail Produk</th>
                                <th class="w-[170px] px-5 py-4">Total Harga</th>
                                <th class="w-[200px] px-5 py-4 text-center">Detail Pesanan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            @forelse($orders as $order)
                                <tr class="align-middle transition-colors hover:bg-pink-50/25">
                                    <td class="px-5 py-5">
                                        <p class="font-black text-pink-600">#ORD-{{ $order->id }}</p>
                                        <p class="mt-1 font-semibold text-slate-700">{{ $order->customer_name ?? $order->user->name ?? 'Guest / Walk-in' }}</p>
                                        <span class="mt-1 block text-[10px] text-slate-400">{{ $order->created_at->format('d M Y, H:i') }}</span>
                                    </td>

                                    <td class="px-5 py-5">
                                        <div class="space-y-2">
                                            @foreach($order->items as $item)
                                                <div class="flex items-center gap-2 rounded-xl bg-slate-50/80 px-3 py-2 text-xs text-slate-600">
                                                    <span class="font-extrabold text-pink-600">{{ $item->quantity }}x</span>
                                                    <span class="font-medium">{{ $item->product->name ?? 'Produk' }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>

                                    <td class="px-5 py-5 font-black text-lg text-pink-600">
                                        Rp {{ number_format($order->total_price ?? $order->grand_total, 0, ',', '.') }}
                                    </td>

                                    <td class="px-5 py-5 text-center">
                                        <a href="{{ route('admin.orders.show', $order) }}"
                                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-pink-50 px-4 py-2.5 text-xs font-bold text-pink-600 transition hover:bg-pink-100">
                                            🔎 Detail Pesanan
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-16 text-slate-400 text-sm">
                                        Belum ada data pesanan masuk.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>