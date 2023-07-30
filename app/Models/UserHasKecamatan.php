<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserHasKecamatan extends Model
{
    use HasFactory;

    public function kecamatan(){
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id', 'id_kecamatan');
    }
}
