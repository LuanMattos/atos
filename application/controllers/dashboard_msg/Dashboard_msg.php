<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_msg extends SI_Controller
{

    public function __construct(){
        parent::__construct();
        $this->load->model("Usuarios_model");
        $this->load->model("account/home/Account_home_model");
        $this->load->model("location/Location_user_model");
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
                $this->load->view("area_a/index");
                $data = $this->Usuarios_model->getWhere(["login"=>$data_s['login']]);
                if(count($data)){
                    $dados = reset($data);
                }
                $location            = reset($this->Location_user_model->getWhere(['codusuario'=>$dados['codigo']]));
                $pais_cidade['nome'] = explode(',',$location['formatted_address_google_maps']);
                $this->load->view("dashboard_msg/index",compact("dados","pais_cidade"));

            }
        }

    }

}
