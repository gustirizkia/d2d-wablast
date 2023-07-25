<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relawan extends Model
{
    use HasFactory;

    protected $appends = ['age'];

    public function getAgeAttribute(){
        return Carbon::parse($this->tanggal_lahir)->age;
    }

    public function calon(){
        return $this->belongsTo(CalonLegislatif::class, 'username_calon', 'username');
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
