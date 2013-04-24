<?php

class tpl {

	static function url($controller, $method=false, $params=false){
		$url = "?". Core::conf('controllerName') ."=".$controller;
		if($method !== false){
			$url .= "&".Core::conf('methodName')."=". $method;
			$assoc = array();
			if(is_array($params) and !empty($params)){
				foreach($params as $i => $param){
					if(preg_match('#^\d+$#', $i))
						$url .= "&". Core::conf('paramsName') . "[$i]=" . $param;
					else
						$assoc[] = $i . '=' . urlencode($param);
				}
				if(!empty($assoc)){
					$url .= '&' . implode('&', $assoc);
				}
			}
		}
		return $url;
	}

	static function fullUrl($controller=false, $method=false, $params=false){
		// Core::context('host')
		$url = Core::conf('page.protocol') . '://' . Core::conf('host.name');
		if($controller){
			$url .= '/' . self::url($controller, $method, $params);
		}
		return $url;
	}
}