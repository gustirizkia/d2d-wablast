<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CommandPilihanTarget extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'statistik:pilihan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $pilihan_targets = DB::table("pilihan_targets")
                            ->select("id", 'pilihan_ganda_id', 'soal_id', DB::raw("count(*) as total"))
                            ->groupBy('pilihan_ganda_id')
                            ->get();

        foreach($pilihan_targets as $item)
        {
            $cek = DB::table("statistik_pilihans")->where('soal_id', $item->soal_id)->where('pilihan_ganda_id', $item->pilihan_ganda_id)
                    ->first();

            if($cek){
                $update = DB::table("statistik_pilihans")->where('soal_id', $item->soal_id)
                            ->where('pilihan_ganda_id', $item->pilihan_ganda_id)
                            ->update([
                                'soal_id' => $item->soal_id,
                                'pilihan_ganda_id' => $item->pilihan_ganda_id,
                                'count' => $item->total,
                                'updated_at' => now(),
                            ]);

            }else{
                $insert = DB::table("statistik_pilihans")->insertGetId([
                    'soal_id' => $item->soal_id,
                    'pilihan_ganda_id' => $item->pilihan_ganda_id,
                    'count' => $item->total,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]);
            }
        }

        // \Log::info('------statistik:pilihan successfully----');
        $this->info('------statistik:pilihan successfully----');
    }
}
