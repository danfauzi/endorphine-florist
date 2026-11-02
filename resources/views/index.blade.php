<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Endorphine Florist - Toko Bunga & Buket Premium</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- AOS Animation CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-rose-50/20 text-slate-800 selection:bg-pink-500 selection:text-white">

    <!-- Header / Navbar -->
    <nav class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-pink-100/60 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between gap-4">

            <!-- Logo -->
            <a href="{{ route('home') }}"
                class="text-2xl font-black text-pink-600 tracking-tight flex items-center gap-2 group shrink-0">
                <span class="text-3xl group-hover:scale-110 transition duration-300">🌸</span>
                <span>Endorphine<span class="text-slate-800">Florist</span></span>
            </a>

            <!-- Search Bar Tengah -->
            <div class="hidden md:flex items-center flex-1 max-w-md mx-4">
                <form action="{{ route('home') }}" method="GET" class="group relative w-full">
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari buket mawar, snack, dll..."
                        class="w-full rounded-full border border-slate-200/80 bg-gradient-to-r from-slate-50 to-white py-3 pl-11 pr-10 text-xs font-semibold text-slate-700 shadow-[0_8px_22px_rgba(15,23,42,0.06)] outline-none transition-all duration-200 placeholder:text-slate-400 hover:border-pink-200 hover:shadow-[0_10px_26px_rgba(236,72,153,0.10)] focus:border-pink-300 focus:bg-white focus:ring-4 focus:ring-pink-100/80 md:text-sm">
                    <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 transition-colors duration-200 group-focus-within:text-pink-500">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <circle cx="11" cy="11" r="7"></circle>
                            <path stroke-linecap="round" d="m20 20-4-4"></path>
                        </svg>
                    </span>
                    @if(request('search'))
                        <a href="{{ route('home', request()->only('category')) }}"
                            aria-label="Hapus pencarian"
                            class="absolute right-3 top-1/2 flex h-6 w-6 -translate-y-1/2 items-center justify-center rounded-full border border-slate-200 bg-slate-100 text-slate-400 shadow-sm transition hover:border-pink-200 hover:bg-pink-50 hover:text-pink-600">
                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                                <path stroke-linecap="round" d="M6 6l12 12M18 6 6 18"></path>
                            </svg>
                        </a>
                    @endif
                </form>
            </div>

            <!-- Tombol User / Auth & Cart -->
            <div class="flex items-center gap-2.5 sm:gap-3 shrink-0">
                @auth
                    <!-- Tombol Keranjang Belanja dengan Badge Counter -->
                    <a href="{{ route('cart.index') }}"
                        class="relative bg-pink-50 hover:bg-pink-100 text-pink-600 p-2.5 rounded-2xl border border-pink-100 transition flex items-center justify-center">
                        <span class="text-lg">🛒</span>
                        @php
                            $cartCount = \App\Models\Cart::where('user_id', auth()->id())->sum('quantity');
                        @endphp
                        @if($cartCount > 0)
                            <span
                                class="absolute -top-1.5 -right-1.5 bg-rose-500 text-white text-[10px] font-black w-5 h-5 rounded-full flex items-center justify-center border-2 border-white shadow-sm">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>

                    @php
                        $userRole = strtolower(auth()->user()->role);
                    @endphp

                    @if(in_array($userRole, ['admin', 'owner', 'kasir']))
                        <!-- Tombol Dashboard Dinamis untuk Admin, Owner, & Kasir -->
                        <a href="{{ route('dashboard') }}"
                            class="text-xs md:text-sm font-bold text-pink-600 hover:text-pink-700 bg-pink-50 hover:bg-pink-100 border border-pink-100 px-4 py-2.5 rounded-2xl transition flex items-center gap-1.5 shadow-sm">
                            ⚙️ <span>Dashboard {{ ucfirst($userRole) }}</span>
                        </a>
                    @else
                        <!-- Dropdown Profil Pelanggan (Alpine.js) -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" @click.outside="open = false"
                                class="flex items-center gap-2 bg-pink-50 hover:bg-pink-100 border border-pink-100 px-3 py-1.5 rounded-full transition focus:outline-none">
                                <div
                                    class="w-7 h-7 rounded-full bg-pink-500 text-white flex items-center justify-center font-bold text-xs uppercase shadow-sm overflow-hidden">
                                    @if(auth()->user()->avatar)
                                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Foto profil" class="w-full h-full object-cover">
                                    @else
                                        {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                                    @endif
                                </div>
                                <span class="text-xs sm:text-sm font-bold text-slate-700">
                                    {{ auth()->user()->name ?? 'Pelanggan' }}
                                </span>
                                <svg class="w-4 h-4 text-slate-500 transition-transform duration-200"
                                    :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                    </path>
                                </svg>
                            </button>

                            <!-- Dropdown Menu Content -->
                            <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute right-0 z-50 mt-3 w-64 overflow-hidden rounded-2xl border border-pink-100/80 bg-white/95 py-2 text-slate-700 shadow-[0_18px_45px_rgba(15,23,42,0.15)] backdrop-blur-xl"
                                style="display: none;">

                                <div class="border-b border-slate-100 bg-gradient-to-br from-pink-50/80 to-white px-4 py-3">
                                    <p class="text-[10px] font-extrabold uppercase tracking-[0.16em] text-pink-500">Akun Aktif</p>
                                    <p class="mt-1 truncate text-sm font-extrabold text-slate-800">{{ auth()->user()->name ?? 'Pelanggan' }}</p>
                                    <p class="mt-0.5 truncate text-[11px] font-medium text-slate-400">{{ auth()->user()->email }}</p>
                                </div>

                                <div class="px-4 pb-1 pt-3 text-[10px] font-extrabold uppercase tracking-[0.16em] text-slate-400">
                                    STATUS PESANAN
                                </div>
                                @php
                                    $unpaidOrderCount = auth()->user()->orders()->where('payment_status', 'unpaid')->count();
                                @endphp
                                <a href="{{ route('orders.index', ['status' => 'unpaid']) }}"
                                    class="group flex items-center gap-3 px-4 py-2.5 text-xs font-semibold transition hover:bg-pink-50 hover:text-pink-600">
                                    <span class="flex h-7 w-7 items-center justify-center rounded-xl bg-amber-50 text-amber-500 transition group-hover:bg-white">
                                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"></rect><path stroke-linecap="round" d="M3 10h18M7 15h3"></path></svg>
                                    </span>
                                    <span>Belum Bayar</span>
                                    @if($unpaidOrderCount > 0)
                                        <span class="ml-auto rounded-full bg-rose-500 px-2 py-0.5 text-[10px] font-bold text-white shadow-sm">{{ $unpaidOrderCount }}</span>
                                    @endif
                                </a>
                                <a href="{{ route('orders.index') }}"
                                    class="group flex items-center gap-3 px-4 py-2.5 text-xs font-semibold transition hover:bg-pink-50 hover:text-pink-600">
                                    <span class="flex h-7 w-7 items-center justify-center rounded-xl bg-sky-50 text-sky-500 transition group-hover:bg-white">
                                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 3h9l3 3v15H6zM14 3v4h4M9 12h6M9 16h6"></path></svg>
                                    </span>
                                    <span>Riwayat Transaksi</span>
                                </a>
                                <a href="{{ route('orders.index', ['status' => 'review']) }}"
                                    class="group flex items-center gap-3 px-4 py-2.5 text-xs font-semibold transition hover:bg-pink-50 hover:text-pink-600">
                                    <span class="flex h-7 w-7 items-center justify-center rounded-xl bg-violet-50 text-violet-500 transition group-hover:bg-white">
                                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m12 3 2.8 5.7 6.2.9-4.5 4.4 1.1 6.2-5.6-3-5.6 3 1.1-6.2L3 9.6l6.2-.9z"></path></svg>
                                    </span>
                                    <span>Beri Penilaian</span>
                                </a>

                                <div class="my-2 border-t border-slate-100"></div>

                                <a href="{{ route('profile.edit') }}"
                                    class="group flex items-center gap-3 px-4 py-2.5 text-xs font-semibold transition hover:bg-slate-50 hover:text-slate-900">
                                    <span class="flex h-7 w-7 items-center justify-center rounded-xl bg-slate-100 text-slate-500 transition group-hover:bg-white">
                                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Z"></path><path stroke-linecap="round" stroke-linejoin="round" d="m19.4 15 .1.1a2 2 0 1 1-2.8 2.8l-.1-.1a2 2 0 0 0-3.4 1.4V19a2 2 0 1 1-4 0v-.2A2 2 0 0 0 5.8 17l-.1.1a2 2 0 1 1-2.8-2.8l.1-.1A2 2 0 0 0 1.6 11H2a2 2 0 1 1 0-4h-.2A2 2 0 0 0 3 3.6l-.1-.1A2 2 0 1 1 5.7.7l.1.1A2 2 0 0 0 9.2 0H9a2 2 0 1 1 4 0v.2a2 2 0 0 0 3.4 1.4l.1-.1a2 2 0 1 1 2.8 2.8l-.1.1A2 2 0 0 0 20.6 8h-.2a2 2 0 1 1 0 4h.2a2 2 0 0 0-1.2 3Z"></path></svg>
                                    </span>
                                    <span>Pengaturan Akun</span>
                                </a>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="group flex w-full items-center gap-3 px-4 py-2.5 text-left text-xs font-bold text-rose-600 transition hover:bg-rose-50">
                                        <span class="flex h-7 w-7 items-center justify-center rounded-xl bg-rose-50 text-rose-500 transition group-hover:bg-white">
                                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M10 17l5-5-5-5M15 12H3M21 3v18"></path></svg>
                                        </span>
                                        <span>Logout</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                @else
                    <a href="{{ route('login') }}"
                        class="group inline-flex items-center gap-2 rounded-full border border-slate-200/80 bg-white/85 px-4 py-2.5 text-xs font-extrabold tracking-wide text-slate-700 shadow-[0_8px_18px_rgba(15,23,42,0.06)] backdrop-blur-sm transition-all duration-200 hover:-translate-y-0.5 hover:border-pink-200 hover:bg-pink-50 hover:text-pink-600 hover:shadow-[0_12px_24px_rgba(236,72,153,0.12)] md:text-sm">
                        <span>Masuk</span>
                    </a>
                    <a href="{{ route('register') }}"
                        class="group inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-pink-500 via-rose-500 to-fuchsia-500 px-5 py-2.5 text-xs font-black tracking-wide text-white shadow-[0_14px_28px_rgba(236,72,153,0.35)] ring-1 ring-pink-200/80 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-[0_18px_32px_rgba(236,72,153,0.45)] md:text-sm">
                        <span>Daftar</span>
                    </a>
                @endauth
            </div>

        </div>
    </nav>

    <!-- Hero Banner Carousel Slider -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <section class="relative overflow-hidden bg-slate-900 text-white shadow-xl">
        <div class="swiper heroSwiper">
            <div class="swiper-wrapper">
                @foreach($heroSlides as $slide)
                    <div class="swiper-slide aspect-[4/3] sm:aspect-[16/7] min-h-[360px] max-h-[560px] px-4 text-center relative flex items-center justify-center">
                        <div class="absolute inset-0 z-0">
                            <img src="{{ str_starts_with($slide->image ?? '', 'http') ? $slide->image : asset('storage/' . $slide->image) }}" alt="{{ $slide->title }}" class="w-full h-full object-contain">
                            <div class="absolute inset-0 bg-black/50 backdrop-blur-[1px]"></div>
                        </div>
                        <div class="absolute inset-0 z-10 flex items-center justify-center px-4 text-center">
                            <div class="w-full max-w-3xl space-y-4">
                                @if($slide->eyebrow)
                                    <span class="inline-block text-xs font-black tracking-widest bg-white/20 backdrop-blur-md text-pink-50 uppercase px-4 py-1.5 rounded-full border border-white/30 shadow-sm">{{ $slide->eyebrow }}</span>
                                @endif
                                <h1 class="text-3xl sm:text-5xl md:text-6xl font-black tracking-tight leading-tight">{{ $slide->title }}</h1>
                                @if($slide->description)
                                    <p class="text-pink-100 text-sm sm:text-base md:text-lg max-w-2xl mx-auto font-medium leading-relaxed">{{ $slide->description }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Navigation -->
            <div class="swiper-button-next !text-white !w-10 !h-10 !bg-white/20 backdrop-blur-md rounded-full after:!text-sm hover:!bg-white/40 transition hidden sm:flex"></div>
            <div class="swiper-button-prev !text-white !w-10 !h-10 !bg-white/20 backdrop-blur-md rounded-full after:!text-sm hover:!bg-white/40 transition hidden sm:flex"></div>
            <div class="swiper-pagination !bottom-4"></div>
        </div>
    </section>

    <!-- Swiper JS Script -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        const swiper = new Swiper('.heroSwiper', {
            loop: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    </script>

    <!-- Benefits Bar -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-20">
        <div class="bg-white rounded-3xl p-6 shadow-xl shadow-pink-100/60 border border-pink-100/60 grid grid-cols-1 md:grid-cols-3 gap-6 text-center md:text-left">
            <div class="flex items-center justify-center md:justify-start gap-4">
                <div class="w-12 h-12 bg-pink-50 text-pink-600 rounded-2xl flex items-center justify-center text-2xl font-bold">🌸</div>
                <div>
                    <h4 class="font-bold text-slate-800 text-sm">Bunga Segar Berkualitas</h4>
                    <p class="text-xs text-slate-400">Rangkaian terbaik dengan bahan premium</p>
                </div>
            </div>
            <div class="flex items-center justify-center md:justify-start gap-4 border-t md:border-t-0 md:border-l border-slate-100 pt-4 md:pt-0 md:pl-6">
                <div class="w-12 h-12 bg-pink-50 text-pink-600 rounded-2xl flex items-center justify-center text-2xl font-bold">💌</div>
                <div>
                    <h4 class="font-bold text-slate-800 text-sm">Gratis Kartu Ucapan</h4>
                    <p class="text-xs text-slate-400">Custom pesan manis sesuai permintaanmu</p>
                </div>
            </div>
                <div class="flex items-center justify-center md:justify-start gap-4 border-t md:border-t-0 md:border-l border-slate-100 pt-4 md:pt-0 md:pl-6">
                <div class="w-12 h-12 bg-pink-50 text-pink-600 rounded-2xl flex items-center justify-center text-2xl font-bold">💳</div>
                <div>
                    <h4 class="font-bold text-slate-800 text-sm">Pembayaran Aman</h4>
                    <p class="text-xs text-slate-400">Cash, Transfer, dan QRIS tersedia</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content / Katalog -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <!-- Header Section & Filter Kategori -->
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-6">
            <div>
                <span class="text-xs font-bold text-pink-600 uppercase tracking-widest bg-pink-50 px-3 py-1 rounded-full border border-pink-100">Katalog Buket</span>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-800 mt-2">Temukan Pilihan Favoritmu</h2>
            </div>

            <!-- Filter Badges -->
            <div class="relative flex items-center gap-2 min-w-0 max-w-full">
                <button type="button" aria-label="Geser kategori ke kiri" onclick="scrollCatalogCategories(-1)"
                    class="shrink-0 w-9 h-9 rounded-full bg-white border border-slate-200 text-slate-500 hover:bg-pink-50 hover:text-pink-600 shadow-sm transition">
                    &#8592;
                </button>

                <div id="catalog-categories" class="flex items-center gap-2 overflow-x-auto scroll-smooth py-1 px-0.5 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                    <a href="{{ route('home') }}"
                        class="shrink-0 px-5 py-2.5 rounded-2xl text-xs sm:text-sm font-bold transition duration-200 shadow-sm flex items-center gap-1.5 {{ !request('category') ? 'bg-pink-600 text-white shadow-pink-200' : 'bg-white text-slate-600 border border-slate-100 hover:bg-pink-50 hover:text-pink-600' }}">
                        ✨ <span>Semua</span>
                    </a>
                    <a href="{{ route('home', ['category' => 'Bunga']) }}"
                        class="shrink-0 px-5 py-2.5 rounded-2xl text-xs sm:text-sm font-bold transition duration-200 shadow-sm flex items-center gap-1.5 {{ strtolower(request('category')) == 'bunga' ? 'bg-pink-600 text-white shadow-pink-200' : 'bg-white text-slate-600 border border-slate-100 hover:bg-pink-50 hover:text-pink-600' }}">
                        💐 <span>Bunga</span>
                    </a>
                    <a href="{{ route('home', ['category' => 'Snack']) }}"
                        class="shrink-0 px-5 py-2.5 rounded-2xl text-xs sm:text-sm font-bold transition duration-200 shadow-sm flex items-center gap-1.5 {{ strtolower(request('category')) == 'snack' ? 'bg-pink-600 text-white shadow-pink-200' : 'bg-white text-slate-600 border border-slate-100 hover:bg-pink-50 hover:text-pink-600' }}">
                        🍫 <span>Snack</span>
                    </a>
                    <a href="{{ route('home', ['category' => 'Uang']) }}"
                        class="shrink-0 px-5 py-2.5 rounded-2xl text-xs sm:text-sm font-bold transition duration-200 shadow-sm flex items-center gap-1.5 {{ strtolower(request('category')) == 'uang' ? 'bg-pink-600 text-white shadow-pink-200' : 'bg-white text-slate-600 border border-slate-100 hover:bg-pink-50 hover:text-pink-600' }}">
                        💸 <span>Uang</span>
                    </a>
                    <a href="{{ route('home', ['category' => 'Kado']) }}"
                        class="shrink-0 px-5 py-2.5 rounded-2xl text-xs sm:text-sm font-bold transition duration-200 shadow-sm flex items-center gap-1.5 {{ strtolower(request('category')) == 'kado' ? 'bg-pink-600 text-white shadow-pink-200' : 'bg-white text-slate-600 border border-slate-100 hover:bg-pink-50 hover:text-pink-600' }}">
                        🎁 <span>Kado</span>
                    </a>
                    <a href="{{ route('home', ['category' => 'Wisuda']) }}"
                        class="shrink-0 px-5 py-2.5 rounded-2xl text-xs sm:text-sm font-bold transition duration-200 shadow-sm flex items-center gap-1.5 {{ strtolower(request('category')) == 'wisuda' ? 'bg-pink-600 text-white shadow-pink-200' : 'bg-white text-slate-600 border border-slate-100 hover:bg-pink-50 hover:text-pink-600' }}">
                        🎓 <span>Wisuda</span>
                    </a>
                </div>

                <button type="button" aria-label="Geser kategori ke kanan" onclick="scrollCatalogCategories(1)"
                    class="shrink-0 w-9 h-9 rounded-full bg-white border border-slate-200 text-slate-500 hover:bg-pink-50 hover:text-pink-600 shadow-sm transition">
                    &#8594;
                </button>
            </div>
        </div>

        <script>
            function scrollCatalogCategories(direction) {
                document.getElementById('catalog-categories')?.scrollBy({
                    left: direction * 220,
                    behavior: 'smooth'
                });
            }
        </script>

        <!-- Grid Produk -->
        @if($products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($products as $index => $product)
                    <div data-aos="fade-up" data-aos-delay="{{ ($index % 4) * 100 }}"
                        class="group bg-white rounded-3xl border border-slate-100 overflow-hidden shadow-sm hover:shadow-2xl hover:shadow-pink-100/80 transition duration-300 flex flex-col justify-between">
                        <div>
                            <!-- Foto Produk -->
                            <a href="{{ route('products.show', $product) }}"
                                aria-label="Lihat detail produk {{ $product->name }}"
                                class="relative block h-60 w-full bg-slate-100 overflow-hidden focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-pink-500">
                                @if($product->image)
                                    <img src="{{ str_starts_with($product->image, 'http') || str_starts_with($product->image, 'data:') ? $product->image : asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-400 text-xs italic">No Photo Available</div>
                                @endif

                                <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-300"></div>

                                <span class="absolute top-3.5 left-3.5 bg-white/90 backdrop-blur-md text-pink-600 text-[11px] font-extrabold px-3 py-1 rounded-full shadow-sm border border-white/50">
                                    {{ ucfirst($product->category) }}
                                </span>

                                <span class="absolute top-3.5 right-3.5 text-[10px] font-extrabold px-2.5 py-1 rounded-full shadow-sm backdrop-blur-md border border-white/30 {{ $product->stock > 0 ? 'bg-emerald-500/90 text-white' : 'bg-rose-500/90 text-white' }}">
                                    {{ $product->stock > 0 ? 'Ready' : 'Out Of Stock' }}
                                </span>

                                @if($product->created_at && $product->created_at->greaterThanOrEqualTo(now()->subDays(3)))
                                    <span class="absolute bottom-3.5 left-3.5 bg-pink-600 text-white text-[10px] font-black uppercase tracking-wider px-3 py-1 rounded-full shadow-lg shadow-pink-300/50">
                                        Baru
                                    </span>
                                @endif
                            </a>

                            <!-- Detail Produk -->
                            <div class="p-5">
                                <h3 class="font-bold text-slate-800 text-base line-clamp-1 group-hover:text-pink-600 transition duration-200 mb-1">
                                    {{ $product->name }}
                                </h3>
                            </div>
                        </div>

                        <!-- Harga & Tombol Beli -->
                        <div class="p-5 pt-0 border-t border-slate-50 mt-auto flex items-center justify-between gap-2">
                            <div>
                                <p class="text-[10px] text-slate-400 uppercase font-extrabold tracking-wider">Harga</p>
                                <p class="text-lg font-black text-pink-600">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </p>
                            </div>

                            <a href="{{ route('products.show', $product) }}"
                                class="bg-slate-100 hover:bg-pink-50 text-slate-700 hover:text-pink-600 text-xs font-extrabold px-3.5 py-2.5 rounded-2xl flex items-center gap-1.5 transition duration-200">
                                🔎 <span>Detail Produk</span>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- State Produk Kosong -->
            <div class="text-center py-20 bg-white rounded-3xl border border-dashed border-pink-200 shadow-sm max-w-md mx-auto my-8">
                <span class="text-5xl block mb-3">💐</span>
                <h3 class="font-bold text-slate-800 text-base">Belum Ada Buket Tersedia</h3>
                <p class="text-slate-400 text-xs mt-1">Produk di kategori ini belum ditambahkan oleh admin.</p>
            </div>
        @endif

    </main>

    <!-- Footer -->
    <footer class="mt-20 border-t border-pink-100/80 bg-[linear-gradient(180deg,#fff,#fff7fb)] pb-8 pt-14 text-slate-600">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-12 grid grid-cols-1 gap-6 md:grid-cols-4 lg:gap-8">

                <div class="space-y-4 rounded-[1.75rem] border border-pink-100/70 bg-white/70 p-6 shadow-[0_12px_28px_rgba(190,24,93,0.05)]">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 text-2xl font-black tracking-tight text-pink-600 transition hover:opacity-80">
                        <span class="text-3xl">🌸</span>
                        <span>Endorphine<span class="text-slate-800">Florist</span></span>
                    </a>
                    <p class="text-xs leading-relaxed text-slate-500">
                        Toko buket bunga, snack, dan uang terpercaya. Dirangkai estetik dengan penuh kasih sayang untuk merayakan setiap momen berharga bersama orang tersayang.
                    </p>
                    <div class="border-t border-slate-100 pt-4">
                        <p class="text-xs font-extrabold text-slate-700">Lokasi Toko</p>
                        <p class="mt-1 text-[11px] text-slate-500">Jl. Cimanggir</p>
                    </div>
                </div>

                <div class="rounded-[1.75rem] border border-slate-100 bg-white/60 p-6">
                    <h4 class="mb-4 flex items-center gap-2.5 text-xs font-extrabold uppercase tracking-wider text-slate-800">
                        <span class="h-5 w-1 rounded-full bg-pink-500"></span>
                        Ulasan Pelanggan
                    </h4>
                    <div class="space-y-3">
                        @forelse($reviews as $review)
                            <div class="rounded-2xl bg-slate-50/80 p-3 text-xs">
                                <div class="flex items-center justify-between gap-2">
                                    <span class="font-bold text-slate-700">{{ $review->user->name ?? 'Pelanggan' }}</span>
                                    <span class="text-amber-400">{{ str_repeat('★', $review->rating) }}<span class="text-slate-200">{{ str_repeat('★', 5 - $review->rating) }}</span></span>
                                </div>
                                <p class="mt-1 line-clamp-2 text-slate-500">{{ $review->review }}</p>
                            </div>
                        @empty
                            <p class="text-xs text-slate-400">Belum ada ulasan pelanggan.</p>
                        @endforelse
                        @if($reviewCount > 5)
                            <a href="{{ route('reviews.index') }}" class="inline-flex text-xs font-bold text-pink-600 hover:text-pink-700">Lihat Semua Ulasan →</a>
                        @endif
                    </div>
                </div>

                <div class="rounded-[1.75rem] border border-slate-100 bg-white/60 p-6">
                    <h4 class="mb-4 flex items-center gap-2.5 text-xs font-extrabold uppercase tracking-wider text-slate-800">
                        <span class="h-5 w-1 rounded-full bg-pink-500"></span>
                        Toko Online / E-Commerce
                    </h4>
                    <div class="space-y-2.5">
                        <a href="https://shopee.co.id" target="_blank" class="flex items-center gap-2.5 rounded-2xl border border-orange-100 bg-orange-50 p-3 text-xs font-bold text-orange-600 transition hover:-translate-y-0.5 hover:bg-orange-100 hover:shadow-sm">
                            <span class="text-base">🛍️</span> <span>Shopee Official</span>
                        </a>
                        <a href="https://tokopedia.com" target="_blank" class="flex items-center gap-2.5 rounded-2xl border border-emerald-100 bg-emerald-50 p-3 text-xs font-bold text-emerald-600 transition hover:-translate-y-0.5 hover:bg-emerald-100 hover:shadow-sm">
                            <span class="text-base">🟢</span> <span>Tokopedia Official</span>
                        </a>
                    </div>
                </div>

                <div class="rounded-[1.75rem] border border-slate-100 bg-white/60 p-6">
                    <h4 class="mb-4 flex items-center gap-2.5 text-xs font-extrabold uppercase tracking-wider text-slate-800">
                        <span class="h-5 w-1 rounded-full bg-pink-500"></span>
                        Hubungi & Ikuti Kami
                    </h4>
                    <p class="mb-3 text-xs leading-relaxed text-slate-500">Punya pertanyaan atau mau custom order khusus?</p>

                    <a href="https://wa.me/6281234567890" target="_blank" class="mb-4 flex items-center justify-center gap-2 rounded-2xl bg-emerald-500 p-3 text-xs font-bold text-white shadow-md shadow-emerald-100 transition hover:-translate-y-0.5 hover:bg-emerald-600 hover:shadow-lg">
                        <span>💬</span> WhatsApp CS (0812-3456-7890)
                    </a>

                    <div class="flex items-center gap-2">
                        <a href="https://instagram.com" target="_blank" aria-label="Instagram" class="flex h-10 w-10 items-center justify-center rounded-2xl border border-pink-100 bg-pink-50 text-pink-600 shadow-sm transition hover:-translate-y-0.5 hover:bg-pink-500 hover:text-white">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        <a href="https://tiktok.com" target="_blank" aria-label="TikTok" class="flex h-10 w-10 items-center justify-center rounded-2xl border border-slate-200 bg-slate-100 text-slate-800 shadow-sm transition hover:-translate-y-0.5 hover:bg-slate-900 hover:text-white">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.98-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg>
                        </a>
                        <a href="https://facebook.com" target="_blank" aria-label="Facebook" class="flex h-10 w-10 items-center justify-center rounded-2xl border border-blue-100 bg-blue-50 text-blue-600 shadow-sm transition hover:-translate-y-0.5 hover:bg-blue-600 hover:text-white">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                    </div>
                </div>

            </div>

            <div class="flex flex-col items-center justify-between gap-2 border-t border-slate-200/80 pt-6 text-[11px] text-slate-400 sm:flex-row">
                <p>&copy; {{ date('Y') }} Endorphine Florist. All rights reserved.</p>
                <p class="font-medium">Designed with 💖 for special moments.</p>
            </div>
        </div>
    </footer>

    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true,
        });
    </script>

</body>

</html>