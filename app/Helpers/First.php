<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

function saveError($method, $message){
    DB::table("error_data")->insertGetId([
        'method' => $method,
        'message' => $message,
        'created_at' => now(),
        'updated_at' => now()
    ]);
}

function generateUuid($table, $val = 15){
    $uuid = Str::random($val);
    $cek = DB::table($table)->where('uuid', $uuid)->first();

    if($cek){
        generateUuid($table, $val+1);
    }else{
       return $uuid;
    }

}
