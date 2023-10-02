<?php

namespace App\Imports\DPT;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CianjurImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach($collection as $index => $row){
            try {
                $insertData = DB::table("data_dpts")->insertGetId([
                    "nama" => $row['nama'],
                    "jenis_kelamin" => $row['jenis_kelamin'],
                    "usia" => $row['usia'],
                    "desa" => $row['desakelurahan'],
                    "rt" => $row['rt'],
                    "rw" => $row['rw'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } catch (Exception $th) {

                $insertErrorImp = DB::table("error_imp_dpts")->insertGetId([
                    "row_index" => "index: $index, row: ". $row['no'],
                    "row_data" => json_encode($row->toArray()),
                    'error_message' => $th->getMessage(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
