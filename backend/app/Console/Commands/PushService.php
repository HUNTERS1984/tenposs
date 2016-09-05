<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use Predis\Connection\ConnectionException;

class PushService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'service:push';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Push Service';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        echo 'START PUSH SERVICE '.date('Y-m-d H:i:s').PHP_EOL;
        try {
            Redis::subscribe(['channel'], function($message) {

                echo $message;
                sleep(3);
            });
        }  catch (\Predis\Connection\ConnectionException $e) {
            echo 'END PUSH SERVICE '.date('Y-m-d H:i:s').PHP_EOL;
            dd($e);

        }
       
        echo 'END PUSH SERVICE '.date('Y-m-d H:i:s').PHP_EOL;
    }
}
