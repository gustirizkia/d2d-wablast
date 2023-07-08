<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PilihanGanda extends Model
{
    use HasFactory;

    public function pilihanTarget(){
        return $this->hasMany(PilihanTarget::class);
    }
}
