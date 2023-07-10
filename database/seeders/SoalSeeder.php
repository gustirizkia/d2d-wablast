<?php

namespace Database\Seeders;

use App\Models\PilihanGanda;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SoalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        for ($i=0; $i < 300; $i++) {
            $soal = DB::table("soals")->insertGetId([
                'title' => $faker->sentence($nbWords = 6, $variableNbWords = true)." ?",
                'subtitle' => $faker->sentence($nbWords = 12, $variableNbWords = true),
                'color' => str_pad(dechex(rand(0x000000, 0xFFFFFF)), 6, 0, STR_PAD_LEFT),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            for ($j=0; $j < 4; $j++) {
                DB::table('pilihan_gandas')->insertGetId([
                    'title' => $faker->sentence($nbWords = 6, $variableNbWords = true),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'soal_id' => $soal
                ]);
            }
        }

        $soals = DB::table('soals')->get();

        $lang = -6.326069;
        $long = 106.708912;
        for ($i=0; $i < 200; $i++) {
           $user = User::create([
                'name' => $faker->name(),
                'email' => $faker->email(),
                'phone' => $faker->phoneNumber(),
                'password' => Hash::make('password_1')
            ]);

           $dataTarget = DB::table('data_targets')->insertGetId([
                'user_survey_id' => $user->id,
                'nama' => $faker->name(),
                'alamat' => $faker->address(),
                'latitude' => $faker->latitude( $min = ($lang * 10000 - rand(0, 50)) / 10000,
    $max = ($lang * 10000 + rand(0, 50)) / 10000),
                'longitude' => $faker->longitude( $min = ($long * 10000 - rand(0, 50)) / 10000,
    $max = ($long * 10000 + rand(0, 50)) / 10000),
                'created_at' => Carbon::now()->addDay($faker->randomDigitNot(5)),
                'updated_at' => Carbon::now()->addDay($faker->randomDigitNot(5)),
           ]);

           foreach ($soals as $key => $value) {
                $pilihanTarget  = PilihanGanda::where("soal_id", $value->id)->inRandomOrder()->first();
                DB::table("pilihan_targets")->insertGetId([
                    'data_target_id' => $dataTarget,
                    'soal_id' => $value->id,
                    'pilihan_ganda_id' => $pilihanTarget->id,
                    'created_at' => Carbon::now()->addDay($faker->randomDigitNot(5)),
                    'updated_at' => Carbon::now()->addDay($faker->randomDigitNot(5)),
                ]);
           }

        }
    }
}
