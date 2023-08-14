<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kota extends Model
{
    use HasFactory;

    protected $guard = [];

    public function kecamatan()
    {
        return $this->hasMany(Kecamatan::class, 'kota_id', 'id_kota');
    }

    public function provinsi(){
        return $this->belongsTo(Provinsi::class, 'provinsi_id', 'id_provinsi');
    }
}
