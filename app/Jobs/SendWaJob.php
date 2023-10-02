<?php

namespace App\Jobs;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class SendWaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $message_id, $target_id;
    /**
     * Create a new job instance.
     */
    public function __construct($message_id, $target_id)
    {
        $this->target_id = $target_id;
        $this->message_id = $message_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $target = DB::table('data_targets')->find($this->target_id);
        $message = DB::table("message_was")->find($this->message_id);

        if($target && $message){

        }
    }
}
