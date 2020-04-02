<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_msg extends Home_Controller
{

    public function __construct(){
        parent::__construct();
        $this->load->model("Us_usuarios_model");
        $this->load->model("dashboard_msg/Msg_usuarios_model");
        $this->load->model("account/Us_usuarios_conta_model");
        $this->load->model("location/Us_location_user_model");
        $this->output->enable_profiler(FALSE);
        $this->load->helper("cookie");
        $this->load->helper("url");

    }

    public function index(){
        $data_s = $this->session->get_userdata();

        if(!isset($data_s['logado'])){
            $this->session->sess_destroy();
            redirect();
        }else{
            if(!empty($data_s)){
                $data = $this->Us_usuarios_model->getWhereMongo(['login'=>$data_s['login']]);
//                debug($data);
//                $this->load->view("area_a/index");
                $this->load->view("dashboard_msg/index");

            }
        }

    }
    public function get_msg( $external = false){
        $usuario_session = $this->data_user();
        $id         = $this->input->post("id",true);
        $login_post      = $this->input->post("login",true);
        $login           = $usuario_session['login'];

        if( $login_post ){
            $login = $login_post;
        }
        $usuario    = reset($this->Us_usuarios_model->getWhereMongo( ['login' =>  $login] ) );
        $usuario_local    = reset($this->Us_usuarios_model->getWhereMongo( ['login' =>  $usuario_session['login']] ) );

        //vai cair por terra, no geral, todos que forem external, terão na URL apenas o email por motivos de segurança
        if( $external ){
            $usuario = reset($this->Us_usuarios_model->getWhereMongo( ['_id' => $id ] ) );
        }

//        $rows = $col->find(array('nome' => array ('$all' => array(new MongoRegex('/Ubuntu/')))));

        $msg_usuario_local    =  reset($this->Msg_usuarios_model->getWhereMongo( ['codusuario'=>$usuario_local['_id']]));
        $data = [];
        //mensagens
        foreach ($msg_usuario_local['msg'] as $key=>$msg){
            if(reset($msg['codusuario']) === $usuario['_id']){
                array_push($data,$msg);
            }
        }
        $resourceId = reset($this->Msg_usuarios_model->getWhereMongo( ['codusuario'=>$usuario['_id'] ] ));

        $find_img      =  reset($this->Us_storage_img_profile_model->getWhereMongo(['codusuario'=>$usuario['_id']],$orderby = "created_at",$direction =  -1,$limit = NULL,$offset = NULL));
        $img_profile   =  !empty($find_img['server_name'])?$find_img['server_name'] . $find_img['bucket'] . '/' . $find_img['folder_user'] . '/' . $find_img['name_file']:false;
        $usuario = [
            'id'=>$usuario['_id'],
            'nome' => $usuario['nome'],
            'sobrenome' => $usuario['sobrenome'],
            'img_profile' => $img_profile,
            'login' => $usuario['login'],
            'channel' => $resourceId['resourceId']
        ];
        $this->response('success',compact('data','usuario'));
    }
    public function get_msg_menu(){
        $user = (object)$this->data_user();
        $data  =  reset( $this->mongodb->atos->msg_usuarios->find( ['codusuario'=>$user->_id],['projection'=>['msg'=>['$slice'=>-3]]])->toArray() );
        if( $data ){
            foreach($data['msg'] as $row){
                $user                   = reset( $this->Us_usuarios_model->getWhereMongo(['_id'=>reset($row['codusuario'])],$orderby = "created_at",$direction =  -1,$limit = NULL,$offset = NULL) );
                $row['name']            = ucfirst( $user['nome'] ) . " " . ucfirst( $user['sobrenome'] );
                $path                   = reset( $this->Us_storage_img_profile_model->getWhereMongo(['codusuario'=>reset($row['codusuario'])],$orderby = "created_at",$direction =  -1,$limit = NULL,$offset = NULL));
                $row['img_profile']     = !empty( $path['server_name'])?$path['server_name'] . $path['bucket'] . '/' . $path['folder_user'] . '/' . $path['name_file']:false;

                $dias = 0;

                if( !empty( $row['created_at'] ) ) {
                    $date = new DateTime($row['created_at']);
                    $now  = new DateTime();


                    $dias = $date->diff($now)->format("%d dia(s), %h hora(s) e %i minuto(s)");
                }

                $row['dias'] = $dias;
            }
        }

        $this->response('success',compact('data'));
    }

}
