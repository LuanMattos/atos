<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pessoas extends Home_Controller
{
    private $data_session;

    public function __construct(){
        parent::__construct();
        $this->output->enable_profiler(FALSE);
        $this->load->model('storage/img/Us_storage_img_profile_model');
        $this->load->model("location/Us_location_user_model");
        $this->load->model("usuarios/Us_amigos_model");
        $this->load->model("Us_usuarios_model");
        $this->load->model("usuarios/Us_amigos_solicitacoes_model");
        $this->data_session = $this->session->get_userdata();
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
        $user_session   = $this->Us_usuarios_model->data_user_by_session($data_user);
        $amigos         = reset($this->Us_amigos_model->getWhereMongo(['_id'=>$user_session['_id']]));
        $ids = [0=>$user_session['_id']];

        foreach($amigos['amigos'] as $row_amizades){
            array_push($ids,reset($row_amizades['_id']));


        }

        $find           = $this->mongodb->atos->us_usuarios->find( ["_id"=>['$nin' => $ids]],['limit'=>10, 'skip'=>(integer)$datapost->offset,'sort'=>['_id'=>-1]]);

        $data['all_users']      = [];
        $row['img_profile']     = false;

        foreach($find as $key_top=>$row){

            $find_img           =  reset($this->Us_storage_img_profile_model->getWhereMongo(['codusuario'=>$row['_id']],$orderby = "created_at",$direction =  -1,$limit = NULL,$offset = NULL));
            $row['img_profile'] =  $find_img['server_name'] . $find_img['bucket'] . '/' . $find_img['folder_user'] . '/' . $find_img['name_file'];

            array_push($data['all_users'],$row);

        $options                        = ["sort" => ["created_at" => 1]];
        $us_storage_img_cover           = $this->mongodb->atos->us_storage_img_cover;
        $us_amigos_solicitacoes         = $this->mongodb->atos->us_amigos_solicitacoes;
        $solicitacoes                   = $us_amigos_solicitacoes->find(['codusuario'=>$user_session['_id'],'codamigo'=>$row['_id']]);

        $row['img_cover']               = false;
        $row['sol']                     = false;
        $row['amigo_solicitante']       = false;

            foreach($solicitacoes as $rol_sol) {
                $row['sol'] = true;
            }



            //Verifica se usuário logado possui solicitação de amizade
            $solicitacoes_usuariologado     = $us_amigos_solicitacoes->find(['codamigo'=>$user_session['_id']]);
            $data_solicitacao               = $solicitacoes_usuariologado->toArray();

            foreach($data_solicitacao as $row_solicitacao){
                if($row['_id'] === $row_solicitacao['codusuario']){

                        $row['amigo_solicitante'] = true;
                }
            }


            $path_cover_img         = $us_storage_img_cover->find(['codusuario'=>$row['_id']],$options);

            foreach($path_cover_img as $row_path_cover){
                $row['img_cover']       =  $row_path_cover['server_name'] . $row_path_cover['bucket'] . '/' . $row_path_cover['folder_user'] . '/' . $row_path_cover['name_file'];

            }
        }

        $this->response("success",compact("data","path","data_img"));
    }
    public function get_img_menu_pessoas(){
        $usuario_logado = $this->data_user();
        $ids            = [0=>$usuario_logado['_id']];

        $data['all_users']      = [];
        $amigos                 = reset($this->Us_amigos_model->getWhereMongo(['_id'=>$usuario_logado['_id']]));

        foreach($amigos['amigos'] as $row){

            array_push($ids,reset($row['_id']));
        }

        $amigos_nao = $this->mongodb->atos->us_usuarios->find( ["_id"=>['$nin' => $ids]],['limit'=>10, 'sort'=>['_id'=>-1]]);

        $row['sol'] = false;

        foreach($amigos_nao as $row){
            //se usuario logado enviou solicitacao
            $solicitacoes = $this->Us_amigos_solicitacoes_model->getWhereMongo(['codusuario'=>$usuario_logado['_id'],'codamigo'=>$row['_id']]);
            if(count($solicitacoes)){
                $row['sol'] = true;
            }

            $row['img_profile'] = "";
            $find_img           =  reset($this->Us_storage_img_profile_model->getWhereMongo(['codusuario'=>$row['_id']],$orderby = "created_at",$direction =  -1,$limit = NULL,$offset = NULL));
            $row['img_profile'] =  $find_img['server_name'] . $find_img['bucket'] . '/' . $find_img['folder_user'] . '/' . $find_img['name_file'];
            array_push($data['all_users'],$row);

        }


        $this->response("success",compact("data"));

    }



}
