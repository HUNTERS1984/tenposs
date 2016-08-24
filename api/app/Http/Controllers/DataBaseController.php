<?php
/**
 * Created by PhpStorm.
 * User: tttun
 * Date: 8/10/2016
 * Time: 1:51 PM
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Routing\Controller;
use App\Models\ConnectDataBase;

class DataBaseController extends Controller{
    protected $request;

    public function __construct(Request $request){
        $this->request=$request;
    }
    public function showalldataUser(){
        try{
            $db= new ConnectDataBase();
            $param = array();
            $param['name']= $this->request['name'];
            $response = array();
            $i = 0;
            if($param['name']=='' || empty($param['name'])) {
                $obj_array = $db->getDataAll('users');

                foreach ($obj_array as $user) {
                    $i++;
                    $response['item_' . $i]['name'] = $user->name;
                    $response['item_' . $i]['email'] = $user->email;
                    $response['item_' . $i]['password'] = $user->password;
                    $response['item_' . $i]['fullname'] = $user->fullname;
                    $response['item_' . $i]['sex'] = $user->sex;
                    $response['item_' . $i]['birthday'] = $user->birthday;
                    $response['item_' . $i]['locale'] = $user->locale;
                    $response['item_' . $i]['status'] = $user->status;
                    $response['item_' . $i]['temporary_hash'] = $user->temporary_hash;
                    $response['item_' . $i]['remember_token'] = $user->remember_token;
                    $response['item_' . $i]['created_at'] = $user->created_at;
                    $response['item_' . $i]['updated_at'] = $user->updated_at;
                    $response['item_' . $i]['deleted_at'] = $user->deleted_at;
                    $response['item_' . $i]['company'] = $user->company;
                    $response['item_' . $i]['address'] = $user->address;
                    $response['item_' . $i]['tel'] = $user->tel;

                } //end for
            }else{

                $obj_array = $db->getDataWhere('users','name',$param['name']);
                $response['item_' . $i]['name'] = $obj_array->name;
                $response['item_' . $i]['email'] = $obj_array->email;
                $response['item_' . $i]['password'] = $obj_array->password;
                $response['item_' . $i]['fullname'] = $obj_array->fullname;
                $response['item_' . $i]['sex'] = $obj_array->sex;
                $response['item_' . $i]['birthday'] = $obj_array->birthday;
                $response['item_' . $i]['locale'] = $obj_array->locale;
                $response['item_' . $i]['status'] = $obj_array->status;
                $response['item_' . $i]['temporary_hash'] = $obj_array->temporary_hash;
                $response['item_' . $i]['remember_token'] = $obj_array->remember_token;
                $response['item_' . $i]['created_at'] = $obj_array->created_at;
                $response['item_' . $i]['updated_at'] = $obj_array->updated_at;
                $response['item_' . $i]['deleted_at'] = $obj_array->deleted_at;
                $response['item_' . $i]['company'] = $obj_array->company;
                $response['item_' . $i]['address'] = $obj_array->address;
                $response['item_' . $i]['tel'] = $obj_array->tel;
            } //end if


        }catch (Exception $e){
            $response = array(
                'code' => 500,
                'message' => 'Error'
            );
        } finally {
            return response()->json($response);
        } // end try
    }
}