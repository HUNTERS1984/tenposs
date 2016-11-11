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
use App\Models\UserBots;
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
    public function chatAdmin(){
    
        $botService = UserBots::where('user_id', Session::get('user')->id )->first();
    	if( !$botService ){
    	    return view('admin.pages.chat.clients')->withErrors('Please config your BOT LINE info!' );
    	}
        // Get profile
        $requestProfile = $this->curl->newRequest('get', self::API_REQUEST_PROFILE )
            ->setHeader('Authorization',  'Bearer '. $botService->chanel_access_token  );
             
        $responseProfile = $requestProfile->send();
        $profile = json_decode($responseProfile->body);
        
        if( !$profile ){
            return view('admin.pages.chat.clients')->withErrors('Try again!' );
        }
    
        $contacts = DB::table('apps')
            ->join('app_users','app_users.app_id','=','apps.id')
            ->join('line_accounts','line_accounts.app_user_id','=','app_users.id')
            ->where('apps.user_id', Session::get('user')->id )
            ->select('line_accounts.mid','line_accounts.displayName','line_accounts.pictureUrl','line_accounts.statusMessage')
            ->orderBy('displayName')
            ->paginate(20);

        return view('admin.pages.chat.clients',[
            'contacts' => json_encode($contacts),
            'channel' =>  $botService->chanel_id,
            'profile' => json_encode( $profile )]);
    }
    
    public function searchContact(Request $request){
    
        if( $request->ajax() ){
            $contacts = DB::table('app_users')
            ->join('apps','app_users.app_id','=','apps.id')
            ->join('users','users.id','=','apps.user_id')
            ->join('line_accounts','line_accounts.app_user_id','=','app_users.id')
            ->where('users.id',Auth::user()->id)
            ->where('displayName','like','%'.$request->input('s').'%')
            ->select('line_accounts.mid','line_accounts.mid','line_accounts.displayName','line_accounts.pictureUrl','line_accounts.statusMessage')
            ->orderBy('displayName')
            ->paginate(20);
            
            return response()->json($contacts);
        }
        
    }
}
