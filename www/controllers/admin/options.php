<?php

class AdminOptions  extends Admin_BaseController {

	function __construct(){
		parent::__construct();
	}

	function index(){
		$model = Core::model('options');
		$data = $model->all();

		$content = tpl::html_table($data);

		Core::view('admin/main',
			array(
				'title'		=> 'Options',
				'content'	=> $content
			))->render(1);
	}
}