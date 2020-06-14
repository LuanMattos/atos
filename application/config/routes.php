<?php
defined('BASEPATH') OR exit('No direct script access allowed');



$route['sign/up'] = 'Home/register';
$route['settings'] = 'account_settings/Account_settings/index';
$route['home'] = 'Home/index';
$route['mydashboard'] = 'dashboard_activity/Dashboard_activity/local';
$route['dashboard'] = 'dashboard_activity/Dashboard_activity/index';
$route['theirdashboard/(:any)'] = 'dashboard_activity/Dashboard_activity/external/$1';
$route['zerar_menu'] = 'area_a/Area_a/zerar_notificacoes_menu';
$route['data_menu'] = 'area_a/Area_a/data_menu';


$route['404_override'] = 'Home/error_404';

$route['default_controller'] = 'Home';
$route['translate_uri_dashes'] = FALSE;

