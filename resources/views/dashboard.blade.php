<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="font-extrabold text-2xl text-slate-800 leading-tight flex items-center gap-2">
                    🌸 Kasir & POS Dashboard
                </h2>
                <p class="text-xs text-slate-500 mt-1">
                    Kelola transaksi walk-in dan pemesanan buket Endorphine Florist dengan cepat.
                </p>
            </div>
            @if(in_array(auth()->user()->role, ['kasir', 'cashier', 'Kasir']))
                <a href="{{ route('cashier.pos') }}"
                    class="px-5 py-2.5 bg-pink-600 hover:bg-pink-700 text-white font-bold text-xs rounded-2xl shadow-md shadow-pink-200 transition flex items-center justify-center gap-2 w-full sm:w-auto">
                    <span>+</span> Buat Transaksi Baru (POS)
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-6 space-y-6">

        <!-- BANNER WELCOME PERSONAL -->
        <div
            class="bg-gradient-to-r from-slate-900 to-slate-800 text-white p-8 rounded-3xl shadow-lg flex items-center justify-between">
            <div>
                <span
                    class="px-3 py-1 bg-pink-500/20 text-pink-400 border border-pink-500/30 rounded-full text-xs font-bold uppercase tracking-wider">
                    Role: {{ auth()->user()->role }}
                </span>
                <h1 class="text-2xl sm:text-3xl font-extrabold mt-3">
                    Selamat Datang, {{ ucfirst(auth()->user()->role) }} {{ auth()->user()->name }}! 👋
                </h1>
                <p class="text-slate-400 mt-2 max-w-xl text-sm">
                    Sistem siap digunakan. Silakan pilih menu di sebelah kiri atau gunakan tombol akses cepat di bawah
                    untuk mulai bekerja.
                </p>
            </div>
            <div
                class="hidden md:flex w-16 h-16 rounded-2xl bg-pink-600 text-white items-center justify-center text-3xl font-bold shadow-md">
                🌸
            </div>
        </div>

        <!-- FITUR / SHORTCUT HANYA DITAMPILKAN JIKA KASIR -->
        @if(in_array(auth()->user()->role, ['kasir', 'cashier', 'Kasir']))

            <!-- RINGKASAN STATISTIK -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">TRANSAKSI HARI INI</span>
                    <p class="text-xl font-extrabold text-slate-800 mt-1">0 <span
                            class="text-xs font-normal text-slate-400">Order</span></p>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">TOTAL OMSET HARIAN</span>
                    <p class="text-xl font-extrabold text-pink-600 mt-1">Rp 0</p>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">PEMBAYARAN TUNAI</span>
                    <p class="text-xl font-extrabold text-emerald-600 mt-1">Rp 0</p>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">PEMBAYARAN TRANSFER & QRIS</span>
                    <p class="text-xl font-extrabold text-blue-600 mt-1">Rp 0</p>
                </div>
            </div>

            <!-- AKSES CEPAT SERVIS KASIR -->
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                <h3 class="text-base font-bold text-slate-800 mb-4">Pilih Layanan Kasir</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <a href="{{ route('cashier.pos') }}"
                        class="flex items-center gap-4 p-4 rounded-2xl border border-slate-200 hover:border-pink-500 hover:bg-pink-50/50 transition group">
                        <div
                            class="w-10 h-10 rounded-xl bg-pink-600 text-white flex items-center justify-center font-bold text-xl shadow-sm">
                            🛒</div>
                        <div>
                            <h4 class="font-bold text-slate-800 group-hover:text-pink-600 transition text-sm">POS Walk-In
                            </h4>
                            <p class="text-xs text-slate-500">Transaksi langsung di toko</p>
                        </div>
                    </a>
                    <a href="{{ route('cashier.orders') }}"
                        class="flex items-center gap-4 p-4 rounded-2xl border border-slate-200 hover:border-pink-500 hover:bg-pink-50/50 transition group">
                        <div
                            class="w-10 h-10 rounded-xl bg-slate-800 text-white flex items-center justify-center font-bold text-xl shadow-sm">
                            📦</div>
                        <div>
                            <h4 class="font-bold text-slate-800 group-hover:text-pink-600 transition text-sm">Daftar Orderan
                            </h4>
                            <p class="text-xs text-slate-500">Cek status pesanan masuk</p>
                        </div>
                    </a>
                    <a href="{{ route('cashier.recap') }}"
                        class="flex items-center gap-4 p-4 rounded-2xl border border-slate-200 hover:border-pink-500 hover:bg-pink-50/50 transition group">
                        <div
                            class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-bold text-xl shadow-sm">
                            📋</div>
                        <div>
                            <h4 class="font-bold text-slate-800 group-hover:text-pink-600 transition text-sm">Rekap Kas
                                Harian</h4>
                            <p class="text-xs text-slate-500">Laporan penutupan kasir</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- DAFTAR PEMESANAN MASUK -->
            <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm space-y-4">
                <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4">
                    <h3 class="font-bold text-slate-800 text-base">Daftar Pemesanan Masuk</h3>
                    <div class="relative w-full sm:w-72">
                        <input type="text" placeholder="Cari nomor order / pelanggan..."
                            class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-pink-500">
                    </div>
                </div>

                <!-- KONDISI KOSONG -->
                <div class="py-12 text-center text-slate-400 space-y-2">
                    <span class="text-3xl block">📫</span>
                    <p class="text-xs font-medium">Belum ada transaksi pesanan yang masuk.</p>
                </div>
            </div>

        @endif

    </div>
</x-app-layout>