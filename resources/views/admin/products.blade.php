<x-app-layout>
    <x-slot name="header">
        <h2 class="flex items-center gap-3 text-2xl font-black leading-tight text-slate-800">
            <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-pink-50 text-pink-500 shadow-sm">🌸</span>
            <span>Kelola Produk & Katalog Buket</span>
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold rounded-2xl shadow-sm">
                    ✨ {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-800 text-sm font-semibold rounded-2xl shadow-sm">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form Tambah Produk -->
            <div class="mb-7 rounded-[1.75rem] border border-pink-100/70 bg-white p-6 shadow-[0_16px_34px_rgba(190,24,93,0.07)] sm:p-7">
                <div class="mb-6 border-b border-slate-100 pb-5">
                    <h3 class="text-lg font-extrabold tracking-tight text-slate-800">Tambah Produk Baru</h3>
                    <p class="mt-1 text-xs text-slate-400">Produk yang disimpan akan langsung tampil di katalog beranda.</p>
                </div>
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 items-end gap-4 md:grid-cols-2 lg:grid-cols-5">
                    @csrf
                    <div class="lg:col-span-2">
                        <label class="block text-xs font-bold text-slate-600 mb-1.5">Nama Produk</label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="w-full rounded-xl border-slate-200 bg-slate-50/70 text-sm outline-none transition focus:border-pink-400 focus:bg-white focus:ring-4 focus:ring-pink-100" placeholder="Contoh: Buket Mawar Premium">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1.5">Kategori</label>
                        <select name="category" required class="w-full rounded-xl border-slate-200 bg-slate-50/70 text-sm outline-none transition focus:border-pink-400 focus:bg-white focus:ring-4 focus:ring-pink-100">
                            @foreach(['bunga' => 'Bunga', 'snack' => 'Snack', 'uang' => 'Uang', 'kado' => 'Kado', 'wisuda' => 'Wisuda'] as $value => $label)
                                <option value="{{ $value }}" {{ old('category') === $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1.5">Harga</label>
                        <input type="number" name="price" value="{{ old('price') }}" min="0" step="1000" required class="w-full rounded-xl border-slate-200 bg-slate-50/70 text-sm outline-none transition focus:border-pink-400 focus:bg-white focus:ring-4 focus:ring-pink-100" placeholder="150000">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1.5">Stok</label>
                        <input type="number" name="stock" value="{{ old('stock', 0) }}" min="0" required class="w-full rounded-xl border-slate-200 bg-slate-50/70 text-sm outline-none transition focus:border-pink-400 focus:bg-white focus:ring-4 focus:ring-pink-100">
                    </div>
                    <div class="lg:col-span-2">
                        <label class="block text-xs font-bold text-slate-600 mb-1.5">Deskripsi</label>
                        <textarea name="description" rows="2" class="w-full rounded-xl border-slate-200 bg-slate-50/70 text-sm outline-none transition focus:border-pink-400 focus:bg-white focus:ring-4 focus:ring-pink-100" placeholder="Deskripsi produk untuk katalog">{{ old('description') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1.5">Foto Produk</label>
                        <input type="file" name="image" accept="image/jpeg,image/png,image/webp" class="w-full rounded-xl border border-slate-200 bg-slate-50/70 p-2 text-xs text-slate-500 file:mr-3 file:rounded-lg file:border-0 file:bg-pink-100 file:px-3 file:py-1.5 file:text-xs file:font-bold file:text-pink-600">
                    </div>
                    <button type="submit" class="lg:col-span-2 rounded-xl bg-gradient-to-r from-pink-500 to-rose-500 py-3.5 text-sm font-extrabold text-white shadow-[0_12px_24px_rgba(236,72,153,0.24)] transition hover:-translate-y-0.5 hover:shadow-lg">Tambah ke Katalog</button>
                </form>
            </div>

            <!-- Tabel Data Produk -->
            <div class="overflow-hidden rounded-[1.75rem] border border-pink-100/70 bg-white shadow-[0_18px_40px_rgba(190,24,93,0.08)]">
                <div class="flex items-center justify-between gap-4 border-b border-slate-100 bg-gradient-to-r from-white to-pink-50/40 p-6">
                    <div>
                        <h3 class="text-lg font-extrabold tracking-tight text-slate-800">Daftar Produk Toko</h3>
                        <p class="mt-1 text-xs text-slate-400">Tambah, ubah harga, atau hapus item buket bunga.</p>
                    </div>
                    <span class="shrink-0 rounded-full border border-pink-100 bg-pink-50 px-3 py-1.5 text-xs font-extrabold text-pink-600">
                        {{ $products->count() }} Total Produk
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-[900px] w-full border-collapse text-left">
                        <thead>
                            <tr class="border-b border-slate-100 bg-slate-50/80 text-[11px] font-extrabold uppercase tracking-wider text-slate-400">
                                <th class="py-4 px-5">Produk</th>
                                <th class="py-4 px-5">Kategori</th>
                                <th class="py-4 px-5">Harga</th>
                                <th class="py-4 px-5">Stok</th>
                                <th class="py-4 px-5 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            @forelse($products as $product)
                                <tr class="align-middle transition-colors hover:bg-pink-50/25">
                                    <td class="px-5 py-5">
                                        <div class="flex items-center gap-3">
                                        @if($product->image)
                                            <img src="{{ str_starts_with($product->image, 'http') || str_starts_with($product->image, 'data:') ? $product->image : asset('storage/' . $product->image) }}" class="h-12 w-12 rounded-xl object-cover shadow-sm ring-2 ring-pink-50">
                                        @else
                                            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-pink-100 text-xs font-bold text-pink-600">🌸</div>
                                        @endif
                                        <div>
                                            <p class="font-extrabold text-slate-800">{{ $product->name }}</p>
                                        </div>
                                        </div>
                                        <p class="mt-2 max-w-xs text-xs leading-relaxed text-slate-400">{{ $product->description ?? 'Tidak ada deskripsi.' }}</p>
                                    </td>
                                    <td class="px-5 py-5 text-xs font-semibold capitalize text-slate-600">{{ $product->category ?? 'Umum' }}</td>
                                    <td class="px-5 py-5 font-black text-pink-600">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                    <td class="px-5 py-5">
                                        <span class="px-3 py-1 rounded-full text-xs font-bold {{ $product->stock > 0 ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 'bg-rose-50 text-rose-600 border border-rose-100' }}">
                                            {{ $product->stock }} Stok
                                        </span>
                                    </td>
                                    <td class="px-5 py-5 text-center">
                                        <div class="flex justify-center gap-2">
                                            <button type="button" onclick="document.getElementById('edit-product-{{ $product->id }}').classList.toggle('hidden')" class="px-3 py-1.5 bg-amber-50 hover:bg-amber-500 text-amber-600 hover:text-white text-xs font-bold rounded-xl transition">Edit</button>
                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-500 text-rose-500 hover:text-white text-xs font-bold rounded-xl transition">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <tr id="edit-product-{{ $product->id }}" class="hidden bg-amber-50/40">
                                    <td colspan="5" class="p-5">
                                        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-3 items-end">
                                            @csrf
                                            @method('PUT')
                                            <div class="lg:col-span-2"><label class="block text-xs font-bold text-slate-600 mb-1">Nama</label><input type="text" name="name" value="{{ $product->name }}" required class="w-full rounded-xl border-slate-200 text-sm"></div>
                                            <div><label class="block text-xs font-bold text-slate-600 mb-1">Kategori</label><select name="category" required class="w-full rounded-xl border-slate-200 text-sm">@foreach(['bunga' => 'Bunga', 'snack' => 'Snack', 'uang' => 'Uang', 'kado' => 'Kado', 'wisuda' => 'Wisuda'] as $value => $label)<option value="{{ $value }}" {{ strtolower($product->category) === $value ? 'selected' : '' }}>{{ $label }}</option>@endforeach</select></div>
                                            <div><label class="block text-xs font-bold text-slate-600 mb-1">Harga</label><input type="number" name="price" value="{{ $product->price }}" min="0" step="1000" required class="w-full rounded-xl border-slate-200 text-sm"></div>
                                            <div><label class="block text-xs font-bold text-slate-600 mb-1">Stok</label><input type="number" name="stock" value="{{ $product->stock ?? 0 }}" min="0" required class="w-full rounded-xl border-slate-200 text-sm"></div>
                                            <div><label class="block text-xs font-bold text-slate-600 mb-1">Foto Baru</label><input type="file" name="image" accept="image/jpeg,image/png,image/webp" class="w-full text-xs"></div>
                                            <div class="lg:col-span-5"><label class="block text-xs font-bold text-slate-600 mb-1">Deskripsi</label><textarea name="description" rows="2" class="w-full rounded-xl border-slate-200 text-sm">{{ $product->description }}</textarea></div>
                                            <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white font-bold text-sm py-2.5 rounded-xl transition">Simpan Perubahan</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-16 text-slate-400 text-sm">
                                        Belum ada produk terdaftar.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>