<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model 
{
    protected $table = 'penjualan';

    protected $primaryKey = 'id_penjualan';

    public $timestamps = false; // karena hanya ada created_at manual

    protected $fillable = [
        'total',
        'created_at'
    ];

    public function detail()
    {
        return $this->hasMany(DetailPenjualan::class, 'id_penjualan');
    }
}
