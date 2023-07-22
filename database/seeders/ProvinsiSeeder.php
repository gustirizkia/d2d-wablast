<?php

namespace Database\Seeders;

use App\Models\Provinsi;
use GuzzleHttp\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProvinsiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $client = new Client();
        $get = $client->get("https://dev.farizdotid.com/api/daerahindonesia/provinsi");
        $res = json_decode($get->getBody());

        foreach($res->provinsi as $item){
            $insert = Provinsi::create([
                'nama' => $item->nama,
                'id_provinsi' => $item->id
            ]);
        }

    }
}
