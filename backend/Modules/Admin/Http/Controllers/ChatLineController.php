<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Requests;
use \LINE\LINEBot;
use LINE\LINEBot\HTTPClient\GuzzleHTTPClient;
use LINE\LINEBot\Message\MultipleMessages;
use LINE\LINEBot\Message\RichMessage\Markup;

use File;
use Session;
use Log;
use App;
use App\Models\Message;
use App\Models\LineAccount;
use App\Models\Users;
use App\Models\AppUser;
use App\Models\App as AppClient;

use DB;
use Auth;

use Config;
use LRedis;

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
    const API_BOT_PROFILE = 'https://trialbot-api.line.me/v1/profiles';
    
   
    public function __construct(){
    	$this->curl = new \anlutro\cURL\cURL;
    }

    /*
    * Route: /
    * Handle BOT Server callback
    */
    public function index(Request $request){
        
        $data = json_encode( $request->all() ) ;
        $data = json_decode($data);
        if( !$data ){
            return view('welcome');
        }
 
        $data = $data->result[0];
        
        //“138311609000106303”	Received message (example: text, images)
        //“138311609100106403”	Received operation (example: added as friend)
        if ( $data->eventType == '138311609000106303' ){
            // Get BOT Info
            //1	Text message
            //2	Image message
            //3	Video message
            //4	Audio message
            //7	Location message
            //8	Sticker message
            //10 Contact message
            
            switch ($data->content->contentType) {
                
                case 1: // Text Message
                    Log::info(print_r($data, true));
                    $redis = LRedis::connection();
                    $redis->publish('message.bot', json_encode($data->content));
                    break;
                
                default:
                    // code...
                    break;
            }
            
        }
    }
    
    /*
    * Route: /admin/chat
    * 
    */
    public function chatAdmin(){
       
        if( !Auth::check() )
            abort(503);
            
        // Get profile BOT
        $config = [
            'channelId' =>  Config::get('line.BOT_CHANEL_ID'),
            'channelSecret' => Config::get('line.BOT_CHANEL_SECRET'),
            'channelMid' => Config::get('line.BOT_MID'),
        ];
        $bot = new LINEBot($config, new GuzzleHTTPClient($config));
        
        $profile = $bot->getUserProfile([  Config::get('line.BOT_MID') ]);
       
        $request = $this->curl->newRequest('get',self::API_BOT_PROFILE,['mids' => Config::get('line.BOT_MID')])
            ->setHeader('Accept-Charset', 'utf-8')
            ->setHeader('X-Line-ChannelID', Config::get('line.BOT_CHANEL_ID') )
            ->setHeader('X-Line-ChannelSecret', Config::get('line.BOT_CHANEL_SECRET') )
            ->setHeader('X-Line-Trusted-User-With-ACL', Config::get('line.BOT_MID') );
             
        return view('admin::pages.chat.clients',[
            'channel' =>  Auth::user()->id.'-'.Config::get('line.BOT_CHANEL_ID'),
            'profile' => json_encode($profile['contacts'][0])]);
    }
    
    public function login(){
        return view('admin::pages.chat.login');
    }
    
    /*
    * Route: /chat/screen/{app_user_id}
    * View list line accounts
    */
    public function chatScreen($app_user_id){
        
        $app_user = AppUser::findOrFail($app_user_id);
        Session::put('appuser',$app_user);
        
        $lineAccounts = DB::table('line_accounts')
            ->where('line_accounts.app_user_id',$app_user->id)
            ->select('mid','pictureUrl','displayName','statusMessage')
            ->get();
   
        if(count($lineAccounts) <= 0 ){
            return view('admin::pages.chat.login');
        }
        return view('admin::pages.chat.lineaccounts',['datas' => $lineAccounts ]);
    }
    
    /*
    * Route: chat/line/verifined/token/{mid}
    * Login LINE button
    */
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
    

    /*
    * Route: chat/verifined
    * Callback LINE authentication
    */
    public function verifined(Request $request){
       
        if( $request->has('code') ){
            
            if( !Session::has('appuser') ){
                abort(503);
            }
            
            $curl = new \anlutro\cURL\cURL;
           
            $appuser = Session::get('appuser');
            //$app = AppClient::findOrFail($appuser->app_id);
            
            $paramsRequestToken = array(
                'grant_type' => 'authorization_code', 
                'client_id' => Config::get('line.LINE_CHANEL_ID'),
                'client_secret' => Config::get('line.LINE_CHANEL_SECRET'),
                'code' => $request->input('code'),
                'redirect_uri' => url('chat/verifined')
            );
            // Request to get access token
            $responseToken = $curl->post(self::API_REQUEST_TOKEN, $paramsRequestToken);
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
                    // Create new
                 
                    LineAccount::create([
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
                
                // Subcribe to socket welcome
                //$res = $this->bot->sendText($data->mid, 'Welcome to Tenposs');
                $app_user = DB::table('app_users')
                    ->join('apps','app_users.app_id','=','apps.id')
                    ->join('users','users.id','=','apps.user_id')
                    ->where('app_users.app_id',$appuser->app_id)
                    ->select('users.id')
                    ->take(1)
                    ->get();
                    
                if(!$app_user)
                    abort(503);
   
                return view('admin::pages.chat.message',[ 
                    'profile' => json_encode($profile), 
                    'channel' => $app_user[0]->id.'-'.Config::get('line.BOT_CHANEL_ID') ]);
    
            }
            
        }
        // if request LINE login fail
        if( $request->has('errorCode') ){
            
        }
        
    }

   
  
    
}
