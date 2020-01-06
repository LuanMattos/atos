<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Area_a extends SI_Controller
{

    public function __construct(){
        parent::__construct();
        $this->load->model("Usuarios_model");
        $this->load->model("account/home/Account_home_model");
        $this->output->enable_profiler(FALSE);
        $this->load->helper("cookie");
        $this->load->helper("url");

    }

}
