<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Term_conditions extends SI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model("Usuarios_model");
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
                    $data = reset($data);
                }
                $this->load->view("term_conditions/index",$data);

            }
        }

    }

}
