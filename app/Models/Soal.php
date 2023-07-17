<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    use HasFactory;

    public function pilihan(){
        return $this->hasMany(PilihanGanda::class);
    }

    public function statistikPilihan(){
        return $this->hasMany(StatistikPilihan::class);
    }
}
