<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('bank_accounts', 'qris_image')) {
            Schema::table('bank_accounts', function (Blueprint $table) {
                $table->string('qris_image')->nullable()->after('account_holder');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('bank_accounts', 'qris_image')) {
            Schema::table('bank_accounts', function (Blueprint $table) {
                $table->dropColumn('qris_image');
            });
        }
    }
};
