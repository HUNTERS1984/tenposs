<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use File;
use Session;
use Log;
use App;
use App\Models\Message;
use App\Models\LineAccount;
use App\Models\Users;
use App\Models\AppUser;
use App\Models\AppBots;
use App\Models\App as AppClient;

use DB;
use Auth;
use Config;
use Redis;
use Illuminate\Http\Request;
class ChatLineController extends Controller
{
    //

    protected $bot;
    protected $user;
    protected $curl;
    protected $botService;
    protected $loginService;
    
    const API_REQUEST_TOKEN = 'https://api.line.me/v1/oauth/accessToken';
    const API_REQUEST_PROFILE = 'https://api.line.me/v1/profile';
    const API_VERIFIED_TOKEN = 'https://api.line.me/v1/oauth/verify';
    const API_BOT_PROFILE = 'https://api.line.me/v2/bot/profile/';
    

   
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
        Log::info(print_r($data, true));
        $data = $data->events[0];
        
        $botInfo = AppBots::where('chanel_id',$chanel_id )->first();
        if( $botInfo ){
            
            $LineAccount = LineAccount::where('mid',$data->source->userId )->first();
            if( ! $LineAccount ){
                // Save new Line Account info
                // Get profile
                $requestProfile = $this->curl->newRequest('get','https://api.line.me/v2/bot/profile/'.$data->source->userId )
                     ->setHeader('Authorization', 'Bearer '.$botInfo->chanel_access_token);
                $responseProfile = $requestProfile->send();
                $profile = json_decode($responseProfile->body);
                if($profile){
                    $LineAccount = new LineAccount();
                    $LineAccount->displayName = $profile->displayName;
                    $LineAccount->mid = $profile->userId;
                    $LineAccount->app_id = $botInfo->app_id;
                    $LineAccount->pictureUrl = $profile->pictureUrl;
                    $LineAccount->statusMessage = $profile->statusMessage;
                    $LineAccount->save();
                }

            }
            
            $arrPackage = array(
                'channel' => $botInfo,
                'data' => $data
            ); 
            
            $redis = Redis::connection();
            $redis->publish('message', json_encode($arrPackage));
        }
        
    }

    public function chatApp($app_id) {
        $bot = AppBots::where('app_id', $app_id)
            ->select('add_friend_href','qr_code_href')
            ->first();
        if(  !$bot ){
            abort(404);
        }
        return view('chat.requestFriends', array( 'bot' => $bot ) );
    } 
    /*
    * Route: /chat/screen/{app_user_id}
    * View list line accounts
    */
    /*
    public function chatScreen($app_user_id){
       
        $app_user = AppUser::find($app_user_id);
        if(! $app_user){
            abort(502);
        }
        $lineAccounts = DB::table('line_accounts')
            ->where('line_accounts.app_user_id',$app_user->id)
            ->select('mid','pictureUrl','displayName','statusMessage')
            ->get();

        if(count($lineAccounts) <= 0 ){
            return redirect()->route('chat.request');
        }
        return view('chat.lineaccounts',
            ['datas' => $lineAccounts,'app_user_id' => $app_user->id  ]);
    }
    
    public function chat($app_user_id, $mid){
        $LineAccount = LineAccount::where('mid',$mid )
            ->select('mid','pictureUrl','displayName','statusMessage')
            ->first();

        if( $LineAccount ){

            $bot = DB::table('app_users')
                ->join('app_bots','app_bots.app_id','=','app_users.app_id')
                ->where('app_users.id', $app_user_id )
                ->select('app_bots.*')
                ->first();

            if( $bot ){
                return view('chat.message',[
                    'profile' => json_encode($LineAccount), 
                    'channel' => $bot->chanel_id]);
            }
                
            abort(404);
        }

        abort(404);
        
    }

    public function requestFriend() {
        return view('chat.requestFriends');
    }
    
    
    public function login(){
        return view('admin::pages.chat.login');
    }
   
    public function verifined(Request $request){
       
        if( $request->has('code') ){
            
            if( !Session::has('appuser') ){
                abort(503);
            }
            
            $appuser = Session::get('appuser');
       
            $paramsRequestToken = array(
                'grant_type' => 'authorization_code', 
                'client_id' => Config::get('line.LINE_CHANEL_ID'),
                'client_secret' => Config::get('line.LINE_CHANEL_SECRET'),
                'code' => $request->input('code'),
                'redirect_uri' => url('chat/verifined')
            );
            // Request to get access token
            $responseToken = $this->curl->post(self::API_REQUEST_TOKEN, $paramsRequestToken);
            if($responseToken->statusCode == 200){
             
                $dataToken = json_decode($responseToken->body);
                // Get profile
                $requestProfile = $this->curl->newRequest('get',self::API_REQUEST_PROFILE)
                     ->setHeader('Authorization', $dataToken->token_type.' '.$dataToken->access_token);
                     
                $responseProfile = $requestProfile->send();
                $profile = json_decode($responseProfile->body);
         
                // Save Line Account
                $exitsLineAccount = LineAccount::where('mid', $dataToken->mid )->first();
                if( $exitsLineAccount ){
                    // Update token
                    $exitsLineAccount->access_token = $dataToken->access_token;
                    $exitsLineAccount->token_type = $dataToken->token_type;
                    $exitsLineAccount->expires_in = $dataToken->expires_in;
                    $exitsLineAccount->refresh_token = $dataToken->refresh_token;
                    $exitsLineAccount->save();
                
                }else{
                    // Create new Line Account
                 
                    $exitsLineAccount = LineAccount::create([
                        'mid' => $dataToken->mid,
                        'app_user_id' => $appuser->id,
                        'displayName' => $profile->displayName,
                        'pictureUrl' => $profile->pictureUrl,
                        'statusMessage' => (isset($profile->statusMessage)) ? $profile->statusMessage : '',
                        'access_token' => $dataToken->access_token,
                        'token_type' => $dataToken->token_type,
                        'expires_in' => $dataToken->expires_in,
                        'refresh_token' => $dataToken->refresh_token,
                        'scope' => ''
                    ]);
                }
                // If line_user_id
                if( $exitsLineAccount->line_user_id == '' ){
                    return redirect()->route('chat.request', ['mid' => $exitsLineAccount->mid ]);
                }
                
                $profile->line_user_id = $exitsLineAccount->line_user_id;
                
                $bot = DB::table('apps')
                    ->join('app_users','app_users.app_id','=','apps.id')
                    ->join('user_bots','user_bots.user_id','=','apps.user_id')
                    ->where('apps_user.id', $appuser->id )
                    ->select('user_bots.*')
                    ->first();
                    
                return view('admin::pages.chat.message',[ 
                    'profile' => json_encode($profile), 
                    'channel' => $bot->channel_id]);
    
            }
            
        }
       
        return redirect()->route('chat.login');

        
    }

    public function verifinedToken($mid){
        if( !Session::has('appuser') ){
            abort(503);
        }
        $lineAccount = LineAccount::where('mid',$mid)->firstOrFail();
        
        $appuser = Session::get('appuser');
        // $app = AppClient::findOrFail($appuser->app_id);
        
        $request = $this->curl->newRequest('get',self::API_VERIFIED_TOKEN)
             ->setHeader('Authorization', $lineAccount->token_type.' '.$lineAccount->access_token);
        $response = $request->send();
        $responseData = json_decode(json_encode($response->body));
        
        
        if( isset( $responseData->statusCode ) && $responseData->statusCode == 401 ){
            return view('admin::pages.chat.login');
        }else{
            $profile = [
                'mid' => $lineAccount->mid,
                'pictureUrl' => $lineAccount->pictureUrl,
                'displayName' => $lineAccount->displayName
            ];
            
            $app_user = DB::table('app_users')
                ->join('apps','app_users.app_id','=','apps.id')
                ->join('users','users.id','=','apps.user_id')
                ->where('app_users.app_id',$appuser->app_id)
                ->select('users.id')
                ->take(1)
                ->get()
                ;
            if(!$app_user)
                abort(503);
   
            return view('admin::pages.chat.message',[ 
                'profile' => json_encode($profile), 
                'channel' => $app_user[0]->id.'-'.Config::get('line.BOT_CHANEL_ID') ]);
        }
       
    }

   
    */
}
