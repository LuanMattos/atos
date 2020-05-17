<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Un_cadastro_usuarios_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->set_table_index("codigo");
        $this->set_table("usuarios");
    }



}
