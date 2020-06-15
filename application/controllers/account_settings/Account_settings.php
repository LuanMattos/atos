<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account_settings extends Account_settings_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model("Us_usuarios_model");
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
            $data       = $this->Us_usuarios_model->data_user_by_session($data_s);
            $location   = $this->Us_location_user_model->data_location_by_id($data['_id']);
            $this->load->view("account_settings/index",compact("data","location"));
        }

    }
    public function acao_salvar_localizacao(){
        $session    = $this->session->get_userdata();
        $datapost   = $this->input->post("data",TRUE);


        if(empty($session['login'])){
            $this->session->sess_destroy();
            redirect();
        }

        $data_user          = $this->Us_usuarios_model->data_user_by_session(['login'=>$session['login']]);
        $datapost['_id'] = $data_user['_id'];
        $this->Us_location_user_model->save_mongo($datapost);

    }

    public function acao_salvar_informacoes_pessoais(){

        $data       = $this->input->post("usuarios",TRUE);
        $location   = $this->input->post("location_user",TRUE);

        if(empty($data['nome'])){
            $error['nome'] = "*";
        }
        if(empty($data['sobrenome'])){
            $error['sobrenome'] = "*";
        }
        if(empty($data['datanasc'])){
            $error['datanasc'] = "*";
        }
        if(empty($data['telcel'])){
            $error['telcel'] = "*";
        }
        if(empty($location['descricao'])){
            $error['descricao'] = "*";
        }


        $data['datanasc']   = date_to_us($data['datanasc']);
        $sms            = new \ServiceSms\ServiceSms();

        $data['telcel'] = $sms->validaTelefoneBr($data['telcel']);

        if(empty($data['telcel'])){
            $error['telceli'] = "Telefone inválido";
        }
        if(isset($error)){
            $this->response("error",$error);
        }

        $usuario            = $this->session->get_userdata();
        $data_user          = reset($this->Us_usuarios_model->getWhereMongo(["login"=>$usuario['login']]));
        $new_data           = array_merge($data,["_id"=>$data_user['_id']]);

        $this->Us_usuarios_model->save_mongo($new_data);

        $this->response("success",["msg"=>"Alterações salvas!"]);

    }

    public function acao_salvar_perfil(){
        $session    = $this->session->get_userdata();
        $datapost = $this->input->post(NULL,true);
        if(empty($session['login'])){
            $this->session->sess_destroy();
            redirect();
        }

        $data_user          = $this->Us_usuarios_model->data_user_by_session(['login'=>$session['login']]);
        $datapost['_id'] = $data_user['_id'];
        $this->Us_usuarios_model->save_mongo($datapost);
        $this->response("success",["msg"=>"Alterações salvas!"]);
    }


}
