<?php

class TestsubSub1 extends Testsub_BaseController {
	function __construct(){
		parent::__construct();
		$this->regularPage();
	}

	function index(){
		p('sub1 index; t2');
		p(tpl::url(array('admin', 'users')));
		tpl::globalStat( round(10000*(microtime(true) - GLOBAL_LOG_TIME_START))/10000 );
	}

	function save(){
		return;
		$model = Core::model('options');
		$res = $model->multiUpdate(
			array(
				array('id'=>1, 'value'=>'default'),
				array('id'=>2, 'value'=>'2')
			)
		);
		var_dump($res);
	}

	function preg(){
		p('preg testing');
		print preg_match('#^[\w \-\_\.\,\*]+$#u', 'Ластоногий апельсин number 1', $m);
		p($m);
	}

}