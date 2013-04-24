<?php

session_start();

class Session {

	static function set($name, $val){
		$_SESSION[$name] = $val;
	}

	static function get($name){
		return arrval($_SESSION, $name);
	}

	static function clear(){
		session_unset();
	}

	static function close(){
		session_unset();
		session_destroy();
	}
}

class s extends Session{}