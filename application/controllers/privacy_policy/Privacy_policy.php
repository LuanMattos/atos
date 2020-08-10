<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Privacy_policy extends SI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model("Us_usuarios_model");
        $this->output->enable_profiler(FALSE);
        $this->load->helper("cookie");
        $this->load->helper("url");

    }

    public function index(){
        $data_s = $this->session->get_userdata();
       $this->load->view('privacy_policy/index');



    }

}
