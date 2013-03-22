<?php

class Admin extends Controller {

	function __construct(){
		parent::__construct();
		if(!Session::get('user_admin')){
			return header('location:http://'.Core::context('host').'/?module=login&redirect='.urlencode('?module=admin'));
		}
	}

	function index(){

	}
}