<?php

class Login extends Controller{

	function __construct(){
		parent::__construct();
		$this->regularPage();
	}

	function index(){
		$redirect = get('redirect');
		print ($redirect);
		p( tpl::url('login', 'check', array('Vasya', 'Pupkin')));
		$this->form();
	}

	function form(){
		Core::view('login/form');
	}

	function check(){

	}

}
