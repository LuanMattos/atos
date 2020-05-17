<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Un_cadastro_unificado_model extends CI_Model {

    public $validate = array(array(
            'field' => 'login',
            'label' => 'Login',
            'rules' => 'required'
        ), array(
            'field' => 'senha',
            'label' => 'Senha',
            'rules' => 'required',
            'errors' => array(
                'required' => 'O campo senha é obrigatório',
            ),),
    );
    public function __construct()
    {
        parent::__construct();
        $this->set_table_index("codigo");
        $this->set_table("da_dados_globais");
        //tabela apenas para teste - original = un_cadastro_unificado
    }



}
