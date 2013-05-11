<?php

abstract class Testsub_BaseController  extends Controller {
	function __construct(){
		parent::__construct();
		p('test sub base');
	}
}