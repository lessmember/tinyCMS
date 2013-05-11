<?php

class AdminUsers extends Admin_BaseController {

	function __construct(){
		parent::__construct();
	}

	function index(){
		$content = 'users administration sub class';
		Core::view('admin/main',
			array(
				'title'		=> 'Users',
				'content'	=> $content
			))->render(1);
	}
}