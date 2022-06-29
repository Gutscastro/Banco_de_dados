<?php


defined('BASEPATH') or exit('No direct script access allowed');
$active_group = 'default';
$db[$active_group] = array(
	'dsn'    => '',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => true,
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


$db['default']['hostname'] = 'localhost';
$db['default']['username'] = 'ticket';
$db['default']['password'] = 'senhaForte#123';
$db['default']['database'] = 'ticket';


