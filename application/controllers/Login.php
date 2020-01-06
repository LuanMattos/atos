<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Usuarios_model");
        $this->output->enable_profiler(FALSE);
        $this->load->helper("cookie");
    }

    public function index()
    {
        error_reporting(0);
        ini_set("display_errors",0);
        session_start();

        $this->load->view('index');
        
	}
}
