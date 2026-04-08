<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
{
    protected $table = 'reg_villages';
    protected $fillable = [
        'name',
        'district_id'
    ];
    
    public function kecamatan() {
        return $this->belongsTo(Kecamatan::class, 'district_id');
    }
}
