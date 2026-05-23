<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Toko extends Model
{
    protected $table = 'toko';

    protected $primaryKey = 'idtoko';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'nama_toko',
        'latitude',
        'longitude',
        'accuracy'
    ];

    public function kunjungan()
    {
        return $this->hasMany(
            Kunjungan::class,
            'idtoko',
            'idtoko'
        );
    }
}