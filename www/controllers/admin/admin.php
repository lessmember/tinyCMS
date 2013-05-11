<?php

class Admin_BaseController extends Controller {

	function __construct(){
		parent::__construct();
		$user = Session::get('user');
		if(!$user){
			return header('location: '. tpl::fullUrl('login','form',array('redirect' => Core::context()->uri)));
		}
		if(!$user->is_admin){
			die("You are not administrator");
		}
	}
}
