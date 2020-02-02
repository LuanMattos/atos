<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Us_amigos_model extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        $this->set_table_index("_id");
        $this->set_table("us_amigos");
    }
    public function get_amigos_by_id($param){

        $full   = $this->mongodb->atos->us_amigos->find(['$or' => [
            ["codamigo"     => $param['_id']],
            ["codusuario"   => $param['_id']]
        ]]);
        $result = $full->toArray();


        foreach ($result as $row){
            if($row['codusuario'] === $param['_id']){
                    unset($row['codusuario']);
            }

        }

    }

}
