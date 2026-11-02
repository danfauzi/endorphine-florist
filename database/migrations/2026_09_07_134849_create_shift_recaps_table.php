<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shift_recaps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // ID Kasir yang bertugas
            $table->date('date');                  // Tanggal rekap
            $table->decimal('modal_awal', 12, 2);
            $table->decimal('total_tunai', 12, 2);
            $table->decimal('total_qris', 12, 2);
            $table->decimal('total_kas_fisik', 12, 2);
            $table->decimal('physical_cash', 12, 2); // Hitungan fisik uang di laci
            $table->decimal('selisih', 12, 2)->default(0); // Selisih (fisik - sistem)
            $table->text('notes')->nullable();     // Catatan kasir
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shift_recaps');
    }
};
