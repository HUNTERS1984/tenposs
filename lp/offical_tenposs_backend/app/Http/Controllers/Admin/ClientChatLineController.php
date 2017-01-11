<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Requests;
use File;
use Session;
use Log;
use App;
use App\Models\Message;
use App\Models\LineAccount;
use App\Models\AppBots;
use App\Models\AppUser;
use App\Models\App as AppClient;

use DB;
use Auth;
use Config;
use LRedis;


class ClientChatLineController extends Controller
{
    //

    protected $curl;

    const API_REQUEST_PROFILE = 'https://api.line.me/v1/profile';
    const API_BOT_PROFILE = 'https://api.line.me/v2/bot/profile/';

    public function __construct(){
    	$this->curl = new \anlutro\cURL\cURL;
    }


    /*
    * Route: /admin/chat
    * 
    */
    public function chatAdmin(Request $request){
    
        $botService = AppBots::where('app_id', $request->app->id )->first();

    	if( !$botService ){
    	    return view('admin.pages.chat.clients')->withErrors('BOT LINE情報を設定してください' );
    	}
       

        // Get profile
        $requestProfile = $this->curl->newRequest('get', self::API_REQUEST_PROFILE )
            ->setHeader('Authorization',  'Bearer '. $botService->chanel_access_token  );
             
        $responseProfile = $requestProfile->send();
        $profile = json_decode($responseProfile->body);

        if( !$profile ){
            return view('admin.pages.chat.clients')->withErrors('再試行する, このページを再読み込みしてください!' );
        }

         // Update profiles
        $botService->displayName = $profile->displayName;
        $botService->mid = $profile->mid;
        $botService->pictureUrl = $profile->pictureUrl;
        $botService->statusMessage = $profile->statusMessage;
        $botService->save();

    
        $sql = "SELECT l.mid,l.displayName,l.pictureUrl,l.statusMessage, h.message, h.room_id
                FROM line_accounts as l
                INNER JOIN
                (
                    SELECT t1.* FROM messages t1 
                    WHERE not exists (
                        SELECT 1 FROM messages t2 WHERE t1.from_mid = t2.from_mid AND t1.id < t2.id
                    )
                  
                ) as h ON h.from_mid = l.mid

                WHERE h.room_id = ".$botService->chanel_id;

        $contacts = DB::select(DB::raw($sql));
     
        return view('admin.pages.chat.clients',[
            'contacts' => json_encode($contacts),
            'channel' =>  $botService->chanel_id,
            'profile' => json_encode( $profile )]);
    }
    
    public function searchContact(Request $request){
    
        if( $request->ajax() ){
            $sql = "SELECT l.mid,l.displayName,l.pictureUrl,l.statusMessage, h.message, h.room_id
                FROM line_accounts as l
                INNER JOIN
                (
                    SELECT t1.* FROM messages t1 
                    WHERE not exists (
                        SELECT 1 FROM messages t2 WHERE t1.from_mid = t2.from_mid AND t1.id < t2.id
                    )
                  
                ) as h ON h.from_mid = l.mid 
                WHERE l.displayName LIKE %".$request->input('s')."%
                WHERE h.room_id = ".$request->input('chanel')." ORDER BY l.displayName";

            $contacts = DB::select(DB::raw($sql));    
            return response()->json($contacts);
        }
        
    }
}
