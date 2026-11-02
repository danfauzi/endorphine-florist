<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hero_slides', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('slot')->unique();
            $table->string('image')->nullable();
            $table->string('eyebrow')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        DB::table('hero_slides')->insert([
            [
                'slot' => 1,
                'image' => 'products/slide 1.jpg',
                'eyebrow' => '✨ Handcrafted Bouquet with Love',
                'title' => 'Kirim Kebahagiaan Lewat Rangkaian Buket Estetik',
                'description' => 'Pilihan buket bunga murni, snack favorit, hingga buket uang eksklusif yang dirangkai khusus untuk momen terindah orang tersayangmu.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slot' => 2,
                'image' => 'products/slide 2.jpg',
                'eyebrow' => '💐 Bunga Segar Setiap Hari',
                'title' => 'Koleksi Buket Mawar Soft & Premium',
                'description' => 'Dipetik segar langsung dari kebun dan dirangkai oleh florist profesional untuk kesan yang tak terlupakan.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slot' => 3,
                'image' => 'products/slide 3.jpg',
                'eyebrow' => '🎉 Special Gift & Graduation',
                'title' => 'Buket Snack & Uang untuk Momen Wisuda',
                'description' => 'Custom jumlah lembaran uang dan jajanan favorit dengan gratis kartu ucapan unik.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slot' => 4,
                'image' => 'products/slide 1.jpg',
                'eyebrow' => '🎁 Hadiah untuk Momen Spesial',
                'title' => 'Kado Manis untuk Orang Tersayang',
                'description' => 'Pilih hadiah yang dirangkai dengan penuh perhatian untuk setiap perayaan.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slot' => 5,
                'image' => 'products/slide 2.jpg',
                'eyebrow' => '🎓 Rayakan Pencapaianmu',
                'title' => 'Buket Wisuda yang Berkesan',
                'description' => 'Rayakan hari kelulusan dengan rangkaian buket yang dibuat khusus untuk momen bangga.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('hero_slides');
    }
};
