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
        $datapost   = (object)$this->input->post(NULL,TRUE);

//        $data['all_users'] = $this->$this->Us_usuarios_model->all_user(
//            NULL,
//            $orderby    = 'us.codigo',
//            $direction  = 'DESC',
//            $limit      = 10,
//            $offset     = $datapost->offset,
//            $result     = "array"
//        );
        $find                   = $this->mongodb->atos->us_usuarios->find([],['limit'=>10, 'skip'=>(integer)$datapost->offset,'sort'=>['_id'=>1]]);
        $data['all_users']      = [];
        foreach($find as $row){
            array_push($data['all_users'],$row);
        }


//        $data_user    = $this->session->get_userdata();
//        $get_usuario  = reset($this->Us_usuarios_model->getWhere(['login'=>$data_user['login']]));
//
//        $us_storage_img_profile = $this->mongodb->atos->us_storage_img_profile;
//        $path_profile_img       = $us_storage_img_profile->find(['codusuario'=>$get_usuario['codigo']]);
//        $path                   = [];
//
//        foreach($path_profile_img as $row){
//            $path       =  $row['server_name'] . $row['bucket'] . '/' . $row['folder_user'] . '/' . $row['name_file'];
//
//            $data_img   = [
//                'codigo'    => $row['codusuario'],
//                'path'      => $path
//            ];
//
//        }
//
//        if(empty($get_usuario)){
//            redirect();
//            exit();
//        }
//        $path              = $this->Us_storage_img_profile_model->get_img_profile($get_usuario);
        $this->response("success",compact("data","path","data_img"));

    }



}
