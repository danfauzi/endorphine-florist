<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-xl text-slate-800 leading-tight flex items-center gap-2">
                🖼️ Kelola Slide Beranda
            </h2>
            <p class="text-xs text-slate-500 mt-1">Atur 5 gambar dan teks hero yang tampil di halaman utama.</p>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">
            @if(session('success'))
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-700">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="rounded-2xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm font-semibold text-rose-700">
                    ⚠️ {{ $errors->first() }}
                </div>
            @endif

            <div class="grid grid-cols-1 xl:grid-cols-2 gap-5">
                @foreach($slides as $slide)
                    <form action="{{ route('admin.hero_slides.update', $slide) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
                        @csrf
                        @method('PATCH')
                        <div class="relative aspect-[4/3] sm:aspect-[16/7] max-h-[280px] bg-slate-900">
                            @if($slide->image)
                                <img src="{{ str_starts_with($slide->image, 'http') ? $slide->image : asset('storage/' . $slide->image) }}" alt="Slide {{ $slide->slot }}" class="w-full h-full object-contain">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-400 text-sm">Belum ada gambar</div>
                            @endif
                            <div class="absolute inset-0 bg-black/35"></div>
                            <span class="absolute top-4 left-4 rounded-full bg-white/90 px-3 py-1 text-xs font-black text-pink-600">Slide {{ $slide->slot }}</span>
                            <span class="absolute bottom-4 left-4 right-4 text-white text-lg font-black line-clamp-1">{{ $slide->title }}</span>
                        </div>

                        <div class="p-5 space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-600 mb-1.5">Ganti Gambar</label>
                                <input type="file" name="image" accept="image/jpeg,image/png,image/webp" class="w-full text-xs text-slate-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-600 mb-1.5">Label Kecil</label>
                                <input type="text" name="eyebrow" value="{{ $slide->eyebrow }}" class="w-full rounded-xl border-slate-200 text-sm focus:border-pink-500 focus:ring-pink-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-600 mb-1.5">Judul Slide</label>
                                <input type="text" name="title" value="{{ $slide->title }}" required class="w-full rounded-xl border-slate-200 text-sm focus:border-pink-500 focus:ring-pink-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-600 mb-1.5">Deskripsi</label>
                                <textarea name="description" rows="3" class="w-full rounded-xl border-slate-200 text-sm focus:border-pink-500 focus:ring-pink-500">{{ $slide->description }}</textarea>
                            </div>
                            <div class="flex items-center justify-between gap-3 pt-1">
                                <label class="inline-flex items-center gap-2 text-xs font-bold text-slate-600">
                                    <input type="checkbox" name="is_active" value="1" {{ $slide->is_active ? 'checked' : '' }} class="rounded border-slate-300 text-pink-600 focus:ring-pink-500">
                                    Tampilkan slide
                                </label>
                                <button type="submit" class="rounded-xl bg-pink-600 px-4 py-2.5 text-xs font-bold text-white shadow-sm transition hover:bg-pink-700">Simpan Slide {{ $slide->slot }}</button>
                            </div>
                        </div>
                    </form>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
