<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account_settings extends SI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model("Usuarios_model");
        $this->load->model("location/Location_user_model");
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
                $data = $this->Usuarios_model->getWhere(["login"=>$data_s['login']]);
                if(count($data)){
                    $dados = reset($data);
                }
                $location = reset($this->Location_user_model->getWhere(['codusuario'=>$dados['codigo']]));
                $this->load->view("account_settings/index",compact("dados","location"));
            }
        }

    }
    public function acao_salvar_localizacao(){
        $session    = $this->session->get_userdata();

        if(empty($session['login'])){
            $this->session->sess_destroy();
            redirect();
        }
        $data_user  = reset($this->Usuarios_model->getWhere(['login'=>$session['login']]));
        $codusuario = $data_user['codigo'];
        $datapost   = $this->input->post("data",TRUE);

        $new_data = [
            "codusuario" => $codusuario
        ];
        $data             = array_merge($new_data,$datapost);
        $valida_location  = reset($this->Location_user_model->getWhere(["codusuario"=>$codusuario]));

        if(!empty($valida_location)){
            ;
            $new_data = [
                "codigo"     => $valida_location['codigo'],
                "codusuario" => $codusuario
            ];
            $data             = array_merge($new_data,$datapost);
        }

        $this->Location_user_model->save($data);

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
        $data_user          = reset($this->Usuarios_model->getWhere(["login"=>$usuario['login']]));
        $new_data           = array_merge($data,["codigo"=>$data_user['codigo']]);

        $save = $this->Usuarios_model->save($new_data);


        if(!$save){
            $error['errors'] = "Houve um erro ao salvar os dados, tente novamente mais tarde!";
            $this->response("error",$error);
        }


        $this->response("success",["msg"=>"Alterações salvas!"]);



    }


}
