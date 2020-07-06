<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_msg extends Home_Controller
{

    public function __construct(){
        parent::__construct();
        $this->load->model("Us_usuarios_model");
        $this->load->model("dashboard_msg/Msg_usuarios_model");
        $this->load->model("dashboard_msg/Anotacoes_usuarios_model");
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
        $data = [];
        $data['msg'] = false;


        if( $login_post ){
            $login = $login_post;
        }
        $usuario    = $this->Us_usuarios_model->getWhereMongo( ['login' =>  $login], "_id",  -1, NULL, NULL,true ) ;
//        $usuario_local    = $this->Us_usuarios_model->getWhereMongo( ['login' =>  $usuario_session['login']], "_id",  -1, NULL, NULL,true );

        //vai cair por terra, no geral, todos que forem external, terão na URL apenas o email por motivos de segurança
        if( $external ){
            $usuario = $this->Us_usuarios_model->getWhereMongo( ['_id' => $id ], "_id",  -1, NULL, NULL,true ) ;
        }

//        $rows = $col->find(array('nome' => array ('$all' => array(new MongoRegex('/Ubuntu/')))));
        $data =  $this->Msg_usuarios_model->getWhereMongo( ['from'=>$usuario['_id'],'to'=>$usuario_session['_id']], "_id",  -1, NULL, NULL,true);

        $find_img      =  $this->Us_storage_img_profile_model->getWhereMongo(['codusuario'=>$usuario['_id']], "created_at", -1, NULL, NULL,TRUE);
        $img_profile   =  !empty($find_img['server_name'])?$find_img['server_name'] . $find_img['bucket'] . '/' . $find_img['folder_user'] . '/' . $find_img['name_file']:false;

        $usuario = [
            'id'=>$usuario['_id'],
            'nome' => $usuario['nome'],
            'sobrenome' => $usuario['sobrenome'],
            'img_profile' => $img_profile,
            'login' => $usuario['login'],
            'idchat' => $usuario['idchat']
        ];
        $this->response('success',compact('data','usuario'));
    }
    public function get_msg_menu(){
        $user = (object)$this->data_user();
        //consulta com limit no subdocumento
        $data  =   $this->mongodb->atos->msg_usuarios->findOne( ['from'=>$user->_id],['projection'=>['msg'=>['$slice'=>-3]]]);

        if( $data ){
            foreach($data['msg'] as $row){
                $user                   = $this->Us_usuarios_model->getWhereMongo(['_id'=>$row['codusuario']],"created_at",-1,NULL, NULL,TRUE) ;
                $row['name']            = ucfirst( $user['nome'] ) . " " . ucfirst( $user['sobrenome'] );
                $path                   = $this->Us_storage_img_profile_model->getWhereMongo(['codusuario'=>$row['codusuario']],"created_at",-1,NULL,NULL,TRUE);
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
    public function get_anotacoes_by_user(){
        $user = (object)$this->data_user();
        $data = $this->Anotacoes_usuarios_model->getWhereMongo(['codusuario'=>$user->_id]);

        $this->response('success',compact('data'));
    }
     public function salvar_anotacoes(){
         $user = (object)$this->data_user();
         $datapost = (object)$this->input->post(NULL,TRUE);

        if( $datapost->title && !empty($datapost->text)) {
            $data = [];
            $data['codusuario'] = $user->_id;
            $data['text'] = $datapost->text;
            $data['title'] = $datapost->title;
            $_id = $this->Anotacoes_usuarios_model->save_mongo($data);
            $data['_id'] = reset($_id);
            $this->response('success', compact('data'));
        }
     }
     public function excluir_anotacao(){
        $id = $this->input->post("id",TRUE);
        $this->Anotacoes_usuarios_model->deleteWhereMongo(['_id'=>new \MongoDB\BSON\ObjectId($id[0])]);
        $this->response('success');
     }

}
