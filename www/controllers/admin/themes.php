<?php

class AdminThemes extends Admin_BaseController {

	function __construct(){
		parent::__construct();
	}

	function index(){
		$content = 'Themes administration sub module';
		Core::view('admin/main',
			array(
				'title'		=> 'Themes',
				'content'	=> $content
			))->render(1);
	}
}