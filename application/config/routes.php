<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//login
$route['john34Gsiremailcom/(:any)'] = 'Login/verify_pass_index';
$route['confirm_password'] = 'Login/save_pass';
$route['passrecovery'] = 'Login/renew_senha';
$route['linkrenew'] = 'Login/send_link_renew_pass';
$route['go'] = 'Login/index';

//area_a/Area_a
$route['getimage'] = 'area_a/Area_a/get_img';

//pessoas/Pessoas
$route['getimgmenu'] = 'pessoas/Pessoas/get_img_menu_pessoas';
$route['dfu'] = 'pessoas/Pessoas/data_full_user';

//pessoas/Amigos
$route['add'] = 'pessoas/Amigos/add_person';
$route['accept'] = "pessoas/Amigos/aceitar_pessoa";
$route['requestsuserlimit'] = "pessoas/Amigos/solicitacoes_by_usuario_limit";
$route['friendchat'] = "pessoas/Amigos/full_amigos_chat";
$route['abul'] = "pessoas/Amigos/amigos_by_usuario_limit";
$route['ff'] = "pessoas/Amigos/full_amigos";
$route['da'] = "pessoas/Amigos/delete_amizade";

//home
$route['getstorageimg'] = 'Home/get_storage_img';
$route['gsi'] = 'Home/get_storage_img';
$route['deletetimeline'] = 'home/Home/delete_time_line';
$route['dt'] = 'home/Home/delete_time_line';
$route['addtimeline'] = 'home/Home/add_time_line';
$route['computelike'] = 'home/Home/compute_like';
$route['cl'] = 'home/Home/compute_like';
$route['search'] = 'home/Home/buscar';
$route['home'] = 'Home/index';
$route['sign/up'] = 'Home/register';

//dashboard_activity
$route['dashboard'] = 'dashboard_activity/Dashboard_activity/index';
$route['mydashboard'] = 'dashboard_activity/Dashboard_activity/local';
$route['external'] = 'dashboard_activity/Dashboard_activity/external';
$route['theirdashboard/(:any)'] = 'dashboard_activity/Dashboard_activity/external/$1';
$route['uip'] = "dashboard_activity/Dashboard_activity/update_img_profile";
$route['uic'] = "dashboard_activity/Dashboard_activity/update_img_cover";

//dashboard_msg
$route['view_full_messages'] = 'dashboard_msg/Dashboard_msg/index';
$route['get_anotacoes'] = 'dashboard_msg/Dashboard_msg/get_anotacoes_by_user';
$route['salvar_notas'] = 'dashboard_msg/Dashboard_msg/salvar_anotacoes';
$route['excluir_nota'] = 'dashboard_msg/Dashboard_msg/excluir_anotacao';
$route['msgmenu'] = "dashboard_msg/Dashboard_msg/get_msg_menu";
$route['getmsg'] = "dashboard_msg/Dashboard_msg/get_msg";
$route['getmsg/(:any)'] = "dashboard_msg/Dashboard_msg/get_msg/$1";

//area_a
$route['zerar_menu'] = 'area_a/Area_a/zerar_notificacoes_menu';
$route['data_menu'] = 'area_a/Area_a/data_menu';
$route['datauserl'] = 'area_a/Area_a/data_user_local';

//invite
$route['invite'] = 'invite/Invite/index';
$route['invitesend'] = 'invite/Invite/enviar';

//settings
$route['settings'] = 'account_settings/Account_settings/index';
$route['asl'] = 'account_settings/Account_settings/acao_salvar_localizacao';


$route['404_override'] = 'Home/error_404';

$route['default_controller'] = 'Home';
$route['translate_uri_dashes'] = FALSE;

