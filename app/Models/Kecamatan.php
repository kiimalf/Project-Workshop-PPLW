<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    protected $table = 'reg_districts';
    protected $fillable = [
        'name',
        'regency_id'
    ];

    public function kota() {
        return $this->belongsTo(Kota::class, 'regency_id');
    }
    public function kelurahan() {
        return $this->hasMany(Kelurahan::class, 'district_id');
    }
}
