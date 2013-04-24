<?php

$config = array(
	'controllerName' => 'module',
	'methodName' => 'action',

	'defaultController' => 'main',
	'defaultMethod' => 'index',

	'paramsName' => 'option',

	'host.name'		=>	'tinycms.loc',
	'page.protocol'	=>	'http',

	'auth.cookie.period'	=> 24*60*60*14,

	'db.connection.default' => array(
		'name' => 'tinycms',
		'login' => 'devadmin',
		'password' => '1',
		'port' => '',
		'host' => '127.0.0.1',
	)
);