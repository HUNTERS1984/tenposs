<?php
/**
 * Created by PhpStorm.
 * User: tranthanhtung
 * Date: 8/10/2016
 * Time: 11:38 AM
 */

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class ConnectDataBase extends Model {

        protected $tables='users';

        /*
         * ham lay tat ca data , nhan tham so vao table
         * trả về array
        */
        public function getDataAll($tables){
            $arrayobj = DB::table($tables)->get();
            return $arrayobj;
        }
        /*
         * ham lay tat ca data , nham tham so table , va dien kien where
         * tra ve array
         */
        public function getDataWhere($tables,$where,$value){
            $arrayobj= DB::table($tables)->where($where,$value)->first();
            return $arrayobj;
        }

        public function getDataWhereArray($tables,$wherearray){
            $arrayobj = DB::table($tables)->where([
                ['status', '=', '1'],
                ['subscribed', '<>', '1'],
            ])->get();

            return $arrayobj;
        }
} 