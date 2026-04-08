<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kota extends Model
{
    protected $table = 'reg_regencies';

    protected $fillable = [
        'name',
        'province_id'
    ];

    public function provinsi() {
        return $this->belongsTo(Provinsi::class, 'province_id');
    }
    public function kecamatan() {
        return $this->hasMany(Kecamatan::class, 'regency_id');
    }

}
