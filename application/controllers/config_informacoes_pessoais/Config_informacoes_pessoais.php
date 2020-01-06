<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Config_informacoes_pessoais extends SI_Controller
{

    public function __construct(){
        parent::__construct();
        $this->load->model("Usuarios_model");
        $this->load->model("account/home/Account_home_model");
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
                $data = $this->Usuarios_model->getWhere(["login"=>$data_s['login']]);
                if(count($data)){
                    $dados = reset($data);
                }
                $this->load->view("config_informacoes_pessoais/index",compact("dados"));

            }
        }

    }

}
