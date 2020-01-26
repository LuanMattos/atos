<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Us_usuarios_model extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        $this->set_table_index("_id");
        $this->set_table("us_usuarios");
    }
    public function data_user_by_session($data_session = NULL){
        if(!$data_session || empty($data_session)){
            $this->response('error',["msg"=>"Erro ao carregar dados de sessão"]);
            exit();
        }
        $data   = $this->mongodb->atos->us_usuarios->find(['login' => $data_session['login']]);

        foreach($data as $row){
            return $row;
        }
        return false;
    }

}
