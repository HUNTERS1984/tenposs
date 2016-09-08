<?php

namespace App\Http\Controllers;

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
use App\Models\User;
use App\Models\AppUser;
use App\Models\App as AppClient;

use DB;


use L5Redis;

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
    
   
    public function __construct(App\Models\User $user){
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
                    $redis = L5Redis::connection();
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
    public function chatAdmin($app_id){
        $app = AppClient::findOrFail($app_id);
        // Get profile BOT
        $config = [
            'channelId' =>  $app->bot_channel_id,
            'channelSecret' => $app->bot_channel_secret,
            'channelMid' => $app->bot_mid,
        ];
        $bot = new LINEBot($config, new GuzzleHTTPClient($config));
        
        $profile = $bot->getUserProfile([$app->bot_mid]);
       
        $request = $this->curl->newRequest('get',self::API_BOT_PROFILE,['mids' => 'u9c1af340d8af0d5aa7e63fffa2c2aa28'])
            ->setHeader('Accept-Charset', 'utf-8')
             ->setHeader('X-Line-ChannelID', $app->bot_channel_id)
             ->setHeader('X-Line-ChannelSecret', $app->bot_channel_secret)
             ->setHeader('X-Line-Trusted-User-With-ACL', $app->bot_mid);
             
        return view('clients.message',[
            'channel' =>  $app->bot_channel_id,
            'profile' => json_encode($profile['contacts'][0])]);
    }
    
    public function login(){
        if( !Session::has('appuser') ){
            abort(503);
        }
        $app_user = Session::get('appuser');
        $app = AppClient::findOrFail($app_user->app_id);
        return view('chat.login',['app' => $app]);
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
            $app = AppClient::findOrFail($app_user->app_id);
            return view('chat.login',['app' => $app]);
        }
        return view('chat.lineaccounts',['datas' => $lineAccounts ]);
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
        $app = AppClient::findOrFail($appuser->app_id);
        
        $request = $this->curl->newRequest('get',self::API_VERIFIED_TOKEN)
             ->setHeader('Authorization', $lineAccount->token_type.' '.$lineAccount->access_token);
        $response = $request->send();
        $responseData = json_decode(json_encode($response->body));
        
        if( isset( $responseData->statusCode ) && $responseData->statusCode == 401 ){
            return view('chat.login',['app' => $app]);
        }else{
            $profile = [
                'mid' => $lineAccount->mid,
                'pictureUrl' => $lineAccount->pictureUrl,
                'displayName' => $lineAccount->displayName
            ];
   
            return view('chat.message',[ 'profile' => json_encode($profile), 'channel' => $app->bot_channel_id ]);
            if( $this->user->client_id ==  $responseData->channelId )
            {
                
            }
        }
       
    }
    

    /*
    * Route: chat/verifined
    * Callback LINE authentication
    */
    public function verifined(Request $request){
        if( !Session::has('appuser') ){
            abort(503);
        }
        if( $request->has('code') ){
            $curl = new \anlutro\cURL\cURL;
            $appuser = Session::get('appuser');
            $app = AppClient::findOrFail($appuser->app_id);
            
            $paramsRequestToken = array(
                'grant_type' => 'authorization_code', 
                'client_id' => $app->line_channel_id,
                'client_secret' => $app->line_channel_secret,
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
                return view('chat.message',[ 'profile' => json_encode($profile),'channel' => $app->bot_channel_id ]);
            }
            
            
        }
        // if request LINE login fail
        if( $request->has('errorCode') ){
            
        }
        
    }

   
  
    
}
