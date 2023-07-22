<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataTarget extends Model
{
    use HasFactory;

    public function pilihanTarget(){
        return $this->hasMany(PilihanTarget::class);
    }

    public function rel_provinsi(){
        return $this->belongsTo(Provinsi::class, "provinsi_id", "id_provinsi");
    }

    public function rel_kota(){
        return $this->belongsTo(Kota::class, 'kota_id', 'id_kota');
    }
    public function rel_kecamatan(){
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id', 'id_kecamatan');
    }
    public function rel_desa(){
        return $this->belongsTo(Desa::class, 'desa_id', 'id');
    }
}
