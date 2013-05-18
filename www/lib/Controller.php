<?php


class Controller {
	function __construct(){

	}

	function regularPage(){
		$this->contentType();
	}

	function contentType($type='text/html', $enc = 'utf-8'){
		header("Content-type: $type; charset=$enc");
	}

	function jsonResponse($data){
		header("Content-type: application/json; charset=utf-8");
		print json_encode($data);
	}
}
