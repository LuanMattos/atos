<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$active_group   = 'default';
$query_builder  = TRUE;

if(ENVIRONMENT === 'production'){
    $hostname = 'www.atos.click';
}else{
    $hostname = 'localhost';
}

$db['default'] = array(
    'dsn'	   => '',
    'hostname' => $hostname,
    'port'     => '5432',
    'username' => 'postgres',
    'password' => 'eFdarksadfw4r54af4fd4a54h2fasfdg',
    'database' => 'atos',
    'dbdriver' => 'postgre',
    'dbprefix' => '',
    'pconnect' => FALSE,
//	'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);