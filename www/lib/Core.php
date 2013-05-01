<?php

class Core{

	private static $instance = null;
	private $conf = null;
	private $context = null;

	function __construct(){
	}

	static function inst(){
		if(!self::$instance)
			self::$instance = new Core();
		return self::$instance;
	}

	function makeContext(){
		$config = array();
		include(DOC_ROOT. '/config.php');
		$this->conf = new Conf($config);
		$this->context = new Context();
	}

	function run(){
		$context = self::inst()->context;
		$controllerName = $context->controller;
		$method = $context->method;
		$params = $context->params;
	//	p($context);
		try{
			$this->loadController($controllerName);
		}catch(Exception $e){
			return $this->runError('page404', $_SERVER['REQUEST_URI']);
		}
		$className = ucfirst($controllerName);
		$methodList = get_class_methods($className);
	//	p($methodList);
		if($methodList)
			$incorrect = !in_array($method, $methodList);
		else
			$incorrect = true;

	//	p($incorrect);
		if($incorrect){
			return $this->runError('page404', $_SERVER['REQUEST_URI']);
		}
		$controller = new $className();
		call_user_func_array(array($controller, $method), $params);
	}

	function runError($page, $msg){
		$controllerName = 'service';
		$this->loadController($controllerName);
		$className = ucfirst($controllerName);
		$controller = new $className();
		call_user_func_array(array($controller, $page), array($msg));
	}

	function loadController($name){
		$fname = DOC_ROOT. '/modules/' . $name . '.php';
		if(!file_exists($fname))
			throw new Exception('No same controller!');
		require_once($fname);
	}

	function loadModel($name){
		$fname = DOC_ROOT. '/models/' . $name . '.php';
		if(!file_exists($fname))
			throw new Exception('No same model!');
		require_once($fname);
	}

	function finish(){

	}

	static function context($name=null){
		if($name)
			return self::inst()->context->get($name);
		else
			return self::inst()->context;
	}

	static function conf($name){
		return self::inst()->conf->get($name);
	}

	static function view($name, $data=array()){
		return new View($name, $data);
	}

	static function model($name){
		$class = ucfirst($name).'Model';
		self::inst()->loadModel($name);
		///$conf = self::conf('db.model_conn.'.$name); // only for specific models
		return new $class ();
	}

	static function controller($name){
		Core::inst()->loadController($name);
		$className = ucfirst($name);
		return new $className();
	}

	static function extLib($name){
		$extFiles = self::conf('ext.lib');
		if(!isset($extFiles[$name]))
			throw new Exception('ext.lib: no config for lib');
		$file = $extFiles[$name];
		if(!file_exists($file))
			throw new Exception('ext.lib: lib file not found');
		require_once ($file);
	}

}