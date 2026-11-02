<x-guest-layout>
    <div class="mb-7">
        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-pink-50 text-2xl ring-1 ring-pink-100">
            ✨
        </div>
        <p class="text-[10px] font-extrabold uppercase tracking-[0.22em] text-pink-500">Keamanan akun</p>
        <h1 class="mt-2 text-2xl font-black tracking-tight text-slate-800">Buat password baru</h1>
        <p class="mt-3 text-sm leading-6 text-slate-500">Gunakan password baru yang kuat untuk mengamankan akun Endorphine-mu.</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" value="Email akun" class="mb-2 text-xs font-extrabold uppercase tracking-wider text-slate-600" />
            <x-text-input id="email" class="block w-full rounded-2xl border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium text-slate-500 transition focus:border-pink-400 focus:bg-white focus:ring-2 focus:ring-pink-100" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" readonly />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" value="Password baru" class="mb-2 text-xs font-extrabold uppercase tracking-wider text-slate-600" />
            <x-text-input id="password" class="block w-full rounded-2xl border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium transition focus:border-pink-400 focus:bg-white focus:ring-2 focus:ring-pink-100" type="password" name="password" required autocomplete="new-password" placeholder="Masukkan password baru" />
            <p class="mt-2 text-xs text-slate-400">Gunakan minimal 8 karakter dengan kombinasi yang mudah kamu ingat.</p>
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" value="Konfirmasi password" class="mb-2 text-xs font-extrabold uppercase tracking-wider text-slate-600" />
            <x-text-input id="password_confirmation" class="block w-full rounded-2xl border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium transition focus:border-pink-400 focus:bg-white focus:ring-2 focus:ring-pink-100" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi password baru" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm" />
        </div>

        <div class="flex items-center justify-end pt-1">
            <x-primary-button class="w-full justify-center gap-2 rounded-xl bg-gradient-to-r from-pink-600 to-rose-500 px-5 py-3 text-xs font-extrabold uppercase tracking-wider text-white shadow-lg shadow-pink-200 transition duration-300 hover:-translate-y-0.5 hover:from-pink-700 hover:to-rose-600 focus:bg-pink-600 focus:ring-pink-200">
                <span class="text-sm leading-none">✓</span>
                <span>Simpan password baru</span>
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
