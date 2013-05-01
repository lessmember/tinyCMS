<?php

class Service extends Controller {

	function page404($page){
		$page = htmlspecialchars($page);
		Core::view('service/404', array(
			'url'	=> $page,
			'main'	=> Core::conf('host.name')
		))->render(1);
	}
}