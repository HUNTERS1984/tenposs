<?php
namespace App\Utils;


class Messages
{
    /*
    9993		No character is registed on server
    9994		Point is not enought
    9995		User is not validated.
    9996		User existed.
    9997		Method is not valid.
    9998		invalid token
    9999		Lỗi exception
    1001		Lõi mất kết nối DB/hoac thuc thi cau SQL
    1002		Số lượng Paramater không đầy đủ
    1003		Kieu Parameter không đúng đắn.
    1004		Value cua parameter khong hop le
    1005		Unknown error
    1006		Email not correct
    1007		Address does not exits
    1008		Can not send email
    1009		Account is not active
    1010		Create Room Success
    1011		Time expire
    1012		Parameter sig not exist
    1013		Parameter sig is not valid
    */
    
    /*
    Custom message
    2000    Can't not get social user
    */
    
    static $customErrorsList = array(
         '2000' =>  "Can't not get social user"
    );
    
    
    public static function getCustomErrorMessage($code){
    
        return self::$customErrorsList[$code];
    }
    
    public static function validateErrors( $response ){
        if( $response->code == 1000 ){
            return true;
        }
        return false;
    }
    
    public static function getMessage( $response ){
        return array(
            'class' => 'alert-danger', 
            'detail' => $response->message 
        );
    }
    
    public static function customMessage( $code ){
        return array(
            'class' => 'alert-danger', 
            'detail' => self::getCustomErrorMessage($code)
        );
    }
}
