<?php

define('GLOBAL_LOG_TIME_START', microtime(true));
define('GLOBAL_LOG_RAM_USAGE_START', memory_get_usage());

define('DOC_ROOT', __DIR__);
define('LIB_ROOT', __DIR__ . '/lib');

mb_internal_encoding("UTF-8");

require_once(LIB_ROOT . '/loader.php');

try{
	Core::inst();
	Core::inst()->makeContext();
	Core::inst()->run();
	Core::inst()->finish();
} catch(Exception $e){
	print 'Sorry, some troubles happened. Check the url or try later.';
	ilog('Exception! '.$e->getMessage());
}
define('GLOBAL_LOG_TIME_END', microtime(true));
define('GLOBAL_LOG_RAM_USAGE_END', memory_get_usage());

// use in $_GET for global stats:
// &global_logging_full_exec_time=1&global_logging_ram_usage=1
if(get('global_logging_full_exec_time')){
	p('exec_time = ' . (GLOBAL_LOG_TIME_END - GLOBAL_LOG_TIME_START) . ' sec');
}

if(get('global_logging_ram_usage')){
	p('usage memory start: '. GLOBAL_LOG_RAM_USAGE_START.
		' ; usage memory end: '. GLOBAL_LOG_RAM_USAGE_END.
		' ; usage memory different: '. ceil((GLOBAL_LOG_RAM_USAGE_END - GLOBAL_LOG_RAM_USAGE_START)/1024)  .' kBytes');
}

//print '<br><br>-- end --';