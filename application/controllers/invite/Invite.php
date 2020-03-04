<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invite extends Home_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model("Us_usuarios_model");
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

                $this->load->view("invite/index");

            }
        }

    }

}
