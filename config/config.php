<?php

$config = array();

/*
|--------------------------------------------------------------------------
| MongoDB Connection DSN
|--------------------------------------------------------------------------
|
| MongoDB server connection string
| 
| http://es1.php.net/manual/es/mongoclient.construct.php
|
*/

$config['connection']['dsn'] = 'mongodb://localhost:27017';

/*
|--------------------------------------------------------------------------
| MongoDB Database name
|--------------------------------------------------------------------------
|
| MongoDB database name
| 
| http://es1.php.net/manual/en/mongoclient.selectdb.php
|
*/

$config['connection']['database'] = 'database';

/*
|--------------------------------------------------------------------------
| Connection name
|--------------------------------------------------------------------------
|
| Mongator Connection name, just for connection recognition
| 
| http://es1.php.net/manual/en/mongoclient.selectdb.php
|
*/

$config['connection']['name'] = 'default';

/*
|--------------------------------------------------------------------------
| Mongator Models input path
|--------------------------------------------------------------------------
|
| The input path of the classes, A valid dir with YAML definitions of the 
| config classes, you must save the YAMLs config classes in this path. 
|
*/

$config['models']['input'] = __DIR__ . '/../input/';

/*
|--------------------------------------------------------------------------
| Models namespace
|--------------------------------------------------------------------------
|
| The output path of the classes. 
| Example: 
| If you models are call 'MyApp\Models\Article' you must set this as 'MyApp'
|
*/

$config['models']['namespace'] = 'Model';

/*
|--------------------------------------------------------------------------
| Mongator Models output path
|--------------------------------------------------------------------------
|
| The output path of the classes, just change it if you know what are you
| doing.  
|
*/

$config['models']['output'] = __DIR__ . '/../output/';

/*
|--------------------------------------------------------------------------
| Metadata class name
|--------------------------------------------------------------------------
|
| The metadata factory class name, just change it if you know what are you
| doing.  
|
*/

$config['metadata'] = 'Model\Mapping\Metadata';

return $config;


return array(

	// The path to your application's models
	'models' => path('app').'models',

	// Doctrine proxy class configuration
	'proxy' => array(
		'auto_generate' => true,
		'namespace'     => 'Entity\\Proxy',
		'directory'     => path('app').'models'.DS.'proxies',
	),

);

