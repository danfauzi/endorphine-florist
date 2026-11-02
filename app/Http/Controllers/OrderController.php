<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ShiftRecap;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class OrderController extends Controller
{
    // Form Checkout Pelanggan
    public function checkout()
    {
        $cartItems = Cart::where('user_id', auth()->id())->get();
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong.');
        }

        $subtotal = $cartItems->sum(fn ($item) => $item->product->price * $item->quantity);
        $discount = session('voucher')['discount'] ?? 0;
        $total = max(0, $subtotal - $discount);

        $bankAccounts = BankAccount::where('is_active', true)->get();

        // Arahkan ke file view khusus form checkout (Step 2)
        return view('cart.checkout', compact('cartItems', 'subtotal', 'total', 'bankAccounts'));
    }

    // Simpan Transaksi Masuk ke Web Database
    public function store(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string',
            'recipient_phone' => 'required|string',
            'payment_method' => 'required|string', // Pastikan input ini wajib dikirim dari form
        ]);

        if (in_array(strtolower($request->payment_method), ['cash', 'tunai'])) {
            return back()->withErrors([
                'payment_method' => 'Pembayaran Cash/Tunai hanya tersedia untuk pembelian offline di toko.',
            ])->withInput();
        }

        $cartItems = Cart::where('user_id', auth()->id())->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong.');
        }

        $voucherCode = session('voucher.code');
        if ($voucherCode) {
            $voucher = \App\Models\Voucher::whereRaw('UPPER(code) = ?', [strtoupper($voucherCode)])->first();

            if (! $voucher || ! $voucher->refreshStatus()) {
                session()->forget('voucher');

                return redirect()->route('cart.index')->with('error', 'Kode voucher sudah kadaluarsa atau habis digunakan.');
            }

            $voucher->decrement('quota');
            $voucher->refreshStatus();
        }

        $subtotal = $cartItems->sum(fn ($item) => $item->product->price * $item->quantity);
        $discount = session('voucher')['discount'] ?? 0;
        $totalPrice = max(0, $subtotal - $discount);
        $paymentMethod = in_array(strtolower($request->payment_method), ['cash', 'tunai'])
            ? 'Cash'
            : $request->payment_method;
        $isCashPayment = $paymentMethod === 'Cash';

        // Simpan data order
        $order = Order::create([
            'order_number' => 'ORD-'.date('Ymd').'-'.rand(100, 999),
            'user_id' => auth()->id(),
            'total_price' => $totalPrice,
            'payment_method' => $paymentMethod,
            'payment_status' => $isCashPayment ? 'paid' : 'unpaid',
            'status' => $isCashPayment ? 'completed' : 'pending',
            'shipping_address' => $request->shipping_address,
            'recipient_phone' => $request->recipient_phone,
            'greeting_card' => $request->greeting_card,
        ]);

        foreach ($cartItems as $item) {
            $order->items()->create([
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
                'note' => $item->note,
            ]);
        }

        Cart::where('user_id', auth()->id())->delete();
        session()->forget('voucher');

        return redirect()->route('orders.success', $order->id)->with('success', 'Pesanan berhasil dibuat!');
    }

    // Riwayat Pesanan Pelanggan
    public function index(Request $request)
    {
        $query = Order::with('items.product')->where('user_id', auth()->id());

        // Filter berdasarkan status dari query URL (?status=unpaid, dll)
        if ($request->has('status') && $request->status != '') {
            if ($request->status === 'unpaid') {
                $query->where('payment_status', 'unpaid');
            } else {
                $statusMap = [
                    'packed' => 'Dikemas',
                    'shipped' => 'Dikirim',
                ];

                if (array_key_exists($request->status, $statusMap)) {
                    $query->where('status', $statusMap[$request->status]);
                }
            }
        }

        if ($request->status === 'review') {
            $query->where('status', 'completed')
                ->where('payment_status', 'paid')
                ->whereNull('reviewed_at');
        }

        $orders = $query->latest()->get();

        return view('orders.index', compact('orders'));
    }

    // Dashboard Admin: Kelola Pesanan Masuk
    public function adminOrders()
    {
        // Mengambil semua data pesanan beserta relasi item dan user-nya
        $orders = Order::with('user', 'items.product')->latest()->get();

        return view('admin.orders', compact('orders'));
    }

    public function adminOrderDetails(Order $order): View
    {
        $order->load(['user', 'items.product']);

        return view('admin.order-details', compact('order'));
    }

    // Update Status Pesanan & Otomatis Sesuaikan Status Pembayaran
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'status' => 'required|string',
        ]);

        $newStatus = $request->status;
        $paymentStatus = $order->payment_status;

        if (in_array($newStatus, ['completed', 'selesai'])) {
            $paymentStatus = 'paid';
            $this->deductOrderStock($order);
        } elseif (in_array($newStatus, ['pending', 'cancelled', 'dibatalkan'])) {
            if ($order->type !== 'Walk-in') {
                $paymentStatus = 'unpaid';
            }
        }

        $order->update([
            'status' => $newStatus,
            'payment_status' => $paymentStatus,
        ]);

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui!');
    }

    // Dashboard Kasir
    public function kasirIndex(Request $request)
    {
        $query = Order::with(['user', 'items.product']);

        if ($request->has('date') && $request->date != '') {
            $query->whereDate('created_at', $request->date);
        }

        if ($request->filled('search')) {
            $search = trim($request->string('search')->toString());

            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', '%'.$search.'%')
                    ->orWhere('customer_name', 'like', '%'.$search.'%')
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', '%'.$search.'%');
                    });
            });
        }

        $menungguVerifikasi = (clone $query)
            ->where('payment_status', 'Menunggu Verifikasi')
            ->count();

        $orders = $query
            ->orderByRaw("CASE WHEN payment_status = 'Menunggu Verifikasi' THEN 0 ELSE 1 END")
            ->latest()
            ->get();

        // Omset dan metode pembayaran otomatis terhitung jika status 'completed' atau pembayaran 'paid'
        $rekapHarian = [
            'total_transaksi' => Order::whereDate('created_at', today())->count(),
            'total_pendapatan' => Order::whereDate('created_at', today())
                ->where(function ($q) {
                    $q->where('payment_status', 'paid')
                        ->orWhere('status', 'completed');
                })->sum('total_price'),
            'total_tunai' => Order::whereDate('created_at', today())
                ->where(function ($q) {
                    $q->where('payment_status', 'paid')
                        ->orWhere('status', 'completed');
                })
                ->whereIn('payment_method', ['Cash', 'Tunai'])->sum('total_price'),
            'total_qris' => Order::whereDate('created_at', today())
                ->where(function ($q) {
                    $q->where('payment_status', 'paid')
                        ->orWhere('status', 'completed');
                })
                ->whereNotIn('payment_method', ['Cash', 'Tunai'])->sum('total_price'),
        ];

        return view('cashier.orders', compact('orders', 'rekapHarian', 'menungguVerifikasi'));
    }

    public function cashierOrderDetail(Order $order)
    {
        $order->load(['user', 'items.product']);

        return view('cashier.order_detail', compact('order'));
    }

    // Menampilkan Halaman POS Walk-in Kasir
    public function walkin()
    {
        $products = Product::all();

        return view('dashboard.walkin', compact('products'));
    }

    // Process & Simpan Transaksi Walk-in Kasir
    public function storeWalkin(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'cart_data' => 'required',
            'payment_method' => 'required|string',
        ]);

        $cart = json_decode($request->cart_data, true);

        if (empty($cart)) {
            return back()->with('error', 'Keranjang belanja masih kosong!');
        }

        foreach ($cart as $item) {
            $product = Product::find($item['id']);

            if (! $product || $product->stock < $item['qty']) {
                return back()->with('error', 'Stok produk tidak mencukupi untuk transaksi ini.');
            }
        }

        $totalPrice = array_reduce($cart, function ($sum, $item) {
            return $sum + ($item['price'] * $item['qty']);
        }, 0);

        // Transaksi Walk-in langsung bernilai 'completed' & 'paid'
        // Simpan data order
        $order = Order::create([
            'order_number' => 'ORD-'.date('Ymd').'-'.rand(100, 999), // Tambahkan baris ini
            'user_id' => auth()->id(),
            'customer_name' => $request->customer_name,
            'total_price' => $totalPrice,
            'payment_method' => in_array(strtolower($request->payment_method), ['cash', 'tunai']) ? 'Cash' : 'QRIS',
            'payment_status' => 'paid',
            'status' => 'completed',
            'shipping_address' => $request->input('shipping_address', 'Transaksi Walk-in di Toko'),
            'recipient_phone' => $request->input('recipient_phone', '-'),
            'greeting_card' => $request->input('greeting_card'),
        ]);

        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'quantity' => $item['qty'],
                'price' => $item['price'],
            ]);
        }

        $this->deductOrderStock($order);

        return redirect()->route('kasir.orders')->with('success', 'Transaksi Walk-in berhasil diproses!');
    }

    // Halaman Sukses Pesanan
    public function success($id)
    {
        $order = Order::with('items.product')->findOrFail($id);

        abort_unless($order->user_id === auth()->id(), 403);

        return view('orders.success', compact('order'));
    }

    public function submitReview(Request $request, Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403);

        abort_unless(
            $order->status === 'completed'
                && $order->payment_status === 'paid'
                && $order->reviewed_at === null,
            422
        );

        $validated = $request->validate([
            'rating' => 'required|integer|between:1,5',
            'review' => 'required|string|max:1000',
        ]);

        $order->update([
            'rating' => $validated['rating'],
            'review' => $validated['review'],
            'reviewed_at' => now(),
        ]);

        return redirect()->route('orders.index', ['status' => 'review'])
            ->with('success', 'Penilaian berhasil dikirim. Terima kasih!');
    }

    // Halaman Rekap Kas Harian & Penutupan Shift Kasir
    public function kasirRecap(Request $request)
    {
        $today = Carbon::today();

        // Ambil modal awal dari session, jika belum ada set default 300000
        $modalAwal = session('modal_awal_kasir', 300000);

        $totalTunai = Order::whereDate('created_at', $today)
            ->where(function ($q) {
                $q->where('payment_status', 'paid')
                    ->orWhere('status', 'completed');
            })
            ->whereIn('payment_method', ['Cash', 'Tunai'])
            ->sum('total_price');

        $totalQris = Order::whereDate('created_at', $today)
            ->where(function ($q) {
                $q->where('payment_status', 'paid')
                    ->orWhere('status', 'completed');
            })
            ->whereNotIn('payment_method', ['Cash', 'Tunai'])
            ->sum('total_price');

        $jumlahTransaksiTunai = Order::whereDate('created_at', $today)
            ->where(function ($q) {
                $q->where('payment_status', 'paid')
                    ->orWhere('status', 'completed');
            })
            ->whereIn('payment_method', ['Cash', 'Tunai'])
            ->count();

        $jumlahTransaksiQris = Order::whereDate('created_at', $today)
            ->where(function ($q) {
                $q->where('payment_status', 'paid')
                    ->orWhere('status', 'completed');
            })
            ->whereNotIn('payment_method', ['Cash', 'Tunai'])
            ->count();

        $totalKasFisik = $modalAwal + $totalTunai;
        $totalPendapatan = $modalAwal + $totalTunai + $totalQris;

        // Query Riwayat Rekap dengan Filter Tanggal
        $queryRecap = ShiftRecap::with('user');
        if ($request->has('date') && $request->date != '') {
            $queryRecap->whereDate('created_at', $request->date);
        }
        $riwayatRecaps = $queryRecap->latest()->take(10)->get();

        return view('cashier.recap', compact(
            'modalAwal',
            'totalTunai',
            'totalQris',
            'jumlahTransaksiTunai',
            'jumlahTransaksiQris',
            'totalKasFisik',
            'totalPendapatan',
            'riwayatRecaps'
        ));
    }

    // Simpan Data Penutupan Shift / Rekap Kas
    public function storeRecap(Request $request)
    {
        $request->validate([
            'modal_awal' => 'required|numeric',
            'physical_cash' => 'required|numeric',
            'notes' => 'nullable|string',
        ]);

        $today = Carbon::today();

        $totalTunai = Order::whereDate('created_at', $today)
            ->where(function ($q) {
                $q->where('payment_status', 'paid')->orWhere('status', 'completed');
            })->whereIn('payment_method', ['Cash', 'Tunai'])->sum('total_price');

        $totalQris = Order::whereDate('created_at', $today)
            ->where(function ($q) {
                $q->where('payment_status', 'paid')->orWhere('status', 'completed');
            })->whereNotIn('payment_method', ['Cash', 'Tunai'])->sum('total_price');

        $modalAwal = $request->modal_awal;
        $totalKasFisik = $modalAwal + $totalTunai;
        $physicalCash = $request->physical_cash;

        $selisih = $physicalCash - $totalKasFisik;

        ShiftRecap::create([
            'user_id' => Auth::id(),
            'date' => $today,
            'modal_awal' => $modalAwal,
            'total_tunai' => $totalTunai,
            'total_qris' => $totalQris,
            'total_kas_fisik' => $totalKasFisik,
            'physical_cash' => $physicalCash,
            'selisih' => $selisih,
            'notes' => $request->notes,
        ]);

        return redirect()->route('kasir.recap')->with('success', 'Penutupan shift kasir berhasil disimpan!');
    }

    // Simpan Modal Awal Sementara
    public function storeModal(Request $request)
    {
        $request->validate([
            'modal_awal' => 'required|numeric',
        ]);

        // Simpan modal awal ke session agar tersimpan saat halaman direfresh
        session(['modal_awal_kasir' => $request->modal_awal]);

        return redirect()->route('kasir.recap')->with('success', 'Modal kas awal berhasil diperbarui!');
    }

    public function uploadProof(Request $request, Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403);

        $file = $request->file('payment_proof');

        if (! $file || ! $file->isValid()) {
            $uploadError = $file?->getError();
            $message = match ($uploadError) {
                UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE => 'File terlalu besar menurut konfigurasi server.',
                UPLOAD_ERR_PARTIAL => 'Upload terputus. Silakan coba lagi.',
                UPLOAD_ERR_NO_TMP_DIR => 'Folder temporary upload PHP tidak tersedia.',
                UPLOAD_ERR_CANT_WRITE => 'PHP tidak dapat menulis file temporary upload.',
                UPLOAD_ERR_EXTENSION => 'Upload dihentikan oleh extension PHP.',
                default => 'File tidak diterima oleh server. Silakan pilih gambar lagi.',
            };

            return redirect()->back()->withErrors(['payment_proof' => $message]);
        }

        $request->validate([
            'payment_proof' => 'required|image|max:2048',
        ], [
            'payment_proof.required' => 'Silakan pilih gambar bukti pembayaran.',
            'payment_proof.image' => 'Bukti pembayaran harus berupa gambar.',
            'payment_proof.max' => 'Ukuran bukti pembayaran maksimal 2 MB.',
            'payment_proof.uploaded' => 'File gagal diunggah. Coba gunakan gambar berukuran lebih kecil.',
        ]);

        $path = $file->store('payment-proofs', 'public');

        if ($path === false) {
            return redirect()->back()->withErrors([
                'payment_proof' => 'Bukti pembayaran gagal disimpan. Coba lagi.',
            ]);
        }

        $order->update([
            'payment_proof' => $path,
            'payment_status' => 'Menunggu Verifikasi',
        ]);

        return redirect()->route('orders.success', $order->id)
            ->with('success', 'Bukti Pembayaran Sudah Di Unggah, Menunggu Verifikasi Kasir');
    }

    public function updatePaymentStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'payment_status' => 'required|string',
        ]);

        if ($request->payment_status === 'paid') {
            $this->deductOrderStock($order);
        }

        $order->update([
            'payment_status' => $request->payment_status,
        ]);

        return redirect()->back()->with('success', 'Status pembayaran berhasil diperbarui!');
    }

    private function deductOrderStock(Order $order): void
    {
        if ($order->stock_deducted) {
            return;
        }

        DB::transaction(function () use ($order): void {
            $order->load('items');

            foreach ($order->items as $item) {
                $product = Product::query()->lockForUpdate()->findOrFail($item->product_id);

                if ($product->stock < $item->quantity) {
                    throw ValidationException::withMessages([
                        'status' => "Stok produk {$product->name} tidak mencukupi. Sisa stok: {$product->stock}.",
                    ]);
                }

                $product->decrement('stock', $item->quantity);
                $product->update([
                    'status' => $product->stock > 0 ? 'Ready' : 'Habis',
                ]);
            }

            $order->update(['stock_deducted' => true]);
        });
    }
}
