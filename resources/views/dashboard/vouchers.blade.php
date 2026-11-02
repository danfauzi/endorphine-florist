<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight flex items-center gap-2">
                    🎫 Manajemen Voucher Promo
                </h2>
                <p class="text-xs text-slate-500 mt-0.5">Atur kode diskon & promo khusus pelanggan Endorphine Florist.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-2xl text-xs font-bold">
                ✅ {{ session('success') }}
            </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <!-- FORM TAMBAH VOUCHER -->
                <div class="lg:col-span-4 bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
                    <h3 class="font-extrabold text-slate-800 text-base mb-4 flex items-center gap-2">
                        ➕ Buat Voucher Baru
                    </h3>
                    <form action="{{ route('admin.vouchers.store') }}" method="POST" class="space-y-4 text-xs">
                        @csrf
                        <div>
                            <label class="block font-bold text-slate-600 uppercase mb-1">Kode Voucher</label>
                            <input type="text" name="code" placeholder="Contoh: ENDORPHINE10" class="w-full font-bold uppercase border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-pink-500/20 focus:border-pink-500" required>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block font-bold text-slate-600 uppercase mb-1">Tipe Diskon</label>
                                <select name="type" class="w-full font-semibold border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-pink-500/20 focus:border-pink-500">
                                    <option value="fixed">Nominal (Rp)</option>
                                    <option value="percent">Persentase (%)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block font-bold text-slate-600 uppercase mb-1">Nilai Diskon</label>
                                <input type="number" name="discount_value" placeholder="10000 atau 10" class="w-full font-semibold border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-pink-500/20 focus:border-pink-500" required>
                            </div>
                        </div>

                        <div>
                            <label class="block font-bold text-slate-600 uppercase mb-1">Min. Belanja (Rp)</label>
                            <input type="number" name="min_order_price" placeholder="0 jika tidak ada minimal" class="w-full font-semibold border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-pink-500/20 focus:border-pink-500">
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block font-bold text-slate-600 uppercase mb-1">Kuota Pakai</label>
                                <input type="number" name="quota" placeholder="50" class="w-full font-semibold border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-pink-500/20 focus:border-pink-500" required>
                            </div>
                            <div>
                                <label class="block font-bold text-slate-600 uppercase mb-1">Berlaku Sampai</label>
                                <input type="date" name="expired_date" class="w-full font-semibold border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-pink-500/20 focus:border-pink-500" required>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-pink-600 hover:bg-pink-700 text-white font-extrabold py-3 rounded-xl shadow-md transition">
                            Simpan Voucher
                        </button>
                    </form>
                </div>

                <!-- TABEL DAFTAR VOUCHER -->
                <div class="lg:col-span-8 bg-white p-6 rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                    <h3 class="font-extrabold text-slate-800 text-base mb-4">
                        📋 Daftar Voucher Aktif & Kadaluarsa
                    </h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="bg-slate-50 text-slate-400 uppercase tracking-wider font-semibold border-b border-slate-100">
                                    <th class="p-3">Kode Promo</th>
                                    <th class="p-3">Diskon</th>
                                    <th class="p-3">Min. Order</th>
                                    <th class="p-3">Kuota</th>
                                    <th class="p-3">Expired</th>
                                    <th class="p-3 text-center">Status</th>
                                    <th class="p-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($vouchers as $v)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="p-3 font-black text-pink-600">{{ $v->code }}</td>
                                    <td class="p-3 font-bold text-slate-800">
                                        {{ $v->type == 'fixed' ? 'Rp ' . number_format($v->discount_value, 0, ',', '.') : $v->discount_value . '%' }}
                                    </td>
                                    <td class="p-3 text-slate-500">Rp {{ number_format($v->min_order_price, 0, ',', '.') }}</td>
                                    <td class="p-3 font-semibold text-slate-700">{{ $v->quota }}x</td>
                                    <td class="p-3 text-slate-500">{{ $v->expired_date ? $v->expired_date->format('d/m/Y') : '-' }}</td>
                                    <td class="p-3 text-center">
                                        <form action="{{ route('admin.vouchers.toggle', $v->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="px-2.5 py-1 rounded-full font-bold text-[10px] uppercase {{ $v->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                                                {{ $v->is_active ? 'Aktif' : 'Non-Aktif' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td class="p-3 text-center">
                                        <form action="{{ route('admin.vouchers.destroy', $v->id) }}" method="POST" onsubmit="return confirm('Hapus voucher ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-rose-600 hover:text-rose-800 font-bold text-xs">
                                                🗑️ Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="p-6 text-center text-slate-400">Belum ada voucher promo yang dibuat.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>