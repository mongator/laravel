<?php

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

$config['connection_dsn'] = 'mongodb://localhost:27017';

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

$config['connection_database'] = 'database';

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

$config['connection_name'] = 'default';

/*
|--------------------------------------------------------------------------
| Query Logger
|--------------------------------------------------------------------------
|
| If True enable the Mongator logger
|
*/

$config['logger'] = true;

/*
|--------------------------------------------------------------------------
| Metadata class name
|--------------------------------------------------------------------------
|
| The metadata factory class name, just change it if you know what are you
| doing.
|
*/

$config['metadata_class'] = 'Mapping\Metadata';

/*
|--------------------------------------------------------------------------
| Mongator Models input path
|--------------------------------------------------------------------------
|
| The input path of the classes, A valid dir with YAML definitions of the
| config classes, you must save the YAMLs config classes in this path.
|
*/

$config['models_input'] = __DIR__ . '/../../../../app/schema/';

/*
|--------------------------------------------------------------------------
| Mongator Models output path
|--------------------------------------------------------------------------
|
| The output path of the classes, just change it if you know what are you
| doing.
|
*/

$config['models_output'] = __DIR__ . '/../../../../app/models/';

/*
|--------------------------------------------------------------------------
| Mongator Extensions
|--------------------------------------------------------------------------
|
| The extensions allow you to add functionalities to documents,
| repositories, queries, in an extremely flexible way. It is also very
| amusing and easy. Just add the instances of the extensions.
|
*/

$config['extensions'] = array();

return $config;
