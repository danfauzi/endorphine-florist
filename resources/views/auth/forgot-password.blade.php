<x-guest-layout>
    <div class="mb-7">
        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-pink-50 text-2xl ring-1 ring-pink-100">
            🔐
        </div>
        <p class="text-[10px] font-extrabold uppercase tracking-[0.22em] text-pink-500">Pemulihan akun</p>
        <h1 class="mt-2 text-2xl font-black tracking-tight text-slate-800">Lupa password?</h1>
        <p class="mt-3 text-sm leading-6 text-slate-500">
            Masukkan email akunmu. Kami akan mengirimkan link aman untuk membuat password baru.
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-5 rounded-2xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700" :status="session('status')" />

    @if (session('reset_link'))
        <div class="mb-5 rounded-2xl border border-pink-100 bg-pink-50/70 p-4">
            <p class="text-xs font-extrabold uppercase tracking-wider text-pink-600">Link Reset Password</p>
            <p class="mt-1 text-xs leading-5 text-slate-500">Salin link di bawah ini untuk membuka halaman password baru.</p>
            <input type="url" readonly value="{{ session('reset_link') }}" onclick="this.select()"
                class="mt-3 block w-full cursor-text rounded-xl border border-pink-200 bg-white px-3 py-2.5 text-xs text-slate-600 focus:border-pink-400 focus:ring-2 focus:ring-pink-100">
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" value="Email akun" class="mb-2 text-xs font-extrabold uppercase tracking-wider text-slate-600" />
            <x-text-input id="email" class="block w-full rounded-2xl border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium transition focus:border-pink-400 focus:bg-white focus:ring-2 focus:ring-pink-100" type="email" name="email" :value="old('email')" placeholder="nama@email.com" required autofocus autocomplete="email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm" />
        </div>

        <div class="flex flex-col-reverse items-stretch gap-3 pt-1 sm:flex-row sm:items-center sm:justify-between">
            <a href="{{ route('login') }}" class="group inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 px-4 py-3 text-sm font-bold text-slate-500 transition duration-300 hover:border-pink-200 hover:bg-pink-50 hover:text-pink-600 sm:justify-start">
                <span>Kembali ke login</span>
            </a>
            <x-primary-button class="justify-center gap-2 rounded-xl bg-gradient-to-r from-pink-600 to-rose-500 px-5 py-3 text-xs font-extrabold uppercase tracking-wider text-white shadow-lg shadow-pink-200 transition duration-300 hover:-translate-y-0.5 hover:from-pink-700 hover:to-rose-600 focus:bg-pink-600 focus:ring-pink-200">
                <span class="text-sm leading-none">✦</span>
                <span>Kirim link reset</span>
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
