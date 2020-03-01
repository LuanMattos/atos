<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$active_group   = 'default';
$query_builder  = TRUE;

if(ENVIRONMENT === 'production'){
    $hostname = 'www.atos.click';
}else{
    $hostname = '127.0.0.1';
}
$db['default']  = [
	'dsn'	        => '',
	'hostname'      => $hostname,
	'username'      => 'postgres',
	'port'          => '5432',
	'password'      => 'eFdarksadfw4r54af4fd4a54h2fasfdg',
	'database'      => 'atos',
	'dbdriver'      => 'postgre',
	'dbprefix'      => '',
	'pconnect'      => FALSE,
//	'db_debug'      => (ENVIRONMENT !== 'production'),
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


$config['mongodb'] = [
    'hostname'      => 'mongo',
    'port'          => '27017',
    'username'      => 'atos',
    'password'      => 'fsjf34h4fshdfajb4hjrf5t554456afarg5sd2fdads2fADsdf',
    'database'      => 'atos'
];
