<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PilihanGanda extends Model
{
    use HasFactory;



    public function pilihanTarget(){
        return $this->hasMany(PilihanTarget::class);
    }

    public function soal(){
        return $this->belongsTo(Soal::class);
    }



}
