<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Us_storage_model extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        $this->set_table_index("codigo");
        $this->set_table("us_storage");
    }
    public function get_img_usr($where = NULL){

        return $this->db->query("SELECT CASE  WHEN  u.name_folder_user IS NOT  NULL
                                    THEN 'file:///var/www/html/imagens/' || usimg.path_file END AS path
                              FROM usuarios us
                                LEFT JOIN us_storage u          on us.codigo        = u.codusuario
                                LEFT JOIN us_storage_img usimg  on usimg.codstorage = u.codigo where $where")->result();
    }
}
