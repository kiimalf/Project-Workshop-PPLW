<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\DetailPenjualan;

class Barang extends Model
{
    protected $table = 'barang';
    protected $primaryKey = 'idbarang';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'nama_barang',
        'harga',
        'stok',
        'created_at',
        'updated_at'
    ];

    public function detailPenjualan()
    {
        return $this->hasMany(DetailPenjualan::class, 'idbarang');
    }
}
