<?php

define('DOC_ROOT', __DIR__);
define('LIB_ROOT', __DIR__ . '/lib');

require_once(LIB_ROOT . '/loader.php');

try{
	Core::inst();
	Core::inst()->makeContext();
	Core::inst()->run();
	Core::inst()->finish();
} catch(Exception $e){
	print 'Sorry, some troubles happened. Check the url or try later.';
	ilog($e->getMessage());
}

print '<br><br>-- end --';