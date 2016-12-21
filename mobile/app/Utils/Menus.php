<?php
namespace App\Utils;

use Session;

class Menus{
    public static function page($menuID){
        switch( $menuID ){

            case 1:
                $arr = array(
                    'classes' => '',
                    'display' => true,
                    'href' => route('slideshow')//スライドショー
                );
                return $arr;
            case 2:
                $arr = array(
                    'classes' => 'ui-icon-grid ui-btn-icon-left',
                    'display' => true,
                    'href' => route('menus.index')//メニュー
                );
                return $arr;
            case 3:
                $arr = array(
                    'classes' => 'ui-icon-bullets ui-btn-icon-left',
                    'display' => true,
                    'href' => route('news')//ニュース
                );
                return $arr;

            case 4:
                $arr = array(
                    'classes' => 'ui-icon-forward ui-btn-icon-left',
                    'display' => true,
                    'href' => route('reservation')//予約
                );
                return $arr;
            case 5:
                $arr = array(
                    'classes' => 'ui-icon-camera ui-btn-icon-left',
                    'display' => true,
                    'href' => route('photo.gallery')//フォトギャラリー
                );
                return $arr;
            case 6:
                $arr = array(
                    'classes' => 'ui-icon-home ui-btn-icon-left',
                    'display' => true,
                    'href' => route('home')//ホーム
                );
                return $arr;
            case 7:
                $arr = array(
                    'classes' => 'ui-icon-comment ui-btn-icon-left',
                    'display' => Session::has('user'),
                    'href' => route('chat')//チャット
                );
                return $arr;
            case 8:
                $arr = array(
                    'classes' => 'ui-icon-user ui-btn-icon-left',
                    'display' => true,
                    'href' => route('staff')//スタッフ
                );
                return $arr;
            case 9:
                $arr = array(
                    'classes' => 'ui-icon-star ui-btn-icon-left',
                    'display' => true,
                    'href' => route('coupon')//クーポン
                );
                return $arr;
            case 10:
                $arr = array(
                    'classes' => 'ui-icon-gear ui-btn-icon-left',
                    'display' => Session::has('user'),
                    'href' => route('configuration')//設定
                );
                return $arr;
            default:
                return route('index');
                break;
        }
        
    }
}