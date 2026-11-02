<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Owner\BankAccountController;
use App\Http\Controllers\Owner\HeroSlideController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VoucherController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

// Controller khusus Owner

// =====================================================
// 1. BERANDA / KATALOG UTAMA (PUBLIK)
// =====================================================

Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/reviews', [ProductController::class, 'reviews'])->name('reviews.index');

// =====================================================
// 2. ROUTE YANG WAJIB LOGIN
// =====================================================

Route::middleware(['auth'])->group(function () {

    // -------------------------------------------------
    // REDIRECT UNIVERSAL DASHBOARD
    // -------------------------------------------------

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // -------------------------------------------------
    // PESANAN DAPAT DIPANTAU ADMIN DAN OWNER
    // -------------------------------------------------

    Route::middleware(['role:admin,owner'])->group(function () {
        Route::get('/admin/orders', [OrderController::class, 'adminOrders'])->name('admin.orders');
        Route::get('/admin/orders/{order}', [OrderController::class, 'adminOrderDetails'])->name('admin.orders.show');
    });

    // -------------------------------------------------
    // FITUR OPERASIONAL ADMIN
    // -------------------------------------------------

    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/products', [ProductController::class, 'adminIndex'])->name('products.index');
        Route::resource('products', ProductController::class)->except(['index', 'show']);

        Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
        Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
        Route::post('/admin/users', [UserController::class, 'store'])->name('admin.users.store');
        Route::get('/admin/users/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/admin/users/{id}', [UserController::class, 'update'])->name('admin.users.update');
        Route::patch('/admin/users/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('admin.users.toggle-status');

        Route::get('/admin/bank-accounts', [BankAccountController::class, 'index'])->name('admin.bank_accounts.index');
        Route::post('/admin/bank-accounts', [BankAccountController::class, 'store'])->name('admin.bank_accounts.store');
        Route::delete('/admin/bank-accounts/{bankAccount}', [BankAccountController::class, 'destroy'])->name('admin.bank_accounts.destroy');
        Route::patch('/admin/bank-accounts/{id}/toggle', [BankAccountController::class, 'toggle'])->name('admin.bank_accounts.toggle');

        Route::get('/admin/hero-slides', [HeroSlideController::class, 'index'])->name('admin.hero_slides.index');
        Route::patch('/admin/hero-slides/{heroSlide}', [HeroSlideController::class, 'update'])->name('admin.hero_slides.update');

        Route::get('/admin/vouchers', [VoucherController::class, 'index'])->name('admin.vouchers.index');
        Route::post('/admin/vouchers', [VoucherController::class, 'store'])->name('admin.vouchers.store');
        Route::patch('/admin/vouchers/{voucher}/toggle', [VoucherController::class, 'toggleStatus'])->name('admin.vouchers.toggle');
        Route::delete('/admin/vouchers/{voucher}', [VoucherController::class, 'destroy'])->name('admin.vouchers.destroy');
    });

    // =================================================
    // ROUTE KHUSUS OWNER
    // =================================================

    Route::middleware(['role:owner'])
        ->prefix('owner')
        ->name('owner.')
        ->group(function () {

            // -----------------------------------------
            // Dashboard Owner
            // -----------------------------------------

            Route::get('/dashboard', [OwnerController::class, 'dashboard'])
                ->name('dashboard');

            Route::get('/export-pdf', [OwnerController::class, 'exportPdf'])
                ->name('export.pdf');

            Route::get('/export-excel', [OwnerController::class, 'exportExcel'])
                ->name('export.excel');

            // Laporan Omset
            Route::get('/reports', [OwnerController::class, 'reports'])->name('reports');
            Route::get('/reports/chart', [OwnerController::class, 'chart'])->name('reports.chart');
        });

    // =================================================
    // ROUTE KHUSUS KASIR
    // =================================================

    Route::middleware(['role:kasir'])
        ->prefix('kasir')
        ->name('kasir.')
        ->group(function () {

            // -----------------------------------------
            // POS Walk-in
            // -----------------------------------------

            Route::get('/pos', function () {
                $products = Product::all();

                return view('cashier.pos', compact('products'));
            })->name('pos');

            // -----------------------------------------
            // Daftar Pesanan Masuk
            // -----------------------------------------

            Route::get('/orders', [OrderController::class, 'kasirIndex'])
                ->name('orders');

            Route::get('/orders/{order}/detail', [OrderController::class, 'cashierOrderDetail'])
                ->name('orders.detail');

            Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])
                ->name('orders.updateStatus');

            // Tambahan Route untuk Update Status Pembayaran (Sudah Dibayar/Belum Bayar)
            Route::patch('/orders/{id}/payment-status', [OrderController::class, 'updatePaymentStatus'])
                ->name('orders.updatePaymentStatus');

            // -----------------------------------------
            // Transaksi Walk-in / Manual
            // -----------------------------------------

            Route::get('/walkin', [OrderController::class, 'walkin'])
                ->name('walkin');

            Route::post('/walkin', [OrderController::class, 'storeWalkin'])
                ->name('walkin.store');

            // -----------------------------------------
            // Rekap Kas Harian & Penutupan Shift
            // -----------------------------------------

            Route::get('/recap', [OrderController::class, 'kasirRecap'])
                ->name('recap');

            Route::post('/recap', [OrderController::class, 'storeRecap'])
                ->name('recap.store');

            Route::post('/recap/modal', [OrderController::class, 'storeModal'])
                ->name('recap.storeModal');
        });

    // =================================================
    // ROUTE KHUSUS PELANGGAN
    // =================================================

    Route::middleware(['role:pelanggan'])
        ->prefix('pelanggan')
        ->name('pelanggan.')
        ->group(function () {

            Route::get('/dashboard', [DashboardController::class, 'pelanggan'])
                ->name('dashboard');
        });

    // =================================================
    // ROUTE UMUM PELANGGAN
    // =================================================

    // Cart
    Route::get('/cart', [CartController::class, 'index'])
        ->name('cart.index');

    Route::post('/cart/add/{product}', [CartController::class, 'addToCart'])
        ->name('cart.add');

    Route::delete('/cart/clear', [CartController::class, 'clear'])
        ->name('cart.clear');

    Route::patch('/cart/{id}', [CartController::class, 'update'])
        ->name('cart.update');

    Route::delete('/cart/{id}', [CartController::class, 'destroy'])
        ->name('cart.destroy');

    Route::post('/cart/apply-voucher', [CartController::class, 'applyVoucher'])
        ->name('cart.applyVoucher');

    Route::post('/cart/remove-voucher', [CartController::class, 'removeVoucher'])
        ->name('cart.removeVoucher');

    // Checkout
    Route::get('/checkout', [OrderController::class, 'checkout'])
        ->name('checkout');

    Route::post('/checkout', [OrderController::class, 'store'])
        ->name('checkout.store');

    // Orders
    Route::get('/my-orders', [OrderController::class, 'index'])
        ->name('orders.index');

    Route::get('/orders/success/{id}', [OrderController::class, 'success'])
        ->name('orders.success');

    Route::post('/orders/{order}/review', [OrderController::class, 'submitReview'])
        ->name('orders.review');

    // Tambahan Route Upload Bukti Bayar Susulan dari Halaman Sukses
    Route::post('/orders/{order}/upload-proof', [OrderController::class, 'uploadProof'])
        ->name('orders.uploadProof');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

// =====================================================
// AUTH
// =====================================================

require __DIR__.'/auth.php';
