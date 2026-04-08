<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    protected $table = 'reg_provinces';
    protected $fillable = ['name'];

    public function kota(){
        return $this->hasMany(Kota::class, 'province_id');
    }
}
