<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    use HasFactory;

    protected $guard = [];

    public function kota(){
        return $this->belongsTo(Kota::class, "kota_id", "id_kota");
    }
}
