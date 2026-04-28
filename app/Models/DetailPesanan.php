<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    protected $table = 'detail_pesanan';
    protected $primaryKey = 'iddetail';

    protected $fillable = [
        'idpesanan',
        'idmenu',
        'jumlah',
        'harga',
        'subtotal',
        'catatan',
        'created_at',
        'updated_at'
    ];

    // Relasi ke pesanan
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'idpesanan', 'idpesanan');
    }

    // Relasi ke menu
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'idmenu', 'idmenu');
    }
}