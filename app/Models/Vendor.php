<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $table = 'vendor';
    protected $primaryKey = 'idvendor';

    protected $fillable = [
        'nama_vendor'
    ];

    // Relasi ke menu
    public function menu()
    {
        return $this->hasMany(Menu::class, 'idvendor', 'idvendor');
    }
}