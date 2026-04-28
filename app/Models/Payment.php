<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payment';
    protected $primaryKey = 'idpayment';

    protected $fillable = [
        'idpesanan',
        'metode_bayar',
        'transaction_id',
        'status',
        'created_at',
        'updated_at'
    ];

    // Relasi ke pesanan
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'idpesanan', 'idpesanan');
    }
}