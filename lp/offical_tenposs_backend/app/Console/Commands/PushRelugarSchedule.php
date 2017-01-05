<?php

namespace App\Console\Commands;

use App\Models\Push;
use App\Models\PushRegularCurrent;
use App\Utils\HttpRequestUtil;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Log;
use League\Flysystem\Config;
use Symfony\Component\HttpFoundation\Session\Session;

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
        $new_date = $date->format('Y-m-d h:i:s a');
        $arr_date = explode(' ', $new_date);
        if (count($arr_date) > 0) {
            $arr_day = explode('-', $arr_date[0]);
            $arr_hour = explode(':', $arr_date[1]);
            print_r($arr_day);
            print_r($arr_hour);
            if (count($arr_day) > 0 && count($arr_hour) > 0) {
                $data_push = PushRegularCurrent::where('time_detail_day', $arr_day[2])
                    ->where('time_detail_hours', $arr_hour[0])
                    ->where('time_detail_minutes', $arr_hour[1])
                    ->get();

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
            
            //cal api push
            HttpRequestUtil::getInstance()->post_data_with_token(
                \Illuminate\Support\Facades\Config::get('api.url_api_notification'),
                array('notification_to' => $data->auth_user_id,
                    'title' => $data->title,
                    'message' => $data->message,
                    'all_user' => $data_push->segment_all_user,
                    'client_users' => $data_push->segment_client_users,
                    'end_users' => $data_push->segment_end_users,
                    'type' => 'custom',
                    'app_id' => 0),
                \Illuminate\Support\Facades\Session::get('jwt_token')->token
            );
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
