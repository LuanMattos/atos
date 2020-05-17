<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios_model extends CI_Model{

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
        $this->set_table("usuarios");
    }

    public function login($usuario)
    {
        $results = FALSE;
        $user = $this->db->get_where('usuarios', array('login' => $usuario));
        if ($user->num_rows() > 0) {

            $results = $user->result_array();
        }
        return $results;

    }

}
