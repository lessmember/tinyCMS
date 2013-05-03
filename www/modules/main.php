<?php

class Main extends Controller {

	function index(){
		//print 'main::index()';
		return Core::controller('page')->content(Core::conf('default.page'));
	}
}