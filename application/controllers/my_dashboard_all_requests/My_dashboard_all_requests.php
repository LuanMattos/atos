<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class My_dashboard_all_requests extends SI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model("Us_usuarios_model");
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
            $this->load->view("area_a/index");
            if(!empty($data_s)){
                $data = $this->Us_usuarios_model->getWhere(["login"=>$data_s['login']]);
                if(count($data)){
                    $dados = reset($data);
                }
                $location            = reset($this->Us_location_user_model->getWhere(['codusuario'=>$dados['codigo']]));
                $pais_cidade['nome'] = explode(',',$location['formatted_address_google_maps']);
                $this->load->view("my_dashboard_all_requests/index",compact("dados","pais_cidade"));

            }
        }

    }

}
