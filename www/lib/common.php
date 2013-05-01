<?php

function arrval($arr, $name){
	return isset($arr[$name]) ? $arr[$name] : null;
}

function get($name){
	return arrval($_GET, $name);
}

function post($name){
	return arrval($_POST, $name);
}

function cookie($name){
	return arrval($_COOKIE, $name);
}

function p($data){
	print "<pre>\n";
	if(is_array($data) OR is_object($data)){
		print_r($data);
	} else {
		print $data;
	}
	print "</pre>\n";
}

function ilog($msg){
	// doing something
	p("<span style='color: #800; font-weight: bold;'>$msg</span>");
}