<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Unico extends SI_Controller {
    public function __construct(){
        parent::__construct();
        $this->menu();
    }

    public function index(){
    }

    public function logout(){
        $this->session->sess_destroy();
        redirect();
    }

}
