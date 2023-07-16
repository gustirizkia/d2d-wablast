<?php

namespace Database\Seeders;

use App\Models\Relawan;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class RelawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $lang = -6.326069;
        $long = 106.708912;

        for ($i=0; $i < 200; $i++) {
            DB::table('relawans')->insertGetId([
                'latitude' => $faker->latitude( $min = ($lang * 510000 - rand(0, 50)) / 510000,
                    $max = ($lang * 510000 + rand(0, 50)) / 510000),
                'longitude' => $faker->longitude( $min = ($long * 510000 - rand(0, 50)) / 510000,
                    $max = ($long * 510000 + rand(0, 50)) / 510000),
                'created_at' => Carbon::now()->addDay($i > 0 ? $i*2 : 1),
                'updated_at' => Carbon::now()->addDay($i > 0 ? $i*2 : 1),
                'nama' => $faker->name(),
                'alamat' => $faker->address(),
                'username_calon' => DB::table('calon_legislatifs')->first()->username,
            ]);
        }
    }
}
