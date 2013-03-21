<?php

class Conf {

	private $data;

	function __construct($data){
		$this->data = $data;
	}

	function get($name){
		if(isset($this->data[$name]))
			return $this->data[$name];
	}

	function __get($name){
		return $this->get($name);
	}
}