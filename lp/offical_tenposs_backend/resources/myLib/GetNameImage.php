<?php
class GetNameImage {
	public static function make($chuoi1,$path_img,$chuoi2="."){
		$arr1 = explode($chuoi1, $path_img);
		$last_ele = end($arr1);
		$arr2 = explode($chuoi2, $last_ele);
		return current($arr2);
	}
}
