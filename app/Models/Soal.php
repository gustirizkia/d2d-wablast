<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Soal extends Model
{
    use HasFactory;

    protected $appends = ['soal_kecamatan', 'check_pilihan_target'];
    public $idTarget = null;

    public function getSoalKecamatanAttribute(){
        $cek = DB::table('soal_has_kecamatans')->where("soal_id", $this->id)->first();
        if($cek){
            return $cek;
        }else{
            return false;
        }
    }

    public function skipSoal(){
       return $this->belongsTo(Soal::class, 'id', 'skip_soal_id');
    }
    public function skipSoalMany(){
       return $this->hasMany(Soal::class, 'skip_soal_id', 'id');
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

    public function getCheckPilihanTargetAttribute(){
        if($this->idTarget){
            $data = DB::table("pilihan_targets")->where("data_target_id", $this->idTarget)->where('soal_id', $this->id)->first();
            if($data){
                return $data;
            }
        }
        return 0;
    }


}
