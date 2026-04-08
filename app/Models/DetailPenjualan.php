<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Barang;
use App\Models\Penjualan;

class DetailPenjualan extends Model
{
    protected $table = 'detail_penjualan';

    protected $primaryKey = 'iddetail_penjualan';

    public $timestamps = false;

    protected $fillable = [
        'id_penjualan',
        'idbarang',
        'jumlah',
        'subtotal'
    ];

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'id_penjualan');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'idbarang');
    }
}
