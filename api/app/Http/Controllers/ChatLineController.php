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
    
   
    public function __construct(App\Models\User $user){
    	$this->curl = new \anlutro\cURL\cURL;
    }

    /*
    * Route: /
    * Handle BOT Server callback
    */
    public function index(Request $request){
        
        
        return view('welcome');
        $data = json_encode( $request->all() ) ;
        $data = json_decode($data);
        if( !$data ){
            return view('welcome');
        }
        $this->user = $user->where('email','test@gmail.com')->first();
    	$this->botService = [
	        'channelId' => $this->user->channelId,
	        'channelSecret' => $this->user->channelSecret,
	        'channelMid' => $this->user->channelMid,
	    ];
	    
    	$this->bot = new LINEBot($this->botService, new GuzzleHTTPClient($this->botService));
       
        $data = $data->result[0];
        Log::info(print_r($data, true));
        //“138311609000106303”	Received message (example: text, images)
        //“138311609100106403”	Received operation (example: added as friend)
        if ( $data->eventType == '138311609000106303' ){
            if( $data->toChannel == $this->user->channelId  && $data->to[0] == $this->user->channelMid){
                //1	Text message
                //2	Image message
                //3	Video message
                //4	Audio message
                //7	Location message
                //8	Sticker message
                //10	Contact message
                
                switch ($data->content->contentType) {
                    
                    case 1: // Text Message
                        $redis = L5Redis::connection();
                        $redis->publish('line.message', json_encode($data->content));
                        break;
                    
                    default:
                        // code...
                        break;
                }
                
            }
            
            
            
        }
  
    }
    
    /*
    * Route: /chat/screen/{app_user_id}
    * View chat enduser
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
    * Route: /chat/{mid}
    * View chat enduser
    */
    public function chat($mid){
      
        return view('chat.message',[
            'profile' => '',
            'room_id' => ''
        ]);
    }
    
    /*
    * Route: chat/line/verifined/token/{mid}
    * Login LINE button
    */
    public function verifinedToken($mid){
        $lineAccount = LineAccount::where('mid',$mid)->firstOrFail();
        
        $request = $this->curl->newRequest('get',self::API_VERIFIED_TOKEN)
             ->setHeader('Authorization', $lineAccount->token_type.' '.$lineAccount->access_token);
        $response = $request->send();
        $responseData = json_decode(json_encode($response->body));
        
        if( isset( $responseData->statusCode ) && $responseData->statusCode == 401 ){
            $appuser = Session::get('appuser');
            $app = AppClient::findOrFail($appuser->app_id);
            return view('chat.login',['app' => $app]);
        }else{
            return redirect('chat/'.$mid);
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
                if( $exitsLineAccount->count() > 0 ){
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
                        'statusMessage' => $profile->statusMessage,
                        'access_token' => $dataToken->access_token,
                        'token_type' => $dataToken->token_type,
                        'expires_in' => $dataToken->expires_in,
                        'refresh_token' => $dataToken->refresh_token,
                        'scope' => ''
                    ]);
                }
                
                // Subcribe to socket welcome
                //$res = $this->bot->sendText($data->mid, 'Welcome to Tenposs');
                return redirect('chat/'.$dataToken->mid);
            }
            
            
        }
        // if request LINE login fail
        if( $request->has('errorCode') ){
            return view('login',['errors' => $request->input('errorMessage') ]);
        }
        
    }

   
    /*
    * Route: /admin/chat
    * 
    */
    public function chatAdmin(){
        return view('admin.chat.message');
    }
    
}
