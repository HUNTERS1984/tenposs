<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\InstagramHashtagJob;
use DB;
use Larabros\Elogram\Client;
use Exception;

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
        echo 'START FETCHING IMAGE '.date('Y-m-d H:i:s').PHP_EOL;
        app('Illuminate\Bus\Dispatcher')->dispatch(new InstagramHashtagJob(222));
        echo 'END FETCHING IMAGE '.date('Y-m-d H:i:s').PHP_EOL;
    }
}
