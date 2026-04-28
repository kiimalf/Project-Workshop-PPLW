<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanan';
    protected $primaryKey = 'idpesanan';

    protected $fillable = [
        'idcustomer',
        'total',
        'status',
        'created_at',
        'updated_at',
        'order_id',
        'snap_token'
    ];

    // Relasi ke customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'idcustomer', 'idcustomer');
    }

    // Relasi ke detail pesanan
    public function detail()
    {
        return $this->hasMany(DetailPesanan::class, 'idpesanan', 'idpesanan');
    }

    // Relasi ke payment
    public function payment()
    {
        return $this->hasOne(Payment::class, 'idpesanan', 'idpesanan');
    }
}