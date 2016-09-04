<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Predis\Connection\ConnectionException;
use Symfony\Component\Debug\Exception\FatalErrorException;
use Zend\Http\Client\Adapter\Exception\TimeoutException;

class NotificationMobile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'noti:mobile';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notification to mobile';

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
        $this->info("send successfully!");
        $isloop = true;
        while ($isloop) {
            try {
                $isloop = false;
                $this->info("send start!");
                Redis::subscribe(['channel'], function ($message) {
                    Log::info("thís is " . $message . " log " . Carbon::now());
                    $this->info("thís is " . $message . " log " . Carbon::now());
                });
                $this->info("send end!");
            } catch (\RedisException $e) {
                $this->info("send end!" . $e->getMessage());
                $isloop = true;
                Log::info("Redis subscribe " . Carbon::now()) . ' - ' . $e->getMessage();
            } catch (ConnectionException $ex) {
                $this->info("send timeout end!" . $ex->getMessage());
                $isloop = true;
                Log::info("Redis subscribe " . Carbon::now()) . ' - ' . $ex->getMessage();
            }
        }
    }
}
