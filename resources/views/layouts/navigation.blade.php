<nav x-data="{ open: false }" class="bg-white border-b border-slate-100 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo / Brand Endorphine Florist Kasir -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('kasir.orders') }}"
                        class="font-black text-lg text-pink-600 tracking-tight flex items-center gap-2">
                        <span
                            class="w-8 h-8 rounded-xl bg-pink-50 flex items-center justify-center text-sm shadow-sm">🌸</span>
                        Endorphine <span
                            class="text-slate-800 font-normal text-xs uppercase tracking-widest bg-slate-100 px-2 py-0.5 rounded-md">Kasir
                            POS</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('kasir.orders')" :active="request()->routeIs('kasir.orders')"
                        class="text-xs font-bold uppercase tracking-wider">
                        {{ __('Daftar Pesanan') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- CONTAINER PROFIL DENGAN DROPDOWN ALPINE.JS -->
            <div x-data="{ open: false }" class="relative mt-auto border-t border-slate-800 pt-4">
                <!-- Tombol Trigger Profile -->
                <button @click="open = !open" @click.outside="open = false" type="button"
                    class="w-full flex items-center justify-center lg:justify-start gap-3 p-2 rounded-2xl hover:bg-slate-800/80 transition cursor-pointer group focus:outline-none">

                    <!-- Circle Avatar Profil -->
                    <div
                        class="w-10 h-10 shrink-0 rounded-full bg-pink-600 text-white font-extrabold flex items-center justify-center text-sm shadow-md uppercase overflow-hidden">
                        @if(auth()->user()->avatar)
                            <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Foto profil" class="w-full h-full object-cover">
                        @else
                            {{ substr(auth()->user()->name ?? 'K', 0, 1) }}
                        @endif
                    </div>

                    <!-- Nama & Role (Tampil di Layar Besar / Sidebar Terbuka) -->
                    <div class="hidden lg:block text-left overflow-hidden">
                        <h4 class="text-xs font-bold text-white truncate group-hover:text-pink-400 transition">
                            {{ auth()->user()->name ?? 'Kasir' }}
                        </h4>
                        <p class="text-[10px] text-slate-400 capitalize">
                            {{ auth()->user()->role ?? 'Kasir' }}
                        </p>
                    </div>
                </button>

                <!-- MENU POPUP (LOGOUT & PENGATURAN) -->
                <div x-show="open" x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 scale-90 translate-x-2"
                    x-transition:enter-end="opacity-100 scale-100 translate-x-0"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100 scale-100 translate-x-0"
                    x-transition:leave-end="opacity-0 scale-90 translate-x-2"
                    class="absolute bottom-0 left-full ml-3 w-48 bg-slate-900 border border-slate-700/80 rounded-2xl shadow-2xl p-2 z-50 space-y-1"
                    style="display: none;">

                    <!-- Header Nama di Popup -->
                    <div class="px-3 py-2 border-b border-slate-800 mb-1">
                        <p class="text-xs font-bold text-white truncate">{{ auth()->user()->name ?? 'Kasir' }}</p>
                        <p class="text-[10px] text-slate-400 capitalize">{{ auth()->user()->role ?? 'Kasir' }}</p>
                    </div>

                    <!-- Link Profile -->
                    <a href="{{ route('profile.edit') }}"
                        class="flex items-center gap-2 px-3 py-2 text-xs font-semibold text-slate-300 hover:text-white hover:bg-slate-800 rounded-xl transition">
                        <span>⚙️</span> Pengaturan Akun
                    </a>

                    <!-- Form Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center gap-2 px-3 py-2 text-xs font-semibold text-rose-400 hover:text-rose-300 hover:bg-rose-500/10 rounded-xl transition text-left">
                            <span>🚪</span> Keluar / Logout
                        </button>
                    </form>
                </div>
            </div>

            <!-- Hamburger (Mobile) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-slate-400 hover:text-slate-500 hover:bg-slate-100 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (Mobile) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-slate-100">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('kasir.orders')" :active="request()->routeIs('kasir.orders')">
                {{ __('Daftar Pesanan') }}
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-2 border-t border-slate-200">
            <div class="px-4 mb-2">
                <div class="font-bold text-base text-slate-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-xs text-slate-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="space-y-1 border-t border-slate-100 pt-2">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('⚙️ Pengaturan Akun') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();"
                        class="text-rose-600 font-bold">
                        {{ __('🚪 Keluar Sistem') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>