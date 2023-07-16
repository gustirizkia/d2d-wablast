<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relawan extends Model
{
    use HasFactory;

    public function calon(){
        return $this->belongsTo(CalonLegislatif::class, 'username_calon', 'username');
    }
}
