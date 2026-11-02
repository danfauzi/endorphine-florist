<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vouchers', function (Blueprint $table) {
            if (!Schema::hasColumn('vouchers', 'type')) {
                $table->enum('type', ['fixed', 'percent'])->default('fixed')->after('code');
            }
            if (!Schema::hasColumn('vouchers', 'discount_value')) {
                $table->decimal('discount_value', 12, 2)->default(0)->after('type');
            }
            if (!Schema::hasColumn('vouchers', 'min_order_price')) {
                $table->decimal('min_order_price', 12, 2)->default(0)->after('discount_value');
            }
            if (!Schema::hasColumn('vouchers', 'quota')) {
                $table->integer('quota')->default(0)->after('min_order_price');
            }
            if (!Schema::hasColumn('vouchers', 'expired_date')) {
                $table->date('expired_date')->nullable()->after('quota');
            }
            if (!Schema::hasColumn('vouchers', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('expired_date');
            }
        });
    }

    public function down(): void
    {
        Schema::table('vouchers', function (Blueprint $table) {
            $table->dropColumn(['type', 'discount_value', 'min_order_price', 'quota', 'expired_date', 'is_active']);
        });
    }
};