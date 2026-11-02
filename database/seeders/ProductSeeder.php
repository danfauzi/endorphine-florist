<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Buket Mawar Soft Pink',
                'category' => 'Bunga',
                'price' => 150000,
                'status' => 'Ready',
                'description' => 'Rangkaian mawar murni warna soft pink cantik dengan pembungkus premium.',
                'image' => 'https://images.unsplash.com/photo-1561181286-d3fee7d55364?q=80&w=600&auto=format&fit=crop',
            ],
            [
                'name' => 'Buket Snack Chocolate Deluxe',
                'category' => 'Snack',
                'price' => 85000,
                'status' => 'Ready',
                'description' => 'Kombinasi cokelat pilihan dan jajanan favorit untuk kado wisuda/ulang tahun.',
                'image' => 'https://images.unsplash.com/photo-1582293041079-7814c2f12063?q=80&w=600&auto=format&fit=crop',
            ],
            [
                'name' => 'Buket Uang Pecahan 50rb',
                'category' => 'Uang',
                'price' => 250000,
                'status' => 'Pre-Order',
                'description' => 'Buket uang elegan isi 10 lembar pecahan Rp 50.000 lengkap dengan hiasan bunga.',
                'image' => 'https://images.unsplash.com/photo-1526047932273-341f2a7631f9?q=80&w=600&auto=format&fit=crop',
            ],
            [
                'name' => 'Buket Tulip Gradasi Lavender',
                'category' => 'Bunga',
                'price' => 175000,
                'status' => 'Ready',
                'description' => 'Bunga tulip buatan kualitas tinggi dengan warna ungu lavender yang elegan.',
                'image' => 'https://images.unsplash.com/photo-1525310072745-f49212b5ac6d?q=80&w=600&auto=format&fit=crop',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}