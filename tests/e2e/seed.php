<?php

use App\Models\BankAccount;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Str;

$projectRoot = dirname(__DIR__, 2);

require $projectRoot.'/vendor/autoload.php';

$app = require $projectRoot.'/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

$temporaryRoot = getenv('ENDORPHINE_E2E_ROOT');
$databasePath = config('database.connections.sqlite.database');
$expectedPrefix = rtrim((string) $temporaryRoot, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;

if (config('database.default') !== 'sqlite' || ! str_starts_with((string) $databasePath, $expectedPrefix)) {
    throw new RuntimeException('Refusing to seed a database outside the isolated E2E directory.');
}

$customer = User::query()->where('email', 'pelanggan@gmail.com')->firstOrFail();
$cashier = User::query()->where('email', 'kasir@endorphine.com')->firstOrFail();
$products = Product::query()->get();

foreach ($products as $product) {
    $product->update([
        'stock' => 20,
        'status' => 'Ready',
    ]);
}

$product = Product::query()->firstOrFail();

BankAccount::create([
    'bank_name' => 'BCA',
    'account_number' => '1234567890',
    'account_holder' => 'Endorphine Florist',
    'is_active' => true,
]);

foreach ([
    [
        'user' => $customer,
        'order_number' => 'E2E-PENDING-'.Str::upper(Str::random(8)),
        'status' => 'pending',
        'payment_status' => 'Menunggu Verifikasi',
    ],
    [
        'user' => $customer,
        'order_number' => 'E2E-REVIEW-'.Str::upper(Str::random(8)),
        'status' => 'completed',
        'payment_status' => 'paid',
    ],
] as $orderData) {
    $order = Order::create([
        'order_number' => $orderData['order_number'],
        'user_id' => $orderData['user']->id,
        'customer_name' => $orderData['user']->name,
        'total_price' => $product->price,
        'payment_method' => 'QRIS',
        'payment_status' => $orderData['payment_status'],
        'status' => $orderData['status'],
        'shipping_address' => 'Alamat untuk pengujian.',
        'recipient_phone' => '081234567890',
    ]);

    $order->items()->create([
        'product_id' => $product->id,
        'quantity' => 1,
        'price' => $product->price,
    ]);
}

if (! $cashier->is_active) {
    throw new RuntimeException('The E2E cashier test account must be active.');
}
