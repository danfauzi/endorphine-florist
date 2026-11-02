<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 leading-tight flex items-center gap-2">
            👑 Executive Dashboard <span class="text-pink-600">Owner</span>
        </h2>
    </x-slot>

    <div class="relative py-8 sm:py-10">
        <div class="pointer-events-none absolute inset-x-0 top-0 h-64 bg-gradient-to-b from-pink-50/70 via-white/20 to-transparent"></div>
        <div class="relative max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- BANNER SELAMAT DATANG (WELCOME MESSAGE) OWNER -->
            <div class="relative overflow-hidden bg-gradient-to-r from-pink-600 via-rose-500 to-purple-600 rounded-[2rem] p-6 sm:p-9 text-white shadow-[0_18px_45px_rgba(225,29,72,0.24)] ring-1 ring-white/20">
                <!-- Hiasan Background Pattern -->
                <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
                <div class="absolute right-20 -top-10 w-32 h-32 bg-pink-400/20 rounded-full blur-xl pointer-events-none"></div>

                <div class="relative z-10 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
                    <div class="space-y-2">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/20 backdrop-blur-md text-xs font-semibold tracking-wide text-pink-100">
                            <span>👑</span> Akses Pemilik (Owner)
                        </div>
                        <h1 class="text-2xl sm:text-3xl font-black tracking-tight drop-shadow-sm">
                            Selamat Datang Kembali, {{ Auth::user()->name }}! 👋
                        </h1>
                        <p class="text-sm text-pink-100/90 max-w-xl">
                            Pilih menu *shortcut* di bawah untuk langsung mengelola voucher promo atau mengunduh laporan keuangan Endorphine Florist.
                        </p>
                    </div>

                    <!-- Tanggal Hari Ini -->
                    <div class="bg-white/10 backdrop-blur-md px-4 py-3 rounded-2xl border border-white/25 text-xs font-semibold self-stretch sm:self-auto flex items-center justify-center gap-2 shrink-0 shadow-inner shadow-white/10">
                        <span>📅</span> {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                    </div>
                </div>
            </div>

            <!-- GRID SHORTCUT UTAMA OWNER -->
            <div>
                <div class="flex items-end justify-between gap-4 mb-4">
                    <h3 class="font-extrabold text-slate-800 text-lg flex items-center gap-2">
                    ⚡ Shortcut Fitur Utama
                    </h3>
                    <span class="hidden sm:block text-[10px] font-bold uppercase tracking-[0.2em] text-slate-400">Akses cepat</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                    <!-- Shortcut Export PDF Laporan -->
                          <div
                       class="group bg-white/95 p-6 rounded-3xl border border-slate-100 shadow-[0_8px_24px_rgba(15,23,42,0.05)] hover:-translate-y-1 hover:shadow-[0_16px_30px_rgba(236,72,153,0.12)] hover:border-pink-200 transition-all duration-300 flex min-h-[232px] flex-col justify-between space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="w-12 h-12 rounded-2xl bg-pink-50 text-pink-600 ring-1 ring-pink-100 flex items-center justify-center text-2xl group-hover:scale-110 group-hover:rotate-3 transition-transform">
                                📄
                            </div>
                            <span class="text-xs font-bold text-pink-600 bg-pink-50 px-3 py-1 rounded-full">Laporan PDF</span>
                        </div>
                        <div>
                            <h4 class="font-black text-slate-800 text-lg group-hover:text-pink-600 transition-colors">
                                Export Laporan PDF
                            </h4>
                            <p class="text-xs text-slate-400 mt-1">
                                Unduh ringkasan rekap keuangan & omset dalam format dokumen PDF siap cetak.
                            </p>
                        </div>
                        <form method="GET" action="{{ route('owner.export.pdf') }}" class="space-y-3 pt-2">
                            <div class="grid grid-cols-2 gap-2">
                                <label class="text-[10px] font-bold text-slate-400">
                                    Mulai
                                    <input type="date" name="start_date" value="{{ \Carbon\Carbon::now()->startOfMonth()->toDateString() }}" required class="mt-1 w-full rounded-xl border border-slate-200 bg-slate-50 px-2 py-2 text-[10px] font-semibold text-slate-600 focus:border-pink-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-pink-100">
                                </label>
                                <label class="text-[10px] font-bold text-slate-400">
                                    Selesai
                                    <input type="date" name="end_date" value="{{ \Carbon\Carbon::now()->toDateString() }}" required class="mt-1 w-full rounded-xl border border-slate-200 bg-slate-50 px-2 py-2 text-[10px] font-semibold text-slate-600 focus:border-pink-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-pink-100">
                                </label>
                            </div>
                            <button type="submit" class="flex items-center text-xs font-bold text-pink-600 transition-colors group-hover:text-pink-700">
                                <span>Unduh Berkas</span>
                                <span class="ml-1 transition-transform group-hover:translate-x-1">↓</span>
                            </button>
                        </form>
                    </div>

                    <!-- Shortcut Export Excel Laporan -->
                          <div
                       class="group bg-white/95 p-6 rounded-3xl border border-slate-100 shadow-[0_8px_24px_rgba(15,23,42,0.05)] hover:-translate-y-1 hover:shadow-[0_16px_30px_rgba(16,185,129,0.12)] hover:border-emerald-200 transition-all duration-300 flex min-h-[232px] flex-col justify-between space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 ring-1 ring-emerald-100 flex items-center justify-center text-2xl group-hover:scale-110 group-hover:rotate-3 transition-transform">
                                📊
                            </div>
                            <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full">Laporan Excel</span>
                        </div>
                        <div>
                            <h4 class="font-black text-slate-800 text-lg group-hover:text-emerald-600 transition-colors">
                                Export Laporan Excel
                            </h4>
                            <p class="text-xs text-slate-400 mt-1">
                                Unduh rekap transaksi mentah spreadsheet untuk analisis data lanjutan.
                            </p>
                        </div>
                        <form method="GET" action="{{ route('owner.export.excel') }}" class="space-y-3 pt-2">
                            <div class="grid grid-cols-2 gap-2">
                                <label class="text-[10px] font-bold text-slate-400">
                                    Mulai
                                    <input type="date" name="start_date" value="{{ \Carbon\Carbon::now()->startOfMonth()->toDateString() }}" required class="mt-1 w-full rounded-xl border border-slate-200 bg-slate-50 px-2 py-2 text-[10px] font-semibold text-slate-600 focus:border-emerald-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-100">
                                </label>
                                <label class="text-[10px] font-bold text-slate-400">
                                    Selesai
                                    <input type="date" name="end_date" value="{{ \Carbon\Carbon::now()->toDateString() }}" required class="mt-1 w-full rounded-xl border border-slate-200 bg-slate-50 px-2 py-2 text-[10px] font-semibold text-slate-600 focus:border-emerald-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-100">
                                </label>
                            </div>
                            <button type="submit" class="flex items-center text-xs font-bold text-emerald-600 transition-colors group-hover:text-emerald-700">
                                <span>Unduh Spreadsheet</span>
                                <span class="ml-1 transition-transform group-hover:translate-x-1">↓</span>
                            </button>
                        </form>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>