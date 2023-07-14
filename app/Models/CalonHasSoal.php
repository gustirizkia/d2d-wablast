<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalonHasSoal extends Model
{
    use HasFactory;

    public function soal(){
        return $this->belongsTo(Soal::class);
    }
}
