<?php
namespace App\Console\Commands;

use App\Utils\ProcessNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Predis\Connection\ConnectionException;


class NotificationMobile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:center';

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
        $isloop = true;
        while ($isloop) {
            try {
                $isloop = false;
                $this->info("Start subscribe");
                Redis::subscribe([Config::get('api.redis_chanel_notification')], function ($message) {
                    try {
                        $this->info('receive message:' . $message);
                        ProcessNotification::getInstance()->process($message);
                        $this->info("this is " . $message . " log " . Carbon::now());
                    } catch (\RuntimeException $e) {
                        Log::error($e->getMessage());
                    }
                });
            } catch
            (ConnectionException $ex) {
                $isloop = true;
                Log::error($ex);
//                Log::info("Redis subscribe " . Carbon::now()) . ' - ' . $ex->getMessage();
            } catch (\RedisException $e) {
                $isloop = true;
                Log::error($e);
//                Log::info("Redis subscribe " . Carbon::now()) . ' - ' . $e->getMessage();
            } catch (\HttpException $e) {
                $isloop = true;
                Log::error($e);
            } catch (\ErrorException $e) {
                $isloop = true;
                Log::error($e);
//                Log::info("Redis subscribe " . Carbon::now()) . ' - ' . $e->getMessage();
            }

        }
    }
}