<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Soal extends Model
{
    use HasFactory;

    protected $appends = ['soal_kecamatan'];

    // public static function general()

    public function getSoalKecamatanAttribute(){
        $cek = DB::table('soal_has_kecamatans')->where("soal_id", $this->id)->first();
        if($cek){
            return $cek;
        }else{
            return false;
        }
    }

    public function pilihan(){
        return $this->hasMany(PilihanGanda::class);
    }

    public function statistikPilihan(){
        return $this->hasMany(StatistikPilihan::class);
    }

    public function hasKecamatan(){
        return $this->hasMany(SoalHasKecamatan::class, 'soal_id', 'id');
    }
}
