<?php

class Test1{
	function index(){
		Core::view('test/test1',array('msg' => 'testing, index'))->render(1);
	}

	function act1(){
		print 'testing, action 1';
	}
}