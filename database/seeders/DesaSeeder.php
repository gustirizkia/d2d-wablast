<?php

namespace Database\Seeders;

use App\Models\Desa;
use App\Models\Kecamatan;
use GuzzleHttp\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DesaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kecamatan = Kecamatan::get();

        foreach($kecamatan as $item){
            $client = new Client();
            $response = $client->get("https://dev.farizdotid.com/api/daerahindonesia/kelurahan?id_kecamatan=$item->id_kecamatan");
            $res = json_decode($response->getBody());

            $res = $res->kelurahan;

            foreach($res as $kelurahan){
                Desa::create([
                    'nama' => $kelurahan->nama,
                    'kecamatan_id' => $kelurahan->id_kecamatan
                ]);
            }
        }
    }
}
