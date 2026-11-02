<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 leading-tight flex items-center gap-2">
            <span>🏦</span> Kelola Rekening Bank Toko
        </h2>
    </x-slot>

    <div class="relative py-8 sm:py-10">
        <div class="pointer-events-none absolute inset-x-0 top-0 h-72 bg-gradient-to-b from-pink-50/70 via-white/20 to-transparent"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-7">

            @if(session('success'))
                <div class="flex items-center gap-3 rounded-2xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-xs font-bold text-emerald-700 shadow-sm">
                    <span class="flex h-7 w-7 items-center justify-center rounded-xl bg-white text-sm shadow-sm">✓</span>
                    ✅ {{ session('success') }}
                </div>
            @endif

            <!-- Form Tambah Rekening Baru -->
            <div class="rounded-[2rem] border border-white/80 bg-white/95 p-6 shadow-[0_14px_35px_rgba(15,23,42,0.07)] ring-1 ring-slate-100 sm:p-7">
                <div class="mb-6 flex items-start gap-3 border-b border-slate-100 pb-5">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-pink-50 text-lg text-pink-600 ring-1 ring-pink-100">＋</span>
                    <div>
                        <p class="text-[10px] font-extrabold uppercase tracking-[0.22em] text-pink-500">Metode pembayaran</p>
                        <h3 class="mt-1 font-black text-slate-800">Tambah Rekening Bank / E-Wallet Baru</h3>
                        <p class="mt-1 text-xs text-slate-400">Tambahkan rekening toko atau QRIS untuk kebutuhan pembayaran pelanggan.</p>
                    </div>
                </div>
                <form action="{{ route('admin.bank_accounts.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 items-end gap-4 md:grid-cols-2 xl:grid-cols-5">
                    @csrf
                    <div class="xl:col-span-1">
                        <label class="mb-2 block text-[10px] font-extrabold uppercase tracking-wider text-slate-500">Nama Bank</label>
                        <input id="bank-name" type="text" name="bank_name" placeholder="Contoh: BCA / Mandiri"
                            class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-xs font-semibold transition focus:border-pink-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-pink-100">
                    </div>
                    <div id="account-number-field" class="xl:col-span-1">
                        <label class="mb-2 block text-[10px] font-extrabold uppercase tracking-wider text-slate-500">Nomor Rekening</label>
                        <input id="account-number" type="text" name="account_number" placeholder="Contoh: 1234567890"
                            class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-xs font-semibold transition focus:border-pink-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-pink-100">
                    </div>
                    <div class="xl:col-span-1">
                        <label class="mb-2 block text-[10px] font-extrabold uppercase tracking-wider text-slate-500">Atas Nama (A/N)</label>
                        <input type="text" name="account_holder" required placeholder="Contoh: Endorphine Florist"
                            class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-xs font-semibold transition focus:border-pink-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-pink-100">
                    </div>
                    <div class="xl:col-span-1">
                            <label class="mb-2 block text-[10px] font-extrabold uppercase tracking-wider text-slate-500">Foto QRIS (Opsional)</label>
                            <input type="file" name="qris_image" accept="image/jpeg,image/png,image/webp"
                            class="w-full min-w-0 rounded-2xl border border-slate-200 bg-slate-50 px-3 py-3 text-[11px] font-semibold text-slate-500 transition file:mr-3 file:rounded-lg file:border-0 file:bg-pink-50 file:px-2 file:py-1 file:text-[10px] file:font-bold file:text-pink-600 hover:border-pink-200">
                            </div>
                    <div class="xl:col-span-1">
                        <button type="submit"
                            class="w-full rounded-2xl bg-gradient-to-r from-pink-600 to-rose-500 py-3 text-xs font-extrabold text-white shadow-lg shadow-pink-200 transition duration-300 hover:-translate-y-0.5 hover:from-pink-700 hover:to-rose-600">
                            Simpan Rekening
                        </button>
                    </div>
                </form>
                <script>
                    const bankNameInput = document.getElementById('bank-name');
                    const accountNumberInput = document.getElementById('account-number');
                    const qrisImageInput = document.querySelector('input[name="qris_image"]');

                    function toggleQrisFields() {
                        const isQris = qrisImageInput.files.length > 0;
                        bankNameInput.required = !isQris;
                        accountNumberInput.required = !isQris;
                    }

                    bankNameInput.addEventListener('input', toggleQrisFields);
                    qrisImageInput.addEventListener('change', toggleQrisFields);
                    toggleQrisFields();
                </script>
            </div>

            <!-- Tabel Daftar Rekening -->
            <div class="overflow-hidden rounded-[2rem] border border-slate-100 bg-white shadow-[0_14px_35px_rgba(15,23,42,0.06)] p-6 sm:p-7">
                <div class="mb-5 flex items-center justify-between gap-4">
                    <div>
                        <p class="text-[10px] font-extrabold uppercase tracking-[0.22em] text-slate-400">Pembayaran toko</p>
                        <h3 class="mt-1 font-black text-slate-800">Daftar Rekening Aktif Toko</h3>
                    </div>
                    <span class="hidden rounded-full bg-emerald-50 px-3 py-1 text-[10px] font-bold text-emerald-600 sm:block">Terkelola admin</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="border-b border-slate-100 text-slate-400 uppercase font-extrabold tracking-wider">
                                <th class="py-3 px-4">Bank / Layanan</th>
                                <th class="py-3 px-4">Nomor Rekening</th>
                                <th class="py-3 px-4">Atas Nama</th>
                                <th class="py-3 px-4">QRIS</th>
                                <th class="py-3 px-4 text-center">Status</th>
                                <th class="py-3 px-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 text-slate-700 font-medium">
                            @forelse($accounts as $acc)
                                <tr class="hover:bg-pink-50/40 transition-colors">
                                    <td class="py-3.5 px-4 font-bold text-slate-800">{{ $acc->bank_name }}</td>
                                    <td class="py-3.5 px-4 font-mono font-bold">{{ $acc->account_number }}</td>
                                    <td class="py-3.5 px-4">{{ $acc->account_holder }}</td>
                                    <td class="py-3.5 px-4">
                                        @if($acc->qris_image)
                                            <img src="{{ asset('storage/' . $acc->qris_image) }}" alt="QRIS {{ $acc->bank_name }}" class="h-16 w-16 rounded-2xl border border-slate-200 object-cover shadow-sm">
                                        @else
                                            <span class="text-[11px] text-slate-400">Tidak ada</span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-4 text-center">
                                        <form action="{{ route('admin.bank_accounts.toggle', $acc->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="px-3 py-1 rounded-full text-[10px] font-bold {{ $acc->is_active ? 'bg-emerald-50 text-emerald-600 border border-emerald-200' : 'bg-slate-100 text-slate-500' }}">
                                                {{ $acc->is_active ? 'Aktif' : 'Nonaktif' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td class="py-3.5 px-4 text-right">
                                        <form action="{{ route('admin.bank_accounts.destroy', $acc->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Hapus rekening ini?')"
                                                class="bg-rose-50 hover:bg-rose-500 hover:text-white text-rose-600 px-3 py-1.5 rounded-xl font-bold transition">
                                                🗑️ Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-8 text-center text-slate-400 italic">
                                        Belum ada rekening bank yang ditambahkan oleh owner.
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