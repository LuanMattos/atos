<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pessoas extends SI_Controller
{

    public function __construct(){
        parent::__construct();
        $this->output->enable_profiler(FALSE);
        $this->load->model('storage/img/Us_storage_img_profile_model');
        $this->load->model("account/home/Account_home_model");
        $this->load->model("location/Location_user_model");
        $this->load->model("Usuarios_model");
    }
    public function index(){

        $data_s = $this->session->get_userdata();

        if(!isset($data_s['logado'])){
            $this->session->sess_destroy();
            redirect();
        }else{
            if(!empty($data_s)){
                $data = $this->Usuarios_model->getWhere(["login"=>$data_s['login']]);
                if(count($data)){
                    $dados = reset($data);

                }
                $location            = reset($this->Location_user_model->getWhere(['codusuario'=>$dados['codigo']]));
                $pais_cidade['nome'] = explode(',',$location['formatted_address_google_maps']);

                $data['all_users'] = $this->Usuarios_model->getWhere([1=>1],$orderby=NULL,$direction = NULL,$limit = 100,$offset = NULL,$result = "array");

                $this->load->view("pessoas/full",compact("dados","pais_cidade","data"));

            }
        }
    }

    public function data_full_user(){
        $datapost   = (object)$this->input->post(NULL,TRUE);

        $data['all_users'] = $this->Usuarios_model->all_user(
            NULL,
            $orderby    = 'us.updated_at',
            $direction  = 'DESC',
            $limit      = 10,
            $offset     = $datapost->offset,
            $result     = "array"
        );

        $data_user    = $this->session->get_userdata();
        $get_usuario  = reset($this->Usuarios_model->getWhere(['login'=>$data_user['login']]));

        if(empty($get_usuario)){
            redirect();
            exit();
        }
        $path              = $this->Us_storage_img_profile_model->get_img_profile($get_usuario);
        $this->response("success",compact("data","path"));

    }



}
