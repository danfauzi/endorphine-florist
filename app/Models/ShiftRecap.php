<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShiftRecap extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'modal_awal',
        'total_tunai',
        'total_qris',
        'total_kas_fisik',
        'physical_cash',
        'selisih',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}