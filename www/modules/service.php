<?php

class Service extends Controller {

	function page404($page){
		$page = htmlspecialchars($page);
		print "Requested page '$page' not found.";
	}
}