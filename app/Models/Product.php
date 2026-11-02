<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Menentukan kolom mana saja yang boleh diisi secara mass-assignment
    protected $fillable = [
        'name',
        'category',
        'price',
        'stock',
        'status',
        'description',
        'image',
    ];

    // Relasi ke orderItems tetap dipertahankan
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}