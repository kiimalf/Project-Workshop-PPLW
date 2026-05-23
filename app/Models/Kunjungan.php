<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{
    protected $table = 'kunjungan';

    protected $primaryKey = 'idkunjungan';

    public $timestamps = false;

    protected $fillable = [
        'idtoko',
        'latitude',
        'longitude',
        'accuracy',
        'jarak',
        'status'
    ];
    
    public function toko()
    {
        return $this->belongsTo(
            Toko::class,
            'idtoko',
            'idtoko'
        );
    }
}