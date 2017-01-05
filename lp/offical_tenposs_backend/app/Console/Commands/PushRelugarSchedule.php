<?php

namespace App\Console\Commands;

use App\Models\Push;
use App\Models\PushRegularCurrent;
use App\Utils\HttpRequestUtil;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Session\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Predis\PredisException;
use App\Utils\RedisUtil;

class PushRelugarSchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'push:regular';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Data push regular';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //get date
        $current_date = date('Y-m-d H:i:s');
        $format = 'Y-m-d H:i:s';
        $date = \DateTime::createFromFormat($format, $current_date);
        $new_date = $date->format('Y-m-d h:i:s');
        $arr_date = explode(' ', $new_date);
        if (count($arr_date) > 0) {
            $arr_day = explode('-', $arr_date[0]);
            $arr_hour = explode(':', $arr_date[1]);
            //print_r($arr_day);
            //print_r($arr_hour);
            if (count($arr_hour) > 0) {
                $data_push = PushRegularCurrent::where('time_type', '=',  3)
                ->where('time_detail_year', '=',  $arr_day[0])
                ->where('time_detail_month', '=',  $arr_day[1])
                ->where('time_detail_day', '=',  $arr_day[2])
                ->where(function ($query) use ($arr_hour){
                    return $query->where('time_detail_hours', '<=',  $arr_hour[0])
                            ->orWhere(function ($query) use ($arr_hour){
                                return $query->where('time_detail_hours', '=',  $arr_hour[0])->where('time_detail_minutes', '<=', $arr_hour[1]);
                            });
                })->get();

                if (count($data_push) > 0) {
                    for ($i = 0; $i < count($data_push); $i++) {
                        $this->callAPIPush($data_push[$i]);
                    }
                }

                $data_push = PushRegularCurrent::where('time_type', '=',  2)
                ->where(function ($query) use ($arr_hour){
                    return $query->where('time_detail_hours', '<=',  $arr_hour[0])
                            ->orWhere(function ($query) use ($arr_hour){
                                return $query->where('time_detail_hours', '=',  $arr_hour[0])->where('time_detail_minutes', '<=', $arr_hour[1]);
                            });
                })->get();


                if (count($data_push) > 0) {
                    for ($i = 0; $i < count($data_push); $i++) {
                        $this->callAPIPush($data_push[$i]);
                    }
                }

  
            }
        }
    }

    private function callAPIPush($data)
    {
        if ($data->time_count_delivered < $data->time_count_repeat) {

            $data_push = Push::find($data->push_id);
            if (!$data_push)
                return;

            try {
                Redis::publish('notification_center', json_encode(array('notification_to' => $data->auth_user_id,
                    'title' => $data->title,
                    'message' => $data->message,
                    'all_user' => $data_push->segment_all_user,
                    'client_users' => $data_push->segment_client_users,
                    'end_users' => $data_push->segment_end_users,
                    'type' => 'custom',
                    'user_type' => 'user',
                    'app_id' => $data_push->app_app_id)));
            } catch (PredisException $e) {
                Log::error($e->getMessage());
                dd($e);
                return $this->error(9999);
            }

            //update
            try {
                $data->time_count_delivered = $data->time_count_delivered + 1;
                $data->save();
                
                if (count($data_push) > 0) {
                    $data_push->time_count_delivered = $data->time_count_delivered;
                    if ($data->time_count_delivered == $data->time_count_repeat)
                        $data_push->status = 1;
                    $data_push->save();
                }
            } catch (QueryException $e) {
                Log::error($e->getMessage());
            }
        }

    }
}
