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
}
