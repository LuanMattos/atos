<?php
defined('BASEPATH') OR exit('No direct script access allowed');



$route['go'] = 'Login/index';
$route['sign/up'] = 'Home/register';
$route['settings'] = 'account_settings/Account_settings/index';
$route['home'] = 'Home/index';
$route['mydashboard'] = 'dashboard_activity/Dashboard_activity/local';
$route['dashboard'] = 'dashboard_activity/Dashboard_activity/index';
$route['theirdashboard/(:any)'] = 'dashboard_activity/Dashboard_activity/external/$1';
$route['zerar_menu'] = 'area_a/Area_a/zerar_notificacoes_menu';
$route['data_menu'] = 'area_a/Area_a/data_menu';
$route['invite'] = 'invite/Invite/index';
$route['invitesend'] = 'invite/Invite/enviar';
$route['passrecovery'] = 'Login/renew_senha';
$route['linkrenew'] = 'Login/send_link_renew_pass';
$route['john34Gsiremailcom/(:any)'] = 'Login/verify_pass_index';
$route['confirm_password'] = 'Login/save_pass';
$route['view_full_messages'] = 'dashboard_msg/Dashboard_msg/index';
$route['get_anotacoes'] = 'dashboard_msg/Dashboard_msg/get_anotacoes_by_user';
$route['salvar_notas'] = 'dashboard_msg/Dashboard_msg/salvar_anotacoes';

$route['404_override'] = 'Home/error_404';

$route['default_controller'] = 'Home';
$route['translate_uri_dashes'] = FALSE;

