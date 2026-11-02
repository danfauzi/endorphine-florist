<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Akun - Endorphine Florist</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>

<body class="flex min-h-screen flex-col bg-[radial-gradient(circle_at_top_left,_#fff1f7,_transparent_34%),#fffafb] text-slate-800 selection:bg-pink-500 selection:text-white">

    <!-- Header Dynamic Navigation berdasarkan Role -->
    <header class="sticky top-0 z-50 border-b border-pink-100/80 bg-white/85 shadow-[0_8px_24px_rgba(190,24,93,0.06)] backdrop-blur-md">
        <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="group flex items-center gap-2 text-xl font-black tracking-tight text-pink-600">
                <span class="text-2xl transition duration-300 group-hover:scale-110">🌸</span>
                <span>Endorphine<span class="text-slate-800">Florist</span></span>
            </a>

            @if(auth()->user()->role === 'kasir')
                <a href="{{ route('kasir.orders') }}" class="group inline-flex items-center gap-2 rounded-full border border-pink-100 bg-pink-50 px-4 py-2.5 text-xs font-extrabold text-pink-600 shadow-sm transition hover:-translate-y-0.5 hover:bg-pink-100">
                    <svg class="h-3.5 w-3.5 transition-transform group-hover:-translate-x-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m6 6-6-6 6-6"></path></svg><span>Kembali ke POS Kasir</span>
                </a>
            @elseif(auth()->user()->role === 'admin')
                <a href="{{ route('dashboard') }}" class="group inline-flex items-center gap-2 rounded-full border border-pink-100 bg-pink-50 px-4 py-2.5 text-xs font-extrabold text-pink-600 shadow-sm transition hover:-translate-y-0.5 hover:bg-pink-100">
                    <svg class="h-3.5 w-3.5 transition-transform group-hover:-translate-x-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m6 6-6-6 6-6"></path></svg><span>Kembali ke Dashboard Admin</span>
                </a>
            @elseif(auth()->user()->role === 'owner')
                <a href="{{ route('owner.dashboard') }}" class="group inline-flex items-center gap-2 rounded-full border border-pink-100 bg-pink-50 px-4 py-2.5 text-xs font-extrabold text-pink-600 shadow-sm transition hover:-translate-y-0.5 hover:bg-pink-100">
                    <svg class="h-3.5 w-3.5 transition-transform group-hover:-translate-x-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m6 6-6-6 6-6"></path></svg><span>Kembali ke Dashboard Owner</span>
                </a>
            @else
                <a href="{{ route('home') }}" class="group inline-flex items-center gap-2 rounded-full border border-pink-100 bg-pink-50 px-4 py-2.5 text-xs font-extrabold text-pink-600 shadow-sm transition hover:-translate-y-0.5 hover:bg-pink-100">
                    <svg class="h-3.5 w-3.5 transition-transform group-hover:-translate-x-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m6 6-6-6 6-6"></path></svg><span>Kembali ke Katalog Toko</span>
                </a>
            @endif
        </div>
    </header>

    <!-- Content Area -->
    <main class="mx-auto w-full max-w-4xl flex-grow px-4 py-10 sm:px-6 lg:px-8">
        
        <div class="mb-8 text-center sm:text-left">
            <span class="rounded-full border border-pink-100 bg-pink-50 px-3 py-1 text-xs font-extrabold uppercase tracking-widest text-pink-600">
                PENGATURAN ({{ strtoupper(auth()->user()->role ?? 'PELANGGAN') }})
            </span>
            <h1 class="mt-2 text-2xl font-black tracking-tight text-slate-800 sm:text-3xl">Pengaturan Profil & Keamanan</h1>
            <p class="text-slate-400 text-xs sm:text-sm mt-1">Kelola informasi akun, foto profil, dan kata sandi kamu di sini.</p>
        </div>

        <div class="space-y-6">

            <!-- Card Update Profile Information + Foto Profil -->
            <div class="rounded-[1.75rem] border border-pink-100/70 bg-white p-6 shadow-[0_14px_34px_rgba(190,24,93,0.07)] transition hover:-translate-y-0.5 hover:shadow-[0_18px_40px_rgba(190,24,93,0.10)] sm:p-8">
                <div class="mb-6 flex items-center gap-3 border-b border-slate-100 pb-4">
                    <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-pink-50 font-bold text-pink-600">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="8" r="3"></circle><path stroke-linecap="round" d="M5 20a7 7 0 0 1 14 0"></path></svg>
                    </div>
                    <div>
                        <h2 class="font-extrabold text-slate-800 text-base">Informasi Akun & Foto Profil</h2>
                        <p class="text-xs text-slate-400">Perbarui foto profil, nama lengkap, dan email akunmu.</p>
                    </div>
                </div>

                <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6 max-w-xl" x-data="{ photoPreview: null }">
                    @csrf
                    @method('patch')

                    <!-- Foto Profil Upload Area -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Foto Profil</label>
                        <div class="flex items-center gap-4">
                            <!-- Preview Foto Saat Ini / Default -->
                            <div class="relative w-20 h-20 rounded-full overflow-hidden border-2 border-pink-200 bg-pink-50 flex items-center justify-center text-pink-600 font-extrabold text-2xl shadow-sm">
                                <template x-if="!photoPreview">
                                    @if(auth()->user()->avatar)
                                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="w-full h-full object-cover">
                                    @else
                                        <span>{{ substr(auth()->user()->name, 0, 1) }}</span>
                                    @endif
                                </template>
                                <template x-if="photoPreview">
                                    <img :src="photoPreview" class="w-full h-full object-cover">
                                </template>
                            </div>

                            <div>
                                <input type="file" name="avatar" id="avatar" class="hidden" accept="image/*"
                                    @change="
                                        const file = $event.target.files[0];
                                        if (file) {
                                            const reader = new FileReader();
                                            reader.onload = (e) => { photoPreview = e.target.result; };
                                            reader.readAsDataURL(file);
                                        }
                                    ">
                                <label for="avatar" class="cursor-pointer bg-slate-100 hover:bg-pink-50 text-slate-700 hover:text-pink-600 text-xs font-bold px-4 py-2 rounded-xl transition inline-block border border-slate-200/80">
                                    📷 Pilih Foto Baru
                                </label>
                                <p class="text-[10px] text-slate-400 mt-1">Format: JPG, PNG, WEBP (Max: 2MB)</p>
                            </div>
                        </div>
                        @error('avatar')
                            <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Input Nama -->
                    <div>
                        <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Lengkap</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                            class="w-full text-xs font-semibold bg-slate-50 focus:bg-white border border-slate-200 rounded-2xl p-3 focus:ring-2 focus:ring-pink-500 focus:outline-none transition">
                        @error('name')
                            <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Input Email -->
                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Alamat Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                            class="w-full text-xs font-semibold bg-slate-50 focus:bg-white border border-slate-200 rounded-2xl p-3 focus:ring-2 focus:ring-pink-500 focus:outline-none transition">
                        @error('email')
                            <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-4 pt-2">
                        <button type="submit" class="bg-pink-600 hover:bg-pink-700 text-white text-xs font-extrabold px-6 py-3 rounded-2xl shadow-md shadow-pink-200 transition">
                            💾 Simpan Perubahan
                        </button>

                        @if (session('status') === 'profile-updated')
                            <p class="text-xs font-bold text-emerald-600 animate-pulse">
                                ✓ Profil berhasil diperbarui!
                            </p>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Card Ubah Password -->
            <div class="rounded-[1.75rem] border border-pink-100/70 bg-white p-6 shadow-[0_14px_34px_rgba(190,24,93,0.07)] transition hover:-translate-y-0.5 hover:shadow-[0_18px_40px_rgba(190,24,93,0.10)] sm:p-8">
                <div class="mb-6 flex items-center gap-3 border-b border-slate-100 pb-4">
                    <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-amber-50 font-bold text-amber-600">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="5" y="10" width="14" height="10" rx="2"></rect><path stroke-linecap="round" d="M8 10V7a4 4 0 0 1 8 0v3"></path></svg>
                    </div>
                    <div>
                        <h2 class="font-extrabold text-slate-800 text-base">Ubah Kata Sandi</h2>
                        <p class="text-xs text-slate-400">Gunakan kata sandi yang kuat demi keamanan akun.</p>
                    </div>
                </div>

                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Card Hapus Akun -->
            <div class="rounded-[1.75rem] border border-rose-100/80 bg-white p-6 shadow-[0_14px_34px_rgba(190,24,93,0.06)] transition hover:-translate-y-0.5 hover:shadow-[0_18px_40px_rgba(190,24,93,0.10)] sm:p-8">
                <div class="mb-6 flex items-center gap-3 border-b border-slate-100 pb-4">
                    <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-rose-50 font-bold text-rose-600">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3 2.8 20h18.4zM12 9v4m0 3h.01"></path></svg>
                    </div>
                    <div>
                        <h2 class="font-extrabold text-rose-600 text-base">Hapus Akun</h2>
                        <p class="text-xs text-slate-400">Tindakan bersifat permanen dan data akun akan terhapus.</p>
                    </div>
                </div>

                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </main>

    <footer class="bg-white border-t border-pink-100/60 py-6 text-center text-xs text-slate-400 mt-auto">
        &copy; {{ date('Y') }} Endorphine Florist. All rights reserved.
    </footer>

</body>
</html>