<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                🛒 POS Walk-in (Kasir Toko)
            </h2>
            <div class="text-right">
                <span class="text-xs text-slate-400 font-bold uppercase tracking-wider block">Tanggal Transaksi</span>
                <span class="text-sm font-extrabold text-slate-700">{{ date('d M Y') }}</span>
            </div>
        </div>
    </x-slot>

    <!-- STATE UTAMA ALPINE.JS -->
    <div class="py-6" x-data="{
        searchQuery: '',
        selectedCategory: 'semua',
        categoryOptions: [
            { value: 'semua', label: 'Semua Produk' },
            { value: 'bunga', label: 'Buket Bunga' },
            { value: 'snack', label: 'Buket Snack' },
            { value: 'uang', label: 'Buket Uang' },
            { value: 'wisuda', label: 'Buket Wisuda' },
            { value: 'kado', label: 'Buket Kado' },
        ],
        paymentMethod: 'Cash',
        showReceiptModal: false,
        products: {{ \Illuminate\Support\Js::from($products) }},
        cart: [],

        addToCart(product) {
            let existing = this.cart.find(item => item.id === product.id);
            if (existing) {
                existing.qty++;
            } else {
                this.cart.push({ ...product, qty: 1 });
            }
        },

        decreaseQty(item) {
            if (item.qty > 1) {
                item.qty--;
            } else {
                this.cart = this.cart.filter(c => c.id !== item.id);
            }
        },

        increaseQty(item) {
            item.qty++;
        },

        get subtotal() {
            return this.cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
        },

        get filteredProducts() {
            return this.products.filter(product => {
                let matchSearch = product.name.toLowerCase().includes(this.searchQuery.toLowerCase());
                let matchCategory = this.selectedCategory === 'semua' || product.category.toLowerCase() === this.selectedCategory;
                return matchSearch && matchCategory;
            });
        },

        processPayment() {
            if (this.cart.length === 0) {
                alert('Keranjang pesanan masih kosong!');
                return;
            }
            this.$refs.walkinForm.submit();
        }
    }">

        @if(session('error'))
            <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm font-semibold text-rose-700">
                ⚠️ {{ session('error') }}
            </div>
        @endif

        <!-- WRAPPER LAYOUT 2 KOLOM (GRID) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

            <!-- KOLOM KIRI: KATALOG PRODUK (7 Kolom) -->
            <div class="lg:col-span-7 space-y-6">
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
                    
                    <!-- Search Box & Filter Kategori -->
                    <div class="space-y-4 mb-6">
                        <div class="relative">
                            <span class="absolute left-3.5 top-3 text-slate-400">🔍</span>
                            <input type="text" 
                                   x-model="searchQuery"
                                   placeholder="Cari nama buket / bunga..." 
                                   class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-pink-500 focus:ring-1 focus:ring-pink-500 transition">
                        </div>
                        
                        <!-- Badges Kategori -->
                        <div class="flex items-center gap-2 overflow-x-auto pb-1">
                                <template x-for="cat in categoryOptions" :key="cat.value">
                                <button type="button" @click="selectedCategory = cat.value"
                                    :class="selectedCategory === cat.value ? 'bg-pink-600 text-white shadow-sm' : 'bg-slate-100 hover:bg-slate-200 text-slate-600'"
                                        class="px-4 py-2 rounded-xl text-xs font-bold whitespace-nowrap transition"
                                    x-text="cat.label">
                                </button>
                            </template>
                        </div>
                    </div>

                    <!-- GRID PRODUK -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                        <template x-for="product in filteredProducts" :key="product.id">
                            <div class="border border-slate-200 hover:border-pink-500 rounded-2xl p-3 transition group flex flex-col justify-between bg-slate-50/50 hover:bg-pink-50/30">
                                <div>
                                    <!-- CONTAINER GAMBAR / ICON -->
                                    <div class="w-full h-28 bg-slate-200/60 rounded-xl mb-3 flex items-center justify-center overflow-hidden">
                                        <template x-if="product.image">
                                            <img :src="product.image.startsWith('http') ? product.image : '/storage/' + product.image" 
                                                 :alt="product.name" 
                                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                        </template>
                                        <template x-if="!product.image">
                                            <span class="text-4xl" x-text="product.icon || '💐'"></span>
                                        </template>
                                    </div>

                                    <h4 class="font-bold text-slate-800 text-xs group-hover:text-pink-600 transition line-clamp-1" x-text="product.name"></h4>
                                    <p class="text-xs text-pink-600 font-extrabold mt-1" x-text="'Rp ' + Number(product.price).toLocaleString('id-ID')"></p>
                                </div>

                                <button @click="addToCart(product)" 
                                        class="w-full mt-3 py-2 bg-slate-900 group-hover:bg-pink-600 text-white text-xs font-bold rounded-xl transition shadow-sm">
                                    + Tambah
                                </button>
                            </div>
                        </template>

                        <!-- Tampilan Jika Produk Tidak Ditemukan -->
                        <div x-show="filteredProducts.length === 0" class="col-span-full py-12 text-center text-slate-400 text-xs">
                            Tidak ada produk yang sesuai dengan pencarian/kategori.
                        </div>
                    </div>

                </div>
            </div>

            <!-- KOLOM KANAN: RINGKASAN KERANJANG (5 Kolom) -->
            <form x-ref="walkinForm" method="POST" action="{{ route('kasir.walkin.store') }}" class="lg:col-span-5 space-y-6">
                @csrf
                <input type="hidden" name="cart_data" :value="JSON.stringify(cart)">
                <input type="hidden" name="payment_method" :value="paymentMethod">
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 flex flex-col justify-between">
                    
                    <div>
                        <div class="border-b border-slate-100 pb-4 mb-5 flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-bold text-slate-800">Item Pesanan</h3>
                                <p class="text-[11px] text-slate-400 mt-0.5">Transaksi langsung di toko</p>
                            </div>
                            <span class="text-xs text-pink-600 font-bold bg-pink-50 border border-pink-100 px-3 py-1.5 rounded-full">Walk-in</span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-5">
                            <div>
                                <label class="block text-[11px] font-extrabold text-slate-600 uppercase tracking-wider mb-1.5">Nama Pelanggan</label>
                                <input type="text" name="customer_name" value="Pelanggan Walk-in" required
                                    class="w-full px-3 py-3 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:bg-white focus:outline-none focus:ring-2 focus:ring-pink-500/20 focus:border-pink-500"
                                    placeholder="Nama pelanggan">
                            </div>
                            <div>
                                <label class="block text-[11px] font-extrabold text-slate-600 uppercase tracking-wider mb-1.5">No. WhatsApp</label>
                                <input type="text" name="recipient_phone"
                                    class="w-full px-3 py-3 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:bg-white focus:outline-none focus:ring-2 focus:ring-pink-500/20 focus:border-pink-500"
                                    placeholder="08xxxxxxxxxx">
                            </div>
                            <div class="sm:col-span-2">
                                <label for="greeting_card" class="block text-[11px] font-extrabold text-slate-600 uppercase tracking-wider mb-1.5">Catatan Bunga / Catatan Toko</label>
                                <textarea id="greeting_card" name="greeting_card" rows="2"
                                    class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-3 text-xs font-semibold focus:border-pink-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-pink-500/20"
                                    placeholder="Opsional, misalnya warna pita atau pesan khusus"></textarea>
                            </div>
                        </div>

                        <!-- LIST ITEM KERANJANG -->
                        <div class="space-y-3 max-h-[320px] overflow-y-auto pr-1">
                            <template x-for="item in cart" :key="item.id">
                                <div class="flex items-center justify-between p-3 bg-slate-50 border border-slate-100 rounded-2xl">
                                    <div class="flex-1 pr-2">
                                        <h5 class="text-xs font-bold text-slate-800" x-text="item.name"></h5>
                                        <p class="text-[11px] text-pink-600 font-bold mt-0.5" x-text="'Rp ' + (item.price * item.qty).toLocaleString('id-ID')"></p>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <button type="button" @click="decreaseQty(item)" class="w-6 h-6 rounded-lg bg-white border border-slate-200 text-slate-700 font-bold flex items-center justify-center text-xs hover:bg-slate-100">-</button>
                                        <span class="text-xs font-bold text-slate-800 w-4 text-center" x-text="item.qty"></span>
                                        <button type="button" @click="increaseQty(item)" class="w-6 h-6 rounded-lg bg-white border border-slate-200 text-slate-700 font-bold flex items-center justify-center text-xs hover:bg-slate-100">+</button>
                                    </div>
                                </div>
                            </template>

                            <div x-show="cart.length === 0" class="py-16 text-center text-slate-400 text-xs">
                                🛒 Keranjang masih kosong.<br>Klik <b>+ Tambah</b> pada produk.
                            </div>
                        </div>
                    </div>

                    <!-- RINGKASAN TOTAL & TOMBOL BAYAR -->
                    <div class="border-t border-slate-100 pt-4 space-y-4 mt-6">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-slate-500 font-medium">Subtotal</span>
                            <span class="font-bold text-slate-800" x-text="'Rp ' + subtotal.toLocaleString('id-ID')"></span>
                        </div>
                        <div class="flex justify-between items-center text-base font-extrabold text-slate-900 pt-2 border-t border-dashed border-slate-200">
                            <span>TOTAL BAYAR</span>
                            <span class="text-xl text-pink-600" x-text="'Rp ' + subtotal.toLocaleString('id-ID')"></span>
                        </div>

                        <!-- Sakelar Pilihan Metode Pembayaran -->
                        <div>
                            <p class="text-[11px] font-extrabold text-slate-600 uppercase tracking-wider mb-2">Metode Pembayaran</p>
                            <div class="grid grid-cols-2 gap-3">
                            <button type="button" @click="paymentMethod = 'Cash'" 
                                    :class="paymentMethod === 'Cash' ? 'bg-pink-600 text-white shadow-md shadow-pink-200' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                                    class="py-3.5 px-3 rounded-xl text-xs font-bold flex items-center justify-center gap-2 transition border border-transparent">
                                💵 <span>Cash / Tunai</span>
                            </button>
                            <button type="button" @click="paymentMethod = 'QRIS'" 
                                    :class="paymentMethod === 'QRIS' ? 'bg-pink-600 text-white shadow-md shadow-pink-200' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                                    class="py-3.5 px-3 rounded-xl text-xs font-bold flex items-center justify-center gap-2 transition border border-transparent">
                                📱 <span>Transfer / QRIS</span>
                            </button>
                            </div>
                        </div>

                        <!-- Tombol Eksekusi Pembayaran -->
                        <button type="button" @click="processPayment()" 
                                class="w-full py-3.5 bg-slate-900 hover:bg-slate-800 text-white font-extrabold rounded-2xl text-xs transition shadow-lg shadow-slate-200 flex items-center justify-center gap-2">
                            <span>✅</span> Simpan Pembayaran & Cetak Struk
                        </button>
                    </div>

                </div>
            </form>

        </div>

        <!-- MODAL POPUP STRUK PEMBAYARAN -->
        <div x-show="showReceiptModal" 
             x-transition 
             class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4"
             style="display: none;">
            
            <div class="bg-white rounded-3xl p-6 w-full max-w-sm shadow-2xl space-y-4">
                <div class="text-center border-b border-slate-100 pb-4">
                    <h3 class="font-extrabold text-lg text-slate-800">Endorphine Florist</h3>
                    <p class="text-[11px] text-slate-400">Struk Pembayaran POS Walk-in</p>
                    <p class="text-[10px] text-slate-400 mt-1" x-text="'Metode: ' + paymentMethod + ' | ' + new Date().toLocaleTimeString('id-ID')"></p>
                </div>

                <div class="space-y-2 text-xs max-h-48 overflow-y-auto">
                    <template x-for="item in cart" :key="item.id">
                        <div class="flex justify-between text-slate-700">
                            <div>
                                <span x-text="item.name"></span>
                                <span class="text-slate-400" x-text="'x' + item.qty"></span>
                            </div>
                            <span class="font-bold" x-text="'Rp ' + (item.price * item.qty).toLocaleString('id-ID')"></span>
                        </div>
                    </template>
                </div>

                <div class="border-t border-dashed border-slate-200 pt-3 flex justify-between font-extrabold text-sm text-slate-900">
                    <span>TOTAL</span>
                    <span class="text-pink-600" x-text="'Rp ' + subtotal.toLocaleString('id-ID')"></span>
                </div>

                <div class="grid grid-cols-2 gap-2 pt-2">
                    <button @click="showReceiptModal = false" class="py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition">
                        Tutup
                    </button>
                    <button @click="window.print()" class="py-2.5 bg-pink-600 hover:bg-pink-700 text-white rounded-xl text-xs font-bold transition shadow-sm">
                        🖨️ Cetak
                    </button>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>