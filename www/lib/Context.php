<?php

class Context {

	private $data = array();

	function __construct(){
		$this->baseContext();
	}

	function baseContext(){
	//	p($_SERVER);
		$this->set('host', $_SERVER['HTTP_HOST']);
		$this->set('referer', isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null);
		$this->set('uri', isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : null);
		$controllerName = get(Core::conf('controllerName'));
		if(!$controllerName)
			$controllerName = Core::conf('defaultController');
		$this->set('controller', $controllerName);

		$methodName = get(Core::conf('methodName'));
		if(!$methodName)
			$methodName = Core::conf('defaultMethod');
		$this->set('method', $methodName);

		$paramsName = (Core::conf('paramsName'));
		if(!$paramsName)
			return;
		$params = get(Core::conf('paramsName'));
		if(!$params)
			$params = array();
		$this->set('params', $params);
	}

	function set($name, $val){
		$this->data[$name] = $val;
	}

	function get($name){
		if(isset($this->data[$name]))
			return $this->data[$name];
	}

	function __get($name){
		return $this->get($name);
	}
}