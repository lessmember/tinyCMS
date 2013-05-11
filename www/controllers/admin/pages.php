<?php

class AdminPages  extends Admin_BaseController {

	function __construct(){
		parent::__construct();
	}

	function index(){
		$content = 'pages administration sub class';
		Core::view('admin/main',
			array(
				'title'		=> 'Content',
				'content'	=> $content
			))->render(1);
	}
}