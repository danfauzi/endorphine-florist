<x-app-layout>
    <x-slot name="header">
        <h2 class="flex items-center gap-3 text-2xl font-black leading-tight text-slate-800">
            <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-pink-50 text-pink-500 shadow-sm">🌸</span>
            <span>Dashboard Admin</span>
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-7 px-4 sm:px-6 lg:px-8">

            <!-- Banner Selamat Datang Ala Kasir -->
            <div
                class="relative flex flex-col items-start justify-between gap-6 overflow-hidden rounded-[1.75rem] bg-[radial-gradient(circle_at_top_right,_#334155,_transparent_45%),linear-gradient(115deg,#0f172a,#1e293b)] p-7 text-white shadow-[0_18px_35px_rgba(15,23,42,0.18)] md:flex-row md:items-center sm:p-8">
                <div class="pointer-events-none absolute -right-12 -top-16 h-44 w-44 rounded-full border border-pink-300/10"></div>
                <div class="pointer-events-none absolute -bottom-20 right-24 h-44 w-44 rounded-full border border-white/5"></div>
                <div class="relative z-10 space-y-2">
                    <span
                        class="rounded-full border border-pink-400/30 bg-pink-500/15 px-3 py-1 text-xs font-extrabold uppercase tracking-wider text-pink-300">
                        Role: Administrator
                    </span>
                    <h1 class="text-2xl font-black tracking-tight sm:text-3xl">
                        Selamat Datang, {{ auth()->user()->name }}!
                    </h1>
                    <p class="max-w-xl text-sm leading-relaxed text-slate-400">
                        Sistem manajemen toko Endorphine Florist siap digunakan. Silakan pilih menu di sebelah kiri atau
                        gunakan tombol akses cepat di bawah untuk mengelola operasional toko.
                    </p>
                </div>
                <div
                    class="relative z-10 flex h-16 w-16 flex-shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-pink-500 to-rose-600 text-3xl shadow-[0_12px_24px_rgba(236,72,153,0.28)]">
                    🌸
                </div>
            </div>

            <!-- Bagian Akses Cepat Layanan Admin -->
            <div>
                <h3 class="mb-4 px-1 text-xs font-extrabold uppercase tracking-[0.16em] text-slate-400">Akses Cepat Layanan Admin
                </h3>

                <div class="grid grid-cols-1 gap-5 md:grid-cols-3">

                    <!-- Shortcut 1: Kelola Pesanan -->
                    <a href="{{ route('admin.orders') }}"
                        class="group block rounded-[1.5rem] border border-pink-100/70 bg-white p-6 shadow-[0_12px_28px_rgba(190,24,93,0.06)] transition duration-200 hover:-translate-y-1 hover:border-pink-300 hover:shadow-[0_18px_34px_rgba(236,72,153,0.14)]">
                        <div
                            class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-pink-50 text-pink-600 shadow-sm transition group-hover:scale-110 group-hover:bg-pink-600 group-hover:text-white">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m4 7 8-4 8 4v10l-8 4-8-4zM4 7l8 4 8-4M12 11v10"></path></svg>
                        </div>
                        <h4 class="font-bold text-slate-800 text-base mb-1">Kelola Pesanan</h4>
                        <p class="text-xs text-slate-400">Pantau dan verifikasi status orderan masuk dari pelanggan.</p>
                    </a>

                    <!-- Shortcut 2: Katalog Produk -->
                    <a href="{{ route('products.index') }}"
                        class="group block rounded-[1.5rem] border border-pink-100/70 bg-white p-6 shadow-[0_12px_28px_rgba(190,24,93,0.06)] transition duration-200 hover:-translate-y-1 hover:border-pink-300 hover:shadow-[0_18px_34px_rgba(236,72,153,0.14)]">
                        <div
                            class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-pink-50 text-pink-600 shadow-sm transition group-hover:scale-110 group-hover:bg-pink-600 group-hover:text-white">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21V9m0 0c-4 0-6-2.5-6-5 3 0 6 1.5 6 5Zm0 0c4 0 6-2.5 6-5-3 0-6 1.5-6 5Z"></path></svg>
                        </div>
                        <h4 class="font-bold text-slate-800 text-base mb-1">Kelola Produk</h4>
                        <p class="text-xs text-slate-400">Tambah, ubah harga, atau atur stok buket bunga toko.</p>
                    </a>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>