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

}