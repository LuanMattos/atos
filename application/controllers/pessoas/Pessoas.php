<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pessoas extends Home_Controller
{

    public function __construct(){
        parent::__construct();
        $this->output->enable_profiler(FALSE);
        $this->load->model('storage/img/Us_storage_img_profile_model');
        $this->load->model("location/Us_location_user_model");
        $this->load->model("Us_usuarios_model");
    }
    public function index(){

        $data_s             = $this->session->get_userdata();

        if(!isset($data_s['logado'])){
            $this->session->sess_destroy();
            redirect();
        }else{
            if(!empty($data_s)){
                $dados      = $this->Us_usuarios_model->data_user_by_session($data_s);
                $address    = $this->Us_location_user_model->data_location_by_id($dados['_id']);
                if(!empty($address)):
                    $dados['address'] = $address['formatted_address_google_maps'];
                endif;
                $data['all_users'] = $this->Us_usuarios_model->all_users(10);

                $this->load->view("pessoas/full", compact("dados"));

            }
        }
    }

    public function data_full_user(){
        $datapost       = (object)$this->input->post(NULL,TRUE);
        $data_user      = $this->session->get_userdata();

        $find           = $this->mongodb->atos->us_usuarios->find(['email' => ['$ne' => $data_user['login']]],['limit'=>10, 'skip'=>(integer)$datapost->offset,'sort'=>['_id'=>-1]]);

        $data['all_users']      = [];
        foreach($find as $row){
            array_push($data['all_users'],$row);

        $us_storage_img_profile = $this->mongodb->atos->us_storage_img_profile;
        $path_profile_img       = $us_storage_img_profile->find(['_id'=>$row['_id']]);
        $path                   = [];

        foreach($path_profile_img as $row_path){
            $row['img_profile']       =  $row_path['server_name'] . $row_path['bucket'] . '/' . $row_path['folder_user'] . '/' . $row_path['name_file'];

            }
        }

        $this->response("success",compact("data","path","data_img"));

    }
    public function get_img_menu_pessoas(){
        $data_user      = $this->session->get_userdata();

        $find           = $this->mongodb->atos->us_usuarios->find(['email' => ['$ne' => $data_user['login']]],['limit'=>7, 'sort'=>['_id'=>-1]]);

        $data['all_users']      = [];

        foreach($find as $row){
            array_push($data['all_users'],$row);

            $us_storage_img_profile = $this->mongodb->atos->us_storage_img_profile;
            $path_profile_img       = $us_storage_img_profile->find(['_id'=>$row['_id']]);

            foreach($path_profile_img as $row_path){
                $row['img_profile']       =  $row_path['server_name'] . $row_path['bucket'] . '/' . $row_path['folder_user'] . '/' . $row_path['name_file'];

            }
        }

        $this->response("success",compact("data"));

    }



}
