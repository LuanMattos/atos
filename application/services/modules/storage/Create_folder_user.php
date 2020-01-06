<?php

namespace Modules\Storage\Create_folder_user;

class Create_folder_user extends \CI_Model
{

    public function __construct(){

    }

    public function index($data){

        if (!empty($data['codigo'])) {

            $this->load->model('storage/Us_storage_model');
            $validate           = reset($this->Us_storage_model->getWhere(['codusuario' => $data['codigo']]));
            $validate_usuarios  = reset($this->Usuarios_model->getWhere(["codigo" => $data['codigo']]));


            if($validate_usuarios['create_folder_img'] !== 't') {

                if (empty($validate)) {
                    $create = $this->create_folder($data);

                    $data_save = [
                        "name_folder_user"  => $create,
                        "codusuario"        => $data['codigo']
                    ];

                    $set    = ['create_folder_img'  => 't'];
                    $where  = ["codigo"             => $data['codigo']];

                    $this->db->update("usuarios", $set, $where);

                    $this->Us_storage_model->save($data_save);

                }
            }
        }
    }

    public function create_folder($data){

        $name         = $data['login'] . date('Y-m-d H:i:s');
        $search       = ["(", ")", ".", "-", " ", "X", "*", "!", "@", "'", "´", ",", "+", ":"];
        $name_replace = str_replace($search, "", $name);
        $uuid         = uniqid(rand());
        $name         = $uuid . $name_replace;

        shell_exec('mkdir ../imagens/' . $name);
        shell_exec('chmod -R 777 ../imagens/' . $name);
        shell_exec('mkdir ../imagens/'. $name . '/img');
        shell_exec('chmod -R 777 ../imagens/' . $name. '/img');

        return $name;
    }
}
