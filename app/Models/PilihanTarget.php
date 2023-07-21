<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PilihanTarget extends Model
{
    use HasFactory;

    public function dataTarget(){
        return $this->belongsTo(DataTarget::class);
    }

    public function pilihan(){
        return $this->belongsTo(PilihanGanda::class, 'pilihan_ganda_id', 'id');
    }

    public function soal(){
        return $this->belongsTo(Soal::class, 'soal_id', 'id');
    }
}
