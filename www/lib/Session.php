<?php

session_start();

class Session {

	function set($name, $val){
		$_SESSION[$name] = $val;
	}

	function get($name){
		return arrval($_SESSION, $name);
	}
}

class s extends Session{}