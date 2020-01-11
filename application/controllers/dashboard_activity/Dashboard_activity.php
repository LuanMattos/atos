<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_activity extends SI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model('Usuarios_model');
        $this->output->enable_profiler(FALSE);
        $this->load->helper("cookie");
        $this->load->helper("url");

    }
    public function update_img_profile()
    {   $this->load->library('amazon/S3');
        $data_file = $_FILES['fileimagemprofile'];

        if (empty($data_file)) {
            $this->response(['error', ['msg' => 'Selecione um a imagem!']]);
        } else {

            if ($data_file->size > 5242880) {
                $this->response('error', ['msg' => 'Tamanho de arquivo deve ser de no máximo 5MB']);
                exit();
            }
            $bucket_name    = 'atos.click';
            $s3             = new S3();
            $hash           = uniqid(rand()) . date("Y-m-d H:i:so");
            $data_user      = $this->session->get_userdata();
            $get_usuario    = reset($this->Usuarios_model->getWhere(['login' => $data_user['login']]));

            if (empty($get_usuario)) {
                redirect();
                exit();
            }
            $search = ["(", ")", ".", "-", " ", "X", "*", "!", "@", "'", "´", ",", "+", ":"];
            $name_replace = str_replace($search, "", $hash);
            $name_file = $name_replace . md5($get_usuario['login']);
            $data_file['name'] = $name_file;

            $s3->putBucket($bucket_name);
            $name_folder_user = $get_usuario['nome'] . md5($get_usuario['login']);

            if ($s3->putObjectFile($data_file['tmp_name'], $bucket_name, $name_folder_user . '/' . $name_file, S3::ACL_PUBLIC_READ)) {

                $us_storage_img = $this->mongodb->atos->us_storage_img_profile;
                $us_storage_img->insertOne([
                    'server_name'   => 'https://s3.amazonaws.com/',
                    'bucket'        => $bucket_name,
                    'folder_user'   => $name_folder_user,
                    'name_file'     => $name_file,
                    'codusuario'    => $get_usuario['codigo'],
                    'created_at'    => date('Y-m-d H:i:s'),
                    'updated_at'    => date('Y-m-d H:i:s'),

                ]);
                $path = 'https://s3.amazonaws.com/' . $bucket_name . '/' . $name_folder_user . '/' .  $name_file;
                $this->response('success', compact('path'));
            }else{
                $this->response('error',['msg'=>'Erro ao baixar a imagem para o servidor!']);
            }

        }
    }
    public function get_img_profile(){
        $data_user    = $this->session->get_userdata();
        $get_usuario  = reset($this->Usuarios_model->getWhere(['login'=>$data_user['login']]));

        if(empty($get_usuario)){
            redirect();
            exit();
        }

        $us_storage_img_profile = $this->mongodb->atos->us_storage_img_profile;

        $options            = ["sort" => ["created_at" => 1]];
        $path_profile_img   = $us_storage_img_profile->find(['codusuario'=>$get_usuario['codigo']],$options);
        $path               = [];

        foreach($path_profile_img as $row){
            $path    =  $row['server_name'] . $row['bucket'] . '/' . $row['folder_user'] . '/' . $row['name_file'];

        }
        $this->response('success',compact('path'));
    }


}
