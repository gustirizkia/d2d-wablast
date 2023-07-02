<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataTarget extends Model
{
    use HasFactory;

    public function pilihanTarget(){
        return $this->hasMany(PilihanTarget::class);
    }
}
