<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customer';
    protected $primaryKey = 'idcustomer';
    public $incrementing = false;
    protected $keyType = 'int';
    protected $fillable = [
        'nama',
        'id_provinsi',
        'id_kota',
        'id_kecamatan',
        'id_kelurahan',
        'alamat',
        'foto_blob',
        'foto_path',
        'created_at',
        'updated_at',
    ];

    // Relasi ke pesanan
    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'idcustomer', 'idcustomer');
    }

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'id_provinsi', 'id');
    }

    public function kota()
    {
        return $this->belongsTo(Kota::class, 'id_kota', 'id');
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'id_kecamatan', 'id');
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class, 'id_kelurahan', 'id');
    }
}
