<?php

class tpl {

	static function url($controller, $method=false, $params=false){
		$controllerName = $controller;
		$subController = null;
		if(is_array($controller)){
			$controllerName = $controller[0];
			$subController = $controller[1];
		}
		$url = "?". Core::conf('controllerName') ."=".$controllerName;
		if($subController)
			$url .= "&" . Core::conf('subControllerName') . '=' . $subController;
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


	/**
	 * Making html table by 2D array
	 * @param $data - array [][] exam: [ [name:jonny, age:20], [name: bobby, age: 30]. [name: barbara, age: 40]  ]
	 * @return string
	 */
	static function html_table($data, $tabStyle=''){
		if(empty($data))
			return '';
		$tbody = '';
		$header = '';
		if(is_object($data))
			$data = array($data);
		foreach($data as $i => $row){
			$tbody .= "\n".'<tr>';
			if(!$i){
				$header .= '<tr>';
			}
			$rowArr = get_object_vars($row);
			foreach($rowArr as $key => $val){
				if(!$i){
					$header .= '<th>' . $key . '</th>';
				}
				$tbody .= '<td>' . $val . '</td>' ;
			}
			if(!$i){
				$header .= '</tr>';
			}
			$tbody .= '</tr>';
		}
		return "<table border='1' style='{$tabStyle}'>" . "\n" .$header . $tbody . "\n" . '</table>';
	}

	static function globalStat(){
		print( round(10000*(microtime(true) - GLOBAL_LOG_TIME_START))/10000 );
	}

}