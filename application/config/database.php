<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$active_group   = 'default';
$query_builder  = TRUE;

$db['default']  = [
	'dsn'	        => '',
	'hostname'      => 'localhost',
	'username'      => 'postgres',
	'password'      => 'k2l9g3v1',
	'database'      => 'postgres',
	'dbdriver'      => 'postgre',
	'dbprefix'      => '',
	'pconnect'      => FALSE,
	'db_debug'      => (ENVIRONMENT !== 'production'),
	'cache_on'      => FALSE,
	'cachedir'      => '',
	'char_set'      => 'utf8',
	'dbcollat'      => 'utf8_general_ci',
	'swap_pre'      => '',
	'encrypt'       => FALSE,
	'compress'      => FALSE,
	'stricton'      => FALSE,
	'failover'      => array(),
	'save_queries'  => TRUE
];

//$config['mongodb'] = [
//    'hostname'      => 'localhost',
//    'port'          => '27017',
//    'username'      => 'atos',
//    'password'      => 'k2l9g3v1',
//    'database'      => 'atos'
//];



