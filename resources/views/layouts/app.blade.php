<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Endorphine Florist') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-slate-100">

    <!-- Wrapper Alpine.js untuk State Sidebar -->
    <div x-data="{ expanded: false }" class="flex h-screen overflow-hidden">

        <!-- SIDEBAR MINI + HOVER EXPAND -->
        <aside @mouseenter="expanded = true" @mouseleave="expanded = false"
            class="fixed left-0 top-0 z-40 flex h-screen flex-col justify-between bg-[#0d1629] text-slate-300 shadow-[8px_0_30px_rgba(15,23,42,0.12)] transition-all duration-300 ease-in-out"
            :class="expanded ? 'w-64' : 'w-16'">

            <div>
                <!-- LOGO / BRAND SIDEBAR (Bisa diklik kembali ke dashboard) -->
                <a href="{{ route('dashboard') }}"
                    class="group flex items-center gap-3 border-b border-white/5 px-3 py-5 transition-opacity hover:opacity-90">
                    <!-- Icon/Logo Bunga "E" -->
                    <div
                        class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-pink-500 to-rose-600 text-xl font-black text-white shadow-[0_8px_18px_rgba(236,72,153,0.28)]">
                        E
                    </div>

                    <!-- Nama Brand -->
                        <span x-show="expanded" class="whitespace-nowrap text-lg font-extrabold tracking-wide text-white">
                        Endorphine
                    </span>
                </a>

                <!-- NAVIGASI OTOMATIS BERDASARKAN ROLE -->
                <nav class="mt-5 space-y-1.5 px-2">
                    @auth
                        <!-- MENU OWNER -->
                        @if(in_array(auth()->user()->role, ['owner', 'Owner']))
                            <a href="{{ route('owner.dashboard') }}"
                                class="group flex items-center gap-4 rounded-2xl px-3 py-3 text-slate-400 transition-colors hover:bg-white/5 hover:text-pink-300">
                                <span class="flex-shrink-0 text-xl">📊</span>
                                <span x-show="expanded" class="whitespace-nowrap text-sm font-semibold">Dashboard KPI</span>
                            </a>

                            <!-- Pakai '#' sementara untuk Laporan Omset -->
                            <a href="{{ route('owner.reports') }}"
                                class="flex items-center gap-4 rounded-2xl px-3 py-3 text-slate-400 transition hover:bg-white/5 hover:text-pink-300">
                                <span class="flex-shrink-0 text-xl">📈</span>
                                <span x-show="expanded" class="whitespace-nowrap text-sm font-semibold">Laporan Omset</span>
                            </a>

                        @endif

                        <!-- MENU KASIR -->
                        @if(in_array(auth()->user()->role, ['kasir', 'cashier', 'Kasir']))
                            <a href="{{ route('kasir.pos') }}"
                                class="flex items-center gap-4 rounded-2xl px-3 py-3 text-slate-400 transition-colors hover:bg-white/5 hover:text-pink-300">
                                <span class="text-xl flex-shrink-0">🛒</span>
                                <span x-show="expanded" class="whitespace-nowrap text-sm font-semibold">POS Walk-in</span>
                            </a>

                            <a href="{{ route('kasir.orders') }}"
                                class="flex items-center gap-4 rounded-2xl px-3 py-3 text-slate-400 transition-colors hover:bg-white/5 hover:text-pink-300">
                                <span class="text-xl flex-shrink-0">📦</span>
                                <span x-show="expanded" class="whitespace-nowrap text-sm font-semibold">Daftar Orderan</span>
                            </a>

                            <a href="{{ route('kasir.recap') }}"
                                class="flex items-center gap-4 rounded-2xl px-3 py-3 text-slate-400 transition-colors hover:bg-white/5 hover:text-pink-300">
                                <span class="text-xl flex-shrink-0">📋</span>
                                <span x-show="expanded" class="whitespace-nowrap text-sm font-semibold">Rekap Kas</span>
                            </a>
                        @endif

                        <!-- MENU ADMIN -->
                        @if(in_array(strtolower(auth()->user()->role), ['admin']))
                            <!-- Kelola Pesanan -->
                            <a href="{{ route('admin.orders') }}"
                                class="flex items-center gap-4 rounded-2xl px-3 py-3 text-slate-400 transition-colors hover:bg-white/5 hover:text-pink-300">
                                <span class="text-xl flex-shrink-0">📦</span>
                                <span x-show="expanded" class="whitespace-nowrap text-sm font-semibold">Kelola Pesanan</span>
                            </a>

                            <!-- Kelola Produk -->
                            <a href="{{ route('products.index') }}"
                                class="flex items-center gap-4 rounded-2xl px-3 py-3 text-slate-400 transition-colors hover:bg-white/5 hover:text-pink-300">
                                <span class="text-xl flex-shrink-0">🌸</span>
                                <span x-show="expanded" class="whitespace-nowrap text-sm font-semibold">Kelola Produk</span>
                            </a>

                            <a href="{{ route('admin.bank_accounts.index') }}"
                                class="flex items-center gap-4 rounded-2xl px-3 py-3 text-slate-400 transition-colors hover:bg-white/5 hover:text-pink-300">
                                <span class="text-xl flex-shrink-0">🏦</span>
                                <span x-show="expanded" class="whitespace-nowrap text-sm font-semibold">Kelola Rekening</span>
                            </a>

                            <a href="{{ route('admin.hero_slides.index') }}"
                                class="flex items-center gap-4 rounded-2xl px-3 py-3 text-slate-400 transition-colors hover:bg-white/5 hover:text-pink-300">
                                <span class="text-xl flex-shrink-0">🖼️</span>
                                <span x-show="expanded" class="whitespace-nowrap text-sm font-semibold">Slide Beranda</span>
                            </a>

                            <a href="{{ route('admin.vouchers.index') }}"
                                class="flex items-center gap-4 rounded-2xl px-3 py-3 text-slate-400 transition-colors hover:bg-white/5 hover:text-pink-300">
                                <span class="text-xl flex-shrink-0">🎫</span>
                                <span x-show="expanded" class="whitespace-nowrap text-sm font-semibold">Kelola Voucher</span>
                            </a>

                            <a href="{{ route('admin.users.index') }}"
                                class="flex items-center gap-4 rounded-2xl px-3 py-3 text-slate-400 transition-colors hover:bg-white/5 hover:text-pink-300">
                                <span class="text-xl flex-shrink-0">👥</span>
                                <span x-show="expanded" class="whitespace-nowrap text-sm font-semibold">Manajemen Akun</span>
                            </a>
                        @endif
                    @endauth
                </nav>
            </div>

            <!-- Footer Sidebar (Profile dengan Dropdown Pengaturan Akun & Logout) -->
            <div x-data="{ open: false }" class="relative border-t border-white/10 p-2">
                <!-- Tombol Trigger Profile -->
                <button @click="open = !open" @click.outside="open = false" type="button"
                    class="group flex w-full items-center gap-3 rounded-2xl border border-transparent p-1.5 text-left transition-all duration-200 hover:border-white/10 hover:bg-white/5 focus:outline-none">

                    <!-- Avatar Profil -->
                    <div
                        class="flex h-9 w-9 flex-shrink-0 items-center justify-center overflow-hidden rounded-full bg-slate-700 text-base font-bold text-white ring-2 ring-slate-600 transition-colors group-hover:ring-pink-400">
                        @if(auth()->user()->avatar)
                            <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Foto profil" class="w-full h-full object-cover">
                        @else
                            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                        @endif
                    </div>

                    <!-- Nama & Role -->
                    <div x-show="expanded" class="flex-1 overflow-hidden whitespace-nowrap">
                        <p class="truncate text-sm font-bold text-white">{{ auth()->user()->name ?? 'User' }}</p>
                        <p class="truncate text-xs capitalize text-slate-400">{{ auth()->user()->role ?? 'Guest' }}</p>
                    </div>

                    <!-- Icon Panah Dropdown -->
                    <span x-show="expanded" class="flex h-7 w-7 items-center justify-center rounded-full bg-white/5 text-xs text-slate-400 transition-transform duration-200"
                        :class="{ 'rotate-180': open }">
                        ▲
                    </span>
                </button>

                <!-- MENU DROPDOWN (PENGATURAN & LOGOUT) -->
                <div x-show="open" x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"
                    class="absolute bottom-[5.5rem] left-3 right-3 z-50 overflow-hidden rounded-2xl border border-slate-600/70 bg-[#18243a] p-1.5 shadow-[0_20px_45px_rgba(0,0,0,0.35)]"
                    style="display: none;">

                    <!-- Link Pengaturan Profil -->
                    <a href="{{ route('profile.edit') }}"
                        class="flex items-center gap-3 rounded-xl px-3.5 py-3 text-xs font-semibold text-slate-300 transition-colors hover:bg-white/8 hover:text-white">
                        <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-violet-400/10 text-violet-300">
                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M19.4 15 20 16a2 2 0 1 1-2.8 2.8l-1-.6a2 2 0 0 0-3.2 1.6V21a2 2 0 1 1-4 0v-1.2a2 2 0 0 0-3.2-1.6l-1 .6A2 2 0 1 1 3 16l.6-1a2 2 0 0 0-1.6-3.2H1a2 2 0 1 1 0-4h1a2 2 0 0 0 1.6-3.2L3 3a2 2 0 1 1 2.8-2.8l1 .6A2 2 0 0 0 10 0V0a2 2 0 1 1 4 0v.8a2 2 0 0 0 3.2 1.6l1-.6A2 2 0 1 1 21 4.6l-.6 1A2 2 0 0 0 22 8.8h1a2 2 0 1 1 0 4h-1a2 2 0 0 0-1.6 3.2Z"></path></svg>
                        </span>
                        <span>Pengaturan Akun</span>
                    </a>

                    <div class="my-1.5 border-t border-white/10"></div>

                    <!-- Form Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="flex w-full items-center gap-3 rounded-xl px-3.5 py-3 text-left text-xs font-bold text-rose-400 transition-colors hover:bg-rose-500/10 hover:text-rose-300">
                            <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-rose-400/10 text-rose-300">
                                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M10 17l5-5-5-5M15 12H3M21 3v18"></path></svg>
                            </span>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>

        </aside>

        <!-- AREA KONTEN UTAMA DASHBOARD -->
        <main class="flex-1 transition-all duration-300 ml-16 overflow-y-auto">
            <!-- Page Header (Jika Ada) -->
            @if (isset($header))
                <header class="border-b border-slate-200/80 bg-white shadow-sm">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <div class="p-8">
                {{ $slot }}
            </div>
        </main>

    </div>

</body>

</html>