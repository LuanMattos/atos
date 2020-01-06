<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios_model extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        $this->set_table_index("codigo");
        $this->set_table("usuarios");
    }

    public function login($usuario){
        $results = FALSE;
        $user = $this->db->get_where('usuarios', array('login' => $usuario));
        if ($user->num_rows() > 0) {

            $results = $user->result_array();
        }
        return $results;

    }
    public function validate_login($login){
        return $this->db->query("SELECT ah.verification_ok as verification,
                                            us.email_hash as email_hash 
                                      FROM usuarios us
                                    LEFT JOIN account_home ah on us.codigo = ah.codusuarios
                                WHERE login = '$login' ")->result_array();
    }

}
