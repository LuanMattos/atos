<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
	'dsn'	=> '',
	'hostname' => '52.204.82.217',
	'port'     => '5400',
	'username' => 'painel',
	'password' => 'dfsaf435fd4gs46565674dfgs4fs654ts562hg5s4fga',
	'database' => 'painel',
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
