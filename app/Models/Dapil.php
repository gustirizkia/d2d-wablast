<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dapil extends Model
{
    use HasFactory;

    public function caleg(){
        return $this->hasMany(Caleg::class, 'dapil_uuid', 'uuid');
    }

    public function saksi(){
        return $this->hasMany(Saksi::class, 'dapil_id', 'id');
    }
}
