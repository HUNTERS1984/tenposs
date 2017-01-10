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
            $step3 = ['status' => 'panel-primary', 'active' => 'in'];
        } else {

            $request->session()->put(JWTAuth::getPayload()->toArray()['sub'].'welcome_registration', '1');
        }

        $visibleStep3 = true;
        $visibleStep4 = true;
        $visibleStepFinal = false;
        if( $userInfos ){
            $visibleStep3 = false;
            if( $userInfos->shop_name != '' ){
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
            ->with('visibleStep1', $visibleStep1)
            ->with('visibleStep3', $visibleStep3)
            ->with('visibleStep4', $visibleStep4)
            ->with('visibleStepFinal', $visibleStepFinal )
            ->with('step', $arrStep);
        
    }
    
    public function dashboardPost(Request $request){
        
        if( !$request->exists('shop_name_register') ){
           
            $validator = Validator::make(  $request->all()  , [
                'business_type'=>'required',
                'app_name_register'=>'required|max:255',
                'domain'=>'required|unique:user_infos',
    			'domain_type'=>'required',
                //'tel'=>'required|numeric',
                //'fax'=>'required|numeric'
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
            if ($request->input('tel'))
                $userInfos->tel = $request->input('tel');
            if ($request->input('fax'))
                $userInfos->fax = $request->input('fax');
            $userInfos->domain_type = $request->input('domain_type');

            $userInfos->save();
           
            return back()
                ->with('status','アプリ登録は完了しました。');
        }else{
            //dd($request->all());
            $validator = Validator::make(  $request->all() , [
                'shop_category'=>'required',
                'shop_tel_register'=>'required',
                'shop_close_register'=>'required|max:255',
                'shop_time_register'=>'required|max:255',
                'shop_address_register'=>'required',
                'shop_name_register'=>'required|max:255',
                'shop_description_register'=>'required|max:1000',
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
           
            $userInfos->shop_category = $request->input('shop_category');
            if ($request->input('shop_url_register'))
                $userInfos->shop_url = $request->input('shop_url_register');
            $userInfos->shop_tel = $request->input('shop_tel_register');
            $userInfos->shop_regular_holiday = $request->input('shop_close_register');
            $userInfos->shop_business_hours = $request->input('shop_time_register');
            $userInfos->shop_address = $request->input('shop_address_register');
            $userInfos->shop_name = $request->input('shop_name_register');
            $userInfos->shop_description = $request->input('shop_description_register');
            $userInfos->save();
                
            return back()
                ->with('status','ショップ情報を保存しました。');
        }
        
        
    }
    
    public function getShopInfo(Request $request){
        if( $request->ajax() ){
            $client = new Client();
            $url =  str_replace("smartphone/","",$request->input('url'));
            $crawler = $client->request('GET', $url );
            $parse = parse_url($url);
            
            if ($parse['host'] == 'beauty.hotpepper.jp') {
                $ret = $crawler->filter('.slnDataTbl')->each(function ($row) {
                     $key =  $row->filter('th')->each(function ($k) {
                        return trim($k->text());
                     });

                     $data = $row->filter('td')->each(function ($d) {
                        return trim($d->text());
                     });

                     return array_combine($key, $data);
                });
                if (count($ret) > 0) {
                    $title = $crawler->filter('h1[id="headSummary"]')->each(function ($row) {
                        return $row->text();
                    });

                    if (count($title) > 0)
                        $ret[0]['店舗名'] = trim($title[0]);

                    $description = $crawler->filter('.slnTopImgDescription > p')->each(function ($row) {
                         return $row->text();
                    });
                    if (count($description) > 0)
                        $ret[0]['紹介文'] = trim($description[0]);
                    //dd($parse);
                    $crawler_tel = $client->request('GET', 'https://'.$parse['host']. '/smartphone'. $parse['path'] .'tel' );

                    $tel = $crawler_tel->filter('.icnTel')->each(function ($row) {
                         return $row->text();
                    });
                    if (count($tel) > 0)
                        $ret[0]['電話番号'] = trim($tel[0]);
                    $ret[0]['カテゴリー'] = 2;
                    echo json_encode($ret[0]);
                }
                
            } else if ($parse['host'] == 'tabelog.com') {
                $ret = $crawler->filter('.rd-detail-info')->each(function ($row) {
                     $key =  $row->filter('th')->each(function ($k) {
                        return trim($k->text());
                     });

                     $data = $row->filter('td')->each(function ($d) {
                        return trim($d->text());
                     });

                     return array_combine($key, $data);
                });
                //dd($ret);
                if (count($ret) > 0) {
                    $ret[0]['店舗名'] = $ret[0]['Restaurant name'];
                    $ret[0]['紹介文'] = $ret[0]['Categories'];
                    $ret[0]['電話番号'] = $ret[0]['TEL/reservation'];
                    $ret[0]['住所'] = $ret[0]['Addresses'];
                    $ret[0]['営業時間'] = $ret[0]['Operating Hours'];
                    $ret[0]['定休日'] = $ret[0]['Shop holidays'];
                    $ret[0]['カテゴリー'] = 1;
                    if (count($ret) > 3 && isset($ret[3]['The homepage']))
                        $ret[0]['お店のホームページ'] = $ret[3]['The homepage'];
                    echo json_encode($ret[0]);
                }

            } else {
                echo 'このリンクをサポートしていません。';
            }
            
            
        }
        
    }
 
    
}
