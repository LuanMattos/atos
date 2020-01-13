<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Area_a extends SI_Controller
{

    public function __construct(){
        parent::__construct();
        $this->load->model("Usuarios_model");
        $this->load->model("location/Location_user_model");
        $this->load->model('storage/img/Us_storage_img_profile_model');
        $this->output->enable_profiler(FALSE);
        $this->load->helper("cookie");
        $this->load->helper("url");

    }
    public function index(){

    }
    public function get_img_profile(){
        $data_user    = $this->session->get_userdata();
        $get_usuario  = reset($this->Usuarios_model->getWhere(['login'=>$data_user['login']]));

        if(empty($get_usuario)){
            redirect();
            exit();
        }
        $path                 = $this->Us_storage_img_profile_model->get_img_profile($get_usuario);
        $location             = reset($this->Location_user_model->getWhere(['codusuario'=>$get_usuario['codigo']]));
        $pais_cidade['nome']  = explode(',',$location['formatted_address_google_maps']);
        $data                 = $this->Usuarios_model->getWhere(["login"=>$get_usuario['login']]);

        if(count($data)){
            $dados = reset($data);
        }

        $this->response("success",compact("dados","path","pais_cidade"));
    }

}
