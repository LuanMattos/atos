<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_msg extends Home_Controller
{

    public function __construct(){
        parent::__construct();
        $this->load->model("Us_usuarios_model");
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

}
