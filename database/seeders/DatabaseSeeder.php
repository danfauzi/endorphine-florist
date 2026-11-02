<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Material;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        $this->call([
            ProductSeeder::class,
        ]);

        // 1. Akun Pengguna Sesuai Hak Akses (Role)
        User::create([
            'name' => 'Admin Endorphine',
            'email' => 'admin@endorphine.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '081234567890'
        ]);

        User::create([
            'name' => 'Kasir Store',
            'email' => 'kasir@endorphine.com',
            'password' => Hash::make('password'),
            'role' => 'kasir',
            'phone' => '081234567891'
        ]);

        User::create([
            'name' => 'Owner Endorphine',
            'email' => 'owner@endorphine.com',
            'password' => Hash::make('password'),
            'role' => 'owner',
            'phone' => '081234567892'
        ]);

        User::create([
            'name' => 'Pelanggan Demo',
            'email' => 'pelanggan@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'pelanggan',
            'phone' => '089876543210'
        ]);

        // 2. Data Sample Produk Buket
        Product::create([
            'name' => 'Buket Mawar Red Classic',
            'category' => 'bunga',
            'price' => 150000,
            'description' => 'Buket bunga mawar merah segar dengan pembungkus premium.'
        ]);

        Product::create([
            'name' => 'Buket Snack Choco Lovers',
            'category' => 'snack',
            'price' => 85000,
            'description' => 'Buket aneka cokelat manis cocok untuk hadiah ulang tahun.'
        ]);

        // 3. Data Sample Stok Bahan Buket
        Material::create([
            'name' => 'Kertas Cellophane Pink',
            'stock' => 50,
            'unit' => 'lembar'
        ]);

        Material::create([
            'name' => 'Pita Satin Red',
            'stock' => 20,
            'unit' => 'meter'
        ]);
    }
}