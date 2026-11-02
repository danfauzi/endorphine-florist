<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    // Tambahkan properti $fillable ini
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'note',
    ];

    // Relasi ke Model Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relasi ke Model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
