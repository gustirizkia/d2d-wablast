<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserHasKota extends Model
{
    use HasFactory;

    public function kota(){
        return $this->belongsTo(Kota::class, 'kota_id', 'id_kota');
    }
}
