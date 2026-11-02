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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique(); // Contoh: ORD-20260903-001
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->bigInteger('total_price');
            $table->enum('status', ['pending', 'processing', 'completed', 'cancelled'])->default('pending');
            $table->text('shipping_address');
            $table->string('recipient_phone');
            $table->text('greeting_card')->nullable(); // Pesan untuk kartu ucapan buket
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
