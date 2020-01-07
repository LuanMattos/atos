<?php
class Shell extends CI_Controller{

    public function __construct(){
        parent::__construct();
    }
    public function index(){

    }
    public function php(){

        shell_exec('sudo apt-get install php-xml');
    }


}
