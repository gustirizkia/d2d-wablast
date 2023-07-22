<?php

namespace Database\Seeders;

use App\Models\Kecamatan;
use App\Models\Kota;
use GuzzleHttp\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KecamatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kota = Kota::get();

        foreach($kota as $item){
            $client = new Client();
            $response = $client->get("https://dev.farizdotid.com/api/daerahindonesia/kecamatan?id_kota=$item->id_kota");
            $res = json_decode($response->getBody());

            $res = $res->kecamatan;

            foreach($res as $kecamatan){
                Kecamatan::create([
                    'nama' => $kecamatan->nama,
                    'kota_id' => $kecamatan->id_kota,
                    'id_kecamatan' => $kecamatan->id
                ]);
            }
        }
    }
}
