<?php

class tpl {

	static function url($controller, $method=false, $params=false){
		$url = "?". Core::conf('controllerName') ."=".$controller;
		if($method !== false){
			$url .= "&".Core::conf('methodName')."=". $method;
			if(is_array($params) and !empty($params)){
				foreach($params as $i => $param){
					$url .= "&". Core::conf('paramsName') . "[$i]=" . $param;
				}
			}
		}
		return $url;
	}
}