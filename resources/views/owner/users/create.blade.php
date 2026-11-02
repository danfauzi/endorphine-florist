<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 leading-tight">
            ➕ Tambah Akun Staf Baru
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-4">
                
                <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full text-xs font-semibold border border-slate-200 rounded-xl px-3 py-2 text-slate-700 focus:outline-none focus:ring-2 focus:ring-pink-500/20 focus:border-pink-500">
                        @error('name') <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full text-xs font-semibold border border-slate-200 rounded-xl px-3 py-2 text-slate-700 focus:outline-none focus:ring-2 focus:ring-pink-500/20 focus:border-pink-500">
                        @error('email') <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Role Staf</label>
                        <select name="role" required
                            class="w-full text-xs font-semibold border border-slate-200 rounded-xl px-3 py-2 text-slate-700 focus:outline-none focus:ring-2 focus:ring-pink-500/20 focus:border-pink-500">
                            <option value="">-- Pilih Role --</option>
                            <option value="admin">Admin</option>
                            <option value="kasir">Kasir</option>
                        </select>
                        @error('role') <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Password</label>
                        <input type="password" name="password" required
                            class="w-full text-xs font-semibold border border-slate-200 rounded-xl px-3 py-2 text-slate-700 focus:outline-none focus:ring-2 focus:ring-pink-500/20 focus:border-pink-500">
                        @error('password') <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" required
                            class="w-full text-xs font-semibold border border-slate-200 rounded-xl px-3 py-2 text-slate-700 focus:outline-none focus:ring-2 focus:ring-pink-500/20 focus:border-pink-500">
                    </div>

                    <div class="pt-4 flex justify-end gap-2">
                        <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-bold">
                            Batal
                        </a>
                        <button type="submit" class="px-5 py-2 bg-pink-600 hover:bg-pink-700 text-white rounded-xl text-xs font-bold shadow-md transition">
                            Simpan Staf Baru
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>