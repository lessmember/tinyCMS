<?php

session_start();

class Session {

	static function set($name, $val){
		$_SESSION[$name] = $val;
	}

	static function get($name){
		return arrval($_SESSION, $name);
	}
}

class s extends Session{}