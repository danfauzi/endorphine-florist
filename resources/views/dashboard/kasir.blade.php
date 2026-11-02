<x-app-layout>
    <x-slot name="header">
        <h2 class="flex items-center gap-3 text-2xl font-black leading-tight text-slate-800">
            <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-pink-50 text-pink-500 shadow-sm">🌸</span>
            <span>Dashboard Kasir</span>
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-7 sm:px-6 lg:px-8">

            <!-- BANNER WELCOME PERSONAL -->
            <div class="relative flex items-center justify-between overflow-hidden rounded-[1.75rem] bg-[radial-gradient(circle_at_top_right,_#334155,_transparent_45%),linear-gradient(115deg,#0f172a,#1e293b)] p-7 text-white shadow-[0_18px_35px_rgba(15,23,42,0.18)] sm:p-8">
                <div class="pointer-events-none absolute -right-12 -top-16 h-44 w-44 rounded-full border border-pink-300/10"></div>
                <div class="pointer-events-none absolute -bottom-20 right-24 h-44 w-44 rounded-full border border-white/5"></div>
                <div>
                    <span class="rounded-full border border-pink-400/30 bg-pink-500/15 px-3 py-1 text-xs font-extrabold uppercase tracking-wider text-pink-300">
                        Role: {{ auth()->user()->role ?? 'Kasir' }}
                    </span>
                    <h1 class="mt-4 text-2xl font-black tracking-tight sm:text-3xl">
                        Selamat Datang, Kasir {{ auth()->user()->name }}!
                    </h1>
                    <p class="mt-2 max-w-xl text-sm leading-relaxed text-slate-400">
                        Sistem kasir siap digunakan. Silakan pilih menu di sebelah kiri atau gunakan tombol akses cepat di bawah untuk mulai bekerja.
                    </p>
                </div>
                <div class="hidden h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-pink-500 to-rose-600 text-3xl font-bold shadow-[0_12px_24px_rgba(236,72,153,0.28)] md:flex">
                    🌸
                </div>
            </div>

            <!-- AKSES CEPAT LAYANAN KASIR (DIBUAT BISA DIKLIK) -->
            <div class="space-y-4">
                <h3 class="px-1 text-base font-extrabold tracking-tight text-slate-800">Akses Cepat Layanan Kasir</h3>
                
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    
                    <!-- 1. Card POS Walk-In -->
                    <a href="{{ route('kasir.pos') }}" class="group flex items-center gap-4 rounded-[1.5rem] border border-pink-100/70 bg-white p-5 shadow-[0_10px_24px_rgba(190,24,93,0.06)] transition duration-200 hover:-translate-y-1 hover:border-pink-300 hover:shadow-[0_16px_30px_rgba(236,72,153,0.14)]">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-pink-50 text-pink-600 shadow-sm transition group-hover:bg-pink-600 group-hover:text-white">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4h2l2.2 10.2a2 2 0 0 0 2 1.6h7.6a2 2 0 0 0 1.9-1.4L20 8H6M10 20a1 1 0 1 1-2 0 1 1 0 0 1 2 0Zm8 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0Z"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-800 group-hover:text-pink-600 transition text-sm">POS Walk-In</h4>
                            <p class="text-xs text-slate-400 mt-0.5">Transaksi langsung di toko</p>
                        </div>
                    </a>

                    <!-- 2. Card Daftar Orderan -->
                    <a href="{{ route('kasir.orders') }}" class="group flex items-center gap-4 rounded-[1.5rem] border border-slate-200/80 bg-white p-5 shadow-[0_10px_24px_rgba(15,23,42,0.06)] transition duration-200 hover:-translate-y-1 hover:border-slate-300 hover:shadow-[0_16px_30px_rgba(15,23,42,0.12)]">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100 text-slate-800 shadow-sm transition group-hover:bg-slate-900 group-hover:text-white">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m4 7 8-4 8 4v10l-8 4-8-4zM4 7l8 4 8-4M12 11v10"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-800 group-hover:text-slate-900 transition text-sm">Daftar Orderan</h4>
                            <p class="text-xs text-slate-400 mt-0.5">Cek status pesanan masuk</p>
                        </div>
                    </a>

                    <!-- 3. Card Rekap Kas Harian -->
                    <a href="{{ route('kasir.recap') }}" class="group flex items-center gap-4 rounded-[1.5rem] border border-emerald-100/80 bg-white p-5 shadow-[0_10px_24px_rgba(16,185,129,0.06)] transition duration-200 hover:-translate-y-1 hover:border-emerald-300 hover:shadow-[0_16px_30px_rgba(16,185,129,0.13)]">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600 shadow-sm transition group-hover:bg-emerald-600 group-hover:text-white">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 3h9l3 3v15H6zM14 3v4h4M9 12h6M9 16h4"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-800 group-hover:text-emerald-600 transition text-sm">Rekap Kas Harian</h4>
                            <p class="text-xs text-slate-400 mt-0.5">Laporan penutupan kasir</p>
                        </div>
                    </a>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>