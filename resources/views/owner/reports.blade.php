<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 leading-tight flex items-center gap-2">
            <span>📈</span> Laporan Omset & Keuangan Toko
        </h2>
    </x-slot>

    <div class="relative py-8 sm:py-10">
        <div class="pointer-events-none absolute inset-x-0 top-0 h-72 bg-gradient-to-b from-pink-50/70 via-white/20 to-transparent"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-7">

            <div class="bg-white/95 p-6 sm:p-7 rounded-[2rem] border border-slate-100 shadow-[0_12px_35px_rgba(15,23,42,0.06)] ring-1 ring-white">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <p class="text-[10px] font-extrabold uppercase tracking-[0.22em] text-pink-500">Filter Lapangan</p>
                        <h3 class="mt-1 text-xl font-black text-slate-800">Filter Laporan</h3>
                    </div>
                    <a href="{{ route('owner.reports.chart') }}?start_date={{ $startDate }}&end_date={{ $endDate }}"
                       class="inline-flex items-center justify-center bg-gradient-to-r from-pink-600 to-rose-500 hover:from-pink-700 hover:to-rose-600 text-white text-xs font-bold px-5 py-3 rounded-2xl transition duration-300 shadow-lg shadow-pink-200 hover:-translate-y-0.5">
                        📊 Lihat Grafik Omset
                    </a>
                </div>

                <form method="GET" action="{{ route('owner.reports') }}" class="mt-6 flex flex-wrap items-end gap-4 border-t border-slate-100 pt-5">
                    <div class="flex-1 min-w-[160px]">
                        <label class="block text-[10px] font-extrabold text-slate-500 uppercase tracking-wider mb-2">Tanggal Mulai</label>
                        <input type="date" name="start_date" value="{{ $startDate }}"
                            class="w-full text-xs font-semibold bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 focus:ring-2 focus:ring-pink-500 focus:border-pink-300 focus:outline-none transition">
                    </div>
                    <div class="flex-1 min-w-[160px]">
                        <label class="block text-[10px] font-extrabold text-slate-500 uppercase tracking-wider mb-2">Tanggal Selesai</label>
                        <input type="date" name="end_date" value="{{ $endDate }}"
                            class="w-full text-xs font-semibold bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 focus:ring-2 focus:ring-pink-500 focus:border-pink-300 focus:outline-none transition">
                    </div>
                    <button type="submit"
                        class="bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold px-5 py-3 rounded-2xl transition duration-300 shadow-md hover:-translate-y-0.5">
                        🔍 Filter Laporan
                    </button>
                </form>
            </div>

            <!-- Ringkasan Kartu Omset -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                <!-- Total Omset Keseluruhan -->
                <div class="bg-gradient-to-br from-slate-900 via-slate-900 to-slate-800 text-white p-6 rounded-3xl shadow-[0_16px_30px_rgba(15,23,42,0.18)] ring-1 ring-slate-700/30 relative overflow-hidden">
                    <span class="text-[10px] font-extrabold text-pink-400 uppercase tracking-[0.18em] block mb-2">Total Omset Bersih</span>
                    <h3 class="text-3xl font-black tracking-tight">Rp {{ number_format($totalOmset, 0, ',', '.') }}</h3>
                    <p class="text-slate-400 text-xs mt-2">Gabungan Penjualan Web & Toko</p>
                </div>

                <!-- Omset Penjualan Web -->
                <div class="bg-white/95 p-6 rounded-3xl border border-slate-100 shadow-[0_10px_25px_rgba(15,23,42,0.05)] hover:-translate-y-0.5 transition duration-300">
                    <span class="text-[10px] font-extrabold text-sky-500 uppercase tracking-[0.18em] block mb-2">🌐 Penjualan Web</span>
                    <h3 class="text-2xl font-black tracking-tight text-slate-800">Rp {{ number_format($omsetWeb, 0, ',', '.') }}</h3>
                    <p class="text-slate-400 text-xs mt-2">Pesanan Online Pelanggan</p>
                </div>

                <!-- Omset Penjualan Toko / Walk-in -->
                <div class="bg-white/95 p-6 rounded-3xl border border-slate-100 shadow-[0_10px_25px_rgba(15,23,42,0.05)] hover:-translate-y-0.5 transition duration-300">
                    <span class="text-[10px] font-extrabold text-emerald-500 uppercase tracking-[0.18em] block mb-2">🏪 Penjualan Toko (Walk-in)</span>
                    <h3 class="text-2xl font-black tracking-tight text-slate-800">Rp {{ number_format($omsetToko, 0, ',', '.') }}</h3>
                    <p class="text-slate-400 text-xs mt-2">Transaksi Langsung Kasir</p>
                </div>

            </div>

            <!-- Tabel Rincian Transaksi -->
            <div class="bg-white rounded-[2rem] border border-slate-100 shadow-[0_12px_35px_rgba(15,23,42,0.06)] overflow-hidden p-6 sm:p-7">
                <div class="flex items-center justify-between gap-4 mb-5">
                    <h4 class="font-black text-slate-800 text-base">Rincian Transaksi Terkonfirmasi</h4>
                    <span class="hidden sm:block text-[10px] font-bold uppercase tracking-[0.18em] text-slate-400">Data terbaru</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="border-b border-slate-100 text-slate-400 uppercase font-extrabold tracking-wider">
                                <th class="py-3 px-4">No. Order</th>
                                <th class="py-3 px-4">Tanggal</th>
                                <th class="py-3 px-4">Pelanggan / Kasir</th>
                                <th class="py-3 px-4">Metode Bayar</th>
                                <th class="py-3 px-4 text-right">Total Transaksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 text-slate-700 font-medium">
                            @forelse($orders as $order)
                                <tr class="hover:bg-pink-50/40 transition-colors">
                                    <td class="py-3.5 px-4 font-bold text-slate-800">#{{ $order->id }}</td>
                                    <td class="py-3.5 px-4">{{ $order->created_at->format('d M Y, H:i') }}</td>
                                    <td class="py-3.5 px-4">{{ $order->user->name ?? 'Pelanggan Umum (Walk-in)' }}</td>
                                    <td class="py-3.5 px-4">
                                        <span class="bg-slate-100 text-slate-600 px-2.5 py-1 rounded-full text-[10px] font-bold ring-1 ring-slate-200/70">
                                            {{ $order->payment_method ?? 'Cash' }}
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 text-right font-black text-pink-600">
                                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-8 text-center text-slate-400 italic">
                                        Belum ada data transaksi yang lunas pada periode ini.
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