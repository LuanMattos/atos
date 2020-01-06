<?php

class Shell extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->servidor_imagens();
    }
    public function index(){

    }
    /**
     * Monta o servidor
    **/
    public function servidor_imagens(){
        shell_exec('mkdir ../imagens');
        shell_exec('chmod -R 777 ../imagens');
        $this->response("success","Imagens ok");

    }
    public function rm_rf(){
//        rm -rf

    }


}
