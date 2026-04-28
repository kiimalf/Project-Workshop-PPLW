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
        'created_at',
        'updated_at'
    ];

    // Relasi ke pesanan
    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'idcustomer', 'idcustomer');
    }
}
