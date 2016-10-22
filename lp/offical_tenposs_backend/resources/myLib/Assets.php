<?php
class Assets{
	public static function getUrl($type,$file){
		return URL::to(Config::get('assets.'.$type)."/".$file);
	}

	public static function img($file){
		return self::getUrl('img',$file);
	}
	public static function css($file){
		return self::getUrl('css',$file);
	}
	public static function js($file){
		return self::getUrl('js',$file);
	}
}