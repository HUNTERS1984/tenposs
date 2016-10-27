<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Validator;
use Auth;
use Goutte\Client;

class RegisterProcessController extends Controller
{
    //
    
    
    public function __construct(){
        
    }
    
    public function dashboard(Request $request){
        
        $token = 1;
        $active = false;
        
        if( $active ){
            $step2 = ['status' => 'panel-success', 'active' => ''];
            $step3 = ['status' => 'panel-primary', 'active' => 'in'];
            $step4 = ['status' => 'panel-primary', 'active' => ''];
        }else{
            $step2 = ['status' => 'panel-primary', 'active' => 'in'];
            $step3 = ['status' => 'panel-primary', 'active' => ''];
            $step4 = ['status' => 'panel-primary', 'active' => ''];
        }
      
       
        $arrStep = [
            'step1' => ['status' => 'panel-success', 'active' => ''],
            'step2' => $step2,
            'step3' => $step3,
            'step4' => $step4,
            
        ];
        return view('pages.registers.dashboard')
            ->with('active', $active)
            ->with('step', $arrStep);
        
    }
    
    public function dashboardPost(Request $request){
        $active = false;
        if( !$active ){
            return back()
                ->with('status','アクティブにするためにあなたの電子メールをチェックしてください。');
        } 
         
        
        $data = $request->all();
        
        if( !$request->has('shop_info') ){
            
            $validator = Validator::make(  $data , [
                'business_type'=>'required',
                'app_name_register'=>'required',
                'domain'=>'required|unique:users',
    			'domain_type'=>'required'
            ]);
            
            if ($validator->fails())
    		{
    			$this->throwValidationException(
    				$request, $validator
    			);
    		}
            
            $user = Auth::user();
            $user->business_type = $data['business_type'];
            $user->app_name_register = $data['app_name_register'];
            $user->domain = $data['domain'];
            $user->company = $data['company'];
            $user->tel = $data['tel'];
            $user->fax = $data['fax'];
            $user->status = 2;
            
            $user->domain_type = $data['domain_type'];
            $user->save();
           
            return back()
                ->with('status','Register product success!');
        }else{
            
            $validator = Validator::make(  $data , [
                'shop_info'=>'required|active_url',
            ]);
            
            if ($validator->fails())
    		{
    			$this->throwValidationException(
    				$request, $validator
    			);
    		}
            $user = Auth::user();
            $user->shop_info = $data['shop_info'];
            $user->save();
                
            return back()
                ->with('status','Add shop info success!');
        }
        
        
    }
    
    public function getShopInfo(Request $request){
        if( $request->ajax() ){
            $client = new Client();
            $crawler = $client->request('GET', $request->input('url') );
            $data = '';
            $crawler->filter('.slnTopImgDescription > p')->each(function ($description) {
                print $description->text();
            });
            
        }
        
    }
 
    
}
