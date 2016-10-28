<?php
class Text
{
	public static function addQuoteToEachElem (array $arr) {
		return array_map(function ($elem) {
			return "'$elem'";
		}, $arr);
	}
	
	public static function convertArrayFieldsToText (array $arr) {
		return implode(', ', array_map(
			function($k, $v){
				return "$k = $v";
			}, 
			array_keys($arr),
			self::addQuoteToEachElem(array_values($arr)) 
		));
	}
}