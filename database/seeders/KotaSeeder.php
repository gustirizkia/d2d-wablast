<?php

namespace Database\Seeders;

use App\Models\Kota;
use App\Models\Provinsi;
use GuzzleHttp\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $provinsi = Provinsi::whereIn('id', [16, 11])->get();
        foreach($provinsi as $item){
            $client = new Client();
            $response = $client->get("https://dev.farizdotid.com/api/daerahindonesia/kota?id_provinsi=$item->id_provinsi");
            $res = json_decode($response->getBody());

            $res = $res->kota_kabupaten;

            foreach($res as $kota){
                Kota::create([
                    'nama' => $kota->nama,
                    'id_kota' => $kota->id,
                    'provinsi_id' => $kota->id_provinsi,
                ]);
            }
        }
    }
}
