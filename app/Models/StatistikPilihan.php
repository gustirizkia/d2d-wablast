<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatistikPilihan extends Model
{
    use HasFactory;

    public function pilihan(){
        return $this->belongsTo(PilihanGanda::class, 'pilihan_ganda_id', 'id');
    }
}
