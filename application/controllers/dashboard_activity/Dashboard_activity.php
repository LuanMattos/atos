<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_activity extends SI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model('Us_usuarios_model');
        $this->load->model('location/Us_location_user_model');
        $this->output->enable_profiler(FALSE);
        $this->load->helper("cookie");
        $this->load->helper("url");
        $this->verifica_sessao();

    }
    public function index(){
        $data_s = $this->session->get_userdata();

            if(!empty($data_s)){
                $dados               = $this->Us_usuarios_model->data_user_by_session($data_s);
                $location            = $this->Us_location_user_model->data_location_by_id($dados['_id']);
                $dados['address']    = $location['formatted_address_google_maps'];
                $this->load->view("dashboard_activity/index",compact("dados"));
            }
    }
    public function update_img_profile()
    {   $this->load->library('amazon/S3');
        $data_file = $_FILES['fileimagemprofile'];


        if (empty($data_file)) {
            $this->response(['error', ['msg' => 'Selecione um a imagem!']]);
        } else {

            if ($data_file->size > 9242880) {
                $this->response('error', ['msg' => 'Tamanho de arquivo deve ser de no máximo 5MB']);
                exit();
            }
            $bucket_name    = 'atos.click';
            $s3             = new S3();
            $hash           = uniqid(rand()) . date("Y-m-d H:i:so");
            $data_user      = $this->session->get_userdata();
            $find_usuario   = $this->mongodb->atos->us_usuarios->find(['login' => $data_user['login']]);

            foreach($find_usuario as $get_usuario){

            $search              = ["(", ")", ".", "-", " ", "X", "*", "!", "@", "'", "´", ",", "+", ":"];
            $name_replace        = str_replace($search, "", $hash);
            $name_file           = $name_replace . md5($get_usuario['login']);
            $data_file['name']   = $name_file;

            $s3->putBucket($bucket_name);
            $name_folder_user = $get_usuario['nome'] . md5($get_usuario['login']);

            if ($s3->putObjectFile($data_file['tmp_name'], $bucket_name, $name_folder_user . '/' . $name_file, S3::ACL_PUBLIC_READ)) {

                $us_storage_img = $this->mongodb->atos->us_storage_img_profile;
                $us_storage_img->insertOne([
                    'server_name'   => 'https://s3.amazonaws.com/',
                    'bucket'        => $bucket_name,
                    'folder_user'   => $name_folder_user,
                    'name_file'     => $name_file,
                    'codusuario'    => $get_usuario['_id'],
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
  }
}
