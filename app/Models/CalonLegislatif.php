<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalonLegislatif extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'dapil', 'username', 'provinsi_id', 'kota_id', 'kecamatan_id'];

    public function hasSoal()
    {
        return $this->hasMany(CalonHasSoal::class);
    }
}
