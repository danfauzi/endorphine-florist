<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-slate-800 leading-tight flex items-center gap-2">
                👥 Manajemen User & Hak Akses
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 bg-emerald-100 border border-emerald-200 text-emerald-700 rounded-2xl text-xs font-bold">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden p-6">
                <!-- Header Card dengan Tombol Tambah Akun -->
                <div class="flex justify-between items-center pb-6">
                    <div>
                        <h3 class="font-extrabold text-slate-800 text-base">Daftar Akun Terdaftar</h3>
                        <p class="text-xs text-slate-400 mt-0.5">Kelola akun admin dan kasir. Akun owner hanya dapat dilihat.</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.users.create') }}"
                           class="bg-pink-600 hover:bg-pink-700 text-white font-bold text-xs px-4 py-2 rounded-xl shadow-sm transition flex items-center gap-1.5">
                            ➕ Tambah Akun Baru
                        </a>
                        <span class="bg-pink-50 text-pink-600 text-xs font-bold px-3 py-1.5 rounded-full">
                            {{ method_exists($users, 'total') ? $users->total() : $users->count() }} Total User
                        </span>
                    </div>
                </div>

                <!-- Tabel Data User -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="text-slate-400 text-[10px] uppercase font-extrabold tracking-wider border-b border-slate-100">
                                <th class="py-3 px-4">Nama & Email</th>
                                <th class="py-3 px-4">Role / Hak Akses</th>
                                <th class="py-3 px-4">Bergabung Sejak</th>
                                <th class="py-3 px-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                            @forelse($users as $user)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <!-- Nama & Email -->
                                    <td class="py-4 px-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-xl bg-pink-500 text-white flex items-center justify-center font-black text-xs uppercase">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="font-bold text-slate-800">{{ $user->name }}</p>
                                                <p class="text-[11px] text-slate-400 font-medium">{{ $user->email }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Role hanya dapat diubah untuk akun admin dan kasir -->
                                    <td class="py-4 px-4">
                                        @if(in_array(strtolower($user->role), ['admin', 'kasir'], true))
                                            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="flex items-center gap-2">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="name" value="{{ $user->name }}">
                                                <select name="role" class="text-xs border border-slate-200 rounded-xl px-3 py-1.5 bg-white focus:outline-none font-bold text-slate-700">
                                                    <option value="admin" {{ strtolower($user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                                                    <option value="kasir" {{ strtolower($user->role) === 'kasir' ? 'selected' : '' }}>Kasir</option>
                                                </select>
                                                <button type="submit" class="px-3.5 py-1.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold rounded-xl transition cursor-pointer">
                                                    Ubah
                                                </button>
                                            </form>
                                        @else
                                            <span class="font-bold text-slate-500">{{ ucfirst($user->role) }} · Hanya lihat</span>
                                        @endif
                                    </td>

                                    <!-- Tanggal Bergabung -->
                                    <td class="py-4 px-4 text-slate-500 font-medium">
                                        {{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}
                                    </td>

                                    <!-- Tombol Aktifkan / Nonaktifkan -->
                                    <td class="py-4 px-4 text-center">
                                        @if(!in_array(strtolower($user->role), ['admin', 'kasir'], true))
                                            <span class="text-slate-400 italic text-[11px]">Tidak dapat diubah</span>
                                        @else
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="{{ route('admin.users.edit', $user->id) }}" class="rounded-xl bg-slate-100 px-3 py-1.5 text-xs font-bold text-slate-600 hover:bg-pink-50 hover:text-pink-600">Edit</a>
                                                @if(auth()->id() === $user->id)
                                                    <span class="text-slate-400 italic text-[11px]">Akun Anda</span>
                                                @else
                                                    <form action="{{ route('admin.users.toggle-status', $user->id) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="px-3 py-1.5 rounded-xl text-xs font-bold transition {{ $user->is_active ?? true ? 'bg-rose-50 text-rose-600 hover:bg-rose-100' : 'bg-emerald-50 text-emerald-600 hover:bg-emerald-100' }}">
                                                            {{ $user->is_active ?? true ? '🚫 Nonaktifkan' : '✅ Aktifkan' }}
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-8 text-center text-slate-400 font-medium">Belum ada data user.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if(method_exists($users, 'links'))
                    <div class="mt-4 border-t border-slate-100 pt-4">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>