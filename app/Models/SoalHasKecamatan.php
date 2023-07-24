<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoalHasKecamatan extends Model
{
    use HasFactory;

    public function soal(){
        return $this->belongsTo(Soal::class, 'soal_id', 'id');
    }

    public function kecamatan(){
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id', 'id_kecamatan');
    }
}
