<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class StatistikSoal extends Model
{
    use HasFactory;

    protected $table = "soals";

    protected $appends = ['pilihan'];

    // public function scopeTouched($query)
    // {
    //     dd($this->pilihan);
    // }

    public function getPilihanAttribute(){
        // $data = DB::table("pilihan_gandas")
        //         ->leftJoin("pilihan_targets", "pilihan_gandas.id", "pilihan_targets.pilihan_ganda_id")
        //         ->where('pilihan_gandas.soal_id', $this->id)
        //         ->get();
        $data = PilihanGanda::where('pilihan_gandas.soal_id', $this->id)->withCount("pilihanTarget")->get();

        return $data;
    }


}
