<?php

$config = array(
	'controllerName' => 'module',
	'subControllerName'	=> 'sub_module',
	'methodName' => 'action',

	'defaultController' => 'main',
	'defaultMethod' => 'index',

	'paramsName' => 'option',

	'host.name'		=>	'tinycms.loc',
	'page.protocol'	=>	'http',

	'auth.cookie.period'	=> 24*60*60*14,

/*	'default.page'	=>	2,
	'default.page.type'	=>	'section',
	'theme'			=> 'red-lake', //'default',
*/
	'db.connection.default' => array(
		'name' => 'tinycms',
		'login' => 'devadmin',
		'password' => '1',
		'port' => '',
		'host' => '127.0.0.1',
		'encoding'	=> 'utf8'
	),

	'ext.lib' => array(
		'TaxonomyTree'		=>	DOC_ROOT . '/ext/TaxonomyTree.php'
	),

	'context.class.aliases'=> array(
	)
);