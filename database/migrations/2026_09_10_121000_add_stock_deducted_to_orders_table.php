<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('orders', 'stock_deducted')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->boolean('stock_deducted')->default(false)->after('payment_proof');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('orders', 'stock_deducted')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('stock_deducted');
            });
        }
    }
};
