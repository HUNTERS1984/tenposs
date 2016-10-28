<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Validator;
use Goutte\Client;
use JWTAuth;
use App\Models\UserInfos;

class RegisterProcessController extends Controller
{
    //
    
    
    public function __construct(){
       
    }
    
    public function dashboard(Request $request){
        
        
        $userInfos = UserInfos::find($request->user['sub']);
        $step2 = ['status' => 'panel-primary', 'active' => ''];
        $step3 = ['status' => 'panel-primary', 'active' => ''];
        $step4 = ['status' => 'panel-primary', 'active' => ''];
        
        $visibleStep1 = true;
        if ($request->session()->get(JWTAuth::getPayload()->toArray()['sub'].'welcome_registration'))
        {   
            $visibleStep1 = false;
        } else {

            $request->session()->put(JWTAuth::getPayload()->toArray()['sub'].'welcome_registration', '1');
        }

        $visibleStep3 = true;
        $visibleStep4 = true;
        $visibleStepFinal = false;
        if( $userInfos ){
            $visibleStep3 = false;
            if( $userInfos->shop_info != '' ){
                $visibleStep4 = false;
                $visibleStepFinal = true;
            }else{
                $step4 = ['status' => 'panel-primary', 'active' => 'in'];
            }
        }
        

        $arrStep = [
            'step1' => ['status' => 'panel-primary', 'active' => 'in'],
            'step2' => $step2,
            'step3' => $step3,
            'step4' => $step4,
            
        ];
        return view('pages.registers.dashboard')
            ->with('visibleStep1', $visibleStep1 )
            ->with('visibleStep3', $visibleStep3)
            ->with('visibleStep4', $visibleStep4 )
            ->with('visibleStepFinal', $visibleStepFinal )
            ->with('step', $arrStep);
        
    }
    
    public function dashboardPost(Request $request){
        
        if( !$request->exists('shop_info') ){
           
            $validator = Validator::make(  $request->all()  , [
                'business_type'=>'required',
                'app_name_register'=>'required|max:255',
                'domain'=>'required|unique:user_infos',
    			'domain_type'=>'required',
                'tel'=>'required|numeric',
                'fax'=>'numeric'
            ]);
            
            if ($validator->fails())
    		{
    			 return back()
                    ->withInput()
                    ->withErrors($validator);
    		}
            
            $userInfos = new UserInfos();
            $userInfos->id = $request->user['sub'];
            $userInfos->business_type = $request->input('business_type');
            $userInfos->app_name_register = $request->input('app_name_register');
            $userInfos->domain = $request->input('domain');
            $userInfos->company = $request->input('company');
            $userInfos->tel = $request->input('tel');
            $userInfos->fax = $request->input('fax');
            $userInfos->domain_type = $request->input('domain_type');
            $userInfos->save();
           
            return back()
                ->with('status','アプリ登録は完了しました。');
        }else{
          
            $validator = Validator::make(  $request->all() , [
                'shop_info'=>'required|active_url',
            ]);
            
            if ($validator->fails())
    		{
    			 return back()
                    ->withInput()
                    ->withErrors($validator);
    		}
            $userInfos = UserInfos::find($request->user['sub']);
            if( !$userInfos  ){
                return back()
                    ->with('warning','アプリ登録を完了してください');
            }
           
            $userInfos->shop_info = $request->input('shop_info');
            $userInfos->save();
                
            return back()
                ->with('status','ショップ情報を保存しました。');
        }
        
        
    }
    
    public function getShopInfo(Request $request){
        if( $request->ajax() ){
            $client = new Client();
            $crawler = $client->request('GET', $request->input('url') );
            $parse = parse_url($request->input('url'));
            
            if ($parse['host'] == 'beauty.hotpepper.jp') {
                $ret = $crawler->filter('.slnDataTbl')->each(function ($row) {
                     $key =  $row->filter('th')->each(function ($k) {
                        return $k->text();
                     });

                     $data = $row->filter('td')->each(function ($d) {
                        return $d->text();
                     });

                     return array_combine($key, $data);
                });
                echo '<table>';
                foreach ($ret[0] as $key => $value) {
                    print '<tr><th style="width:35%">'.$key.'</th>'.'<td>'.$value.'</td></tr>';
                }
                echo '</table>';
            } else if ($parse['host'] == 'tabelog.com') {
                $ret = $crawler->filter('.rd-detail-info')->each(function ($row) {
                     $key =  $row->filter('th')->each(function ($k) {
                        return $k->text();
                     });

                     $data = $row->filter('td')->each(function ($d) {
                        return $d->text();
                     });

                     return array_combine($key, $data);
                });
                echo '<table>';
                foreach ($ret[0] as $key => $value) {
                    print '<tr><th style="width:35%">'.$key.'</th>'.'<td>'.$value.'</td></tr>';
                }
                echo '</table>';
            } else {
                echo 'このリンクをサポートしていません。';
            }
            
            
        }
        
    }
 
    
}
