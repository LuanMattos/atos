<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_msg extends Home_Controller
{

    public function __construct(){
        parent::__construct();
        $this->load->model("Us_usuarios_model");
        $this->load->model("dashboard_msg/Msg_usuarios_model");
        $this->load->model("account/Us_usuarios_conta_model");
        $this->load->model("location/Us_location_user_model");
        $this->output->enable_profiler(FALSE);
        $this->load->helper("cookie");
        $this->load->helper("url");

    }

    public function index(){
        $data_s = $this->session->get_userdata();

        if(!isset($data_s['logado'])){
            $this->session->sess_destroy();
            redirect();
        }else{
            if(!empty($data_s)){
                $data = $this->Us_usuarios_model->getWhereMongo(['login'=>$data_s['login']]);
//                debug($data);
//                $this->load->view("area_a/index");
                $this->load->view("dashboard_msg/index");

            }
        }

    }
    public function get_msg_local(){
        $usuario_session = $this->data_user();
        $usuario = reset($this->Us_usuarios_model->getWhereMongo( ['login' => $usuario_session['login'] ] ) );
        $data    = $this->Msg_usuarios_model->getWhereMongo( ['_id'=>$usuario['_id']] );

        $find_img               =  reset($this->Us_storage_img_profile_model->getWhereMongo(['codusuario'=>$usuario['_id']],$orderby = "created_at",$direction =  -1,$limit = NULL,$offset = NULL));
        $img_profile   =  !empty($find_img['server_name'])?$find_img['server_name'] . $find_img['bucket'] . '/' . $find_img['folder_user'] . '/' . $find_img['name_file']:false;
        $usuario_local = [
            'nome' => $usuario['nome'],
            'sobrenome' => $usuario['sobrenome'],
            'img_profile' => $img_profile
        ];
        $this->response('success',compact('data','usuario'));
    }

}
