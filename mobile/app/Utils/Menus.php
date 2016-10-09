<?php
namespace App\Utils;


class Menus{
    public static function page($menuID){
        switch( $menuID ){
            case 1:
                return route('slideshow');//スライドショー
            case 2:
                return route('menus.index');//メニュー
            case 3:
                return route('news');//ニュース
            case 4:
                return route('reservation');//予約
            case 5:
                return route('photo.gallery');//フォトギャラリー
            case 6:
                return route('home');//ホーム
            case 7:
                return route('chat');//チャット
            case 8:
                return route('staff');//スタッフ
            case 9:
                return route('coupon');//クーポン  
            case 10:
                return route('configuration');//設定   
            default:
                return route('index');
                break;
        }
        
    }
}