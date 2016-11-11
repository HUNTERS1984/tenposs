<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Requests;
use File;
use Session;
use Log;
use App;
use App\Models\Message;
use App\Models\LineAccount;
use App\Models\Users;
use App\Models\AppUser;
use App\Models\UserBots;
use App\Models\App as AppClient;

use DB;
use Auth;
use Config;
use LRedis;

class ChatLineController extends Controller
{
    //
    protected $curl;
    
    public function __construct(){
    	$this->curl = new \anlutro\cURL\cURL;
    }

    /*
    * Route: /
    * Handle BOT Server callback
    */
    public function index(Request $request, $chanel_id){
        
        $data = json_encode( $request->all() ) ;
        $data = json_decode($data);
        if( !$data ){
            return 'Success';
        }
        $data = $data->events[0];
      
        
        $botInfo = UserBots::where('chanel_id',$chanel_id )->first();
        if( $botInfo ){
            $arrPackage = array(
                'channel' => $botInfo,
                'data' => $data
            ); 
            Log::info(print_r($data, true));
            $redis = LRedis::connection();
            $redis->publish('message', json_encode($arrPackage));
            break;
        }
        
       
    }

    
}
