<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\InstagramHashtagJob;
use DB;
use Larabros\Elogram\Client;
use Exception;
use App\Models\Coupon;

class SNSMediaCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetching:mediadata';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get SNS media information.';

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
        // */15 * * * * php /var/www/html/tenposs/lp/offical_tenposs_backend/artisan fetching:mediadata
        echo 'START FETCHING IMAGE '.date('Y-m-d H:i:s').PHP_EOL;
        $now = date('Y-m-d');
        $coupons = Coupon::where('end_date', '>=', $now)->where('start_date', '<=', $now)->whereNull('deleted_at')->orderBy('updated_at', 'desc')->get();
        //dd($coupons);
        foreach ($coupons as $coupon) {
            echo 'Fetching coupon:'. $coupon->id;
            app('Illuminate\Bus\Dispatcher')->dispatch(new InstagramHashtagJob($coupon->id));
        }
        
        echo 'END FETCHING IMAGE '.date('Y-m-d H:i:s').PHP_EOL;
    }
}
