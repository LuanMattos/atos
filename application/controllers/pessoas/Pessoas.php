<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pessoas extends SI_Controller
{

    public function __construct(){
        parent::__construct();
        $this->output->enable_profiler(FALSE);
        $this->load->model("account/home/Account_home_model");
        $this->load->model("location/Location_user_model");
        $this->load->model("Usuarios_model");
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
                $location            = reset($this->Location_user_model->getWhere(['codusuario'=>$dados['codigo']]));
                $pais_cidade['nome'] = explode(',',$location['formatted_address_google_maps']);
                $all_users = $this->Usuarios_model->all();



                $this->load->view("pessoas/full",compact("dados","pais_cidade","all_users"));

            }
        }
    }
    public function data_full_user(){

        $all_users = $this->Usuarios_model->all();
        $this->response("success",compact("all_users"));

    }



}
