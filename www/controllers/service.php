<?php

class Service extends Controller {

	function page404($page, $main=null){
		$page = htmlspecialchars($page);
		Core::view('service/404', array(
			'url'	=> $page,
			'main'	=> $main ? $main : tpl::fullUrl()
		))->render(1);
	}
}