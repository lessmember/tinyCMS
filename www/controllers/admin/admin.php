<?php

class Admin_BaseController extends Controller {

	protected $title='Admin';

	function __construct(){
		parent::__construct();
		$user = Session::get('user');
		if(!$user){
			return header('location: '. tpl::fullUrl('login','form',array('redirect' => Core::context()->uri)));
		}
		$this->regularPage();
		if(!$user->is_admin){
			die("You are not administrator");
		}
	}

	protected function mainConten($content){
		Core::view('admin/main',
			array(
				'title'		=> $this->title,
				'content'	=> $content
			))->render(1);
	}

	protected function warning($msg){
		return $this->mainConten(
			Core::view('admin/warning', array('msg' => $msg))->render()
		);
	}
}
