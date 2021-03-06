<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Modules\Account\RestoreAccount\RestoreAccount as RestoreAccount;

class Account_settings extends Account_settings_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model("Us_usuarios_model");
        $this->load->model("location/Us_location_user_model");
        $this->output->enable_profiler(FALSE);
        $this->load->helper("cookie");
        $this->load->helper("url");
        $this->load->library('email/mail');

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
        $datapost   = $this->input->post(NULL,true);
        if(empty($session['login'])){
            $this->session->sess_destroy();
            redirect();
        }

        $data_user          = $this->Us_usuarios_model->data_user_by_session(['login'=>$session['login']]);
        $datapost['_id'] = $data_user['_id'];
        $this->Us_usuarios_model->save_mongo($datapost);
        $this->response("success",["msg"=>"Alterações salvas!"]);
    }
    public function acao_salvar_requisicoes_amizade(){
        $session    = $this->session->get_userdata();
        $datapost = $this->input->post(NULL,true);
        if(empty($session['login'])){
            $this->session->sess_destroy();
            redirect();
        }
        $datapost['bloquear_solicitacoes_amizade'] = false;

        if($datapost['bloquear_solicitacoes_amizade'] == 'on'){
            $datapost['bloquear_solicitacoes_amizade'] = true;
        }

        $data_user          = $this->Us_usuarios_model->data_user_by_session(['login'=>$session['login']]);
        $datapost['_id'] = $data_user['_id'];
        $this->Us_usuarios_model->save_mongo($datapost);
        $this->response("success",["msg"=>"Alterações salvas!"]);
    }
    public function acao_salvar_email_conta(){
        $session    = $this->session->get_userdata();
        $datapost   = $this->input->post(NULL,true);
        $data       = $this->data_user();

        $error = '';
        $senha = $this->Us_usuarios_model->getWhereMongo(['_id'=>$data['_id']],"_id",-1,NULL,NULL,TRUE);


        if( !password_verify($datapost['senha'],$senha->senha )){
            $error .= 'Senha não confere (mais 4 tentativas)';
        }

        if( $datapost['email_antigo'] !== $data['email']){
            $error .= "E-mail não confere! \n" ;
        }

        switch ($datapost){
            case !$datapost['email_antigo']:
                $error .= "E-mail antigo deve ser preenchido! \n" ;
            case !$datapost['senha']:
                $error .= "Senha deve ser preenchido! \n" ;
            case !$datapost['novo_email']:
                $error .= "Novo E-mail deve ser preenchido! \n" ;
            case !$datapost['rep_novo_email']:
                $error .= "Rep. Novo E-mail deve ser preenchido! \n" ;
            case !filter_var($datapost['novo_email'], FILTER_VALIDATE_EMAIL):
                $error .= "Novo E-mail inválido! \n" ;
            case !filter_var($datapost['email_antigo'], FILTER_VALIDATE_EMAIL):
                $error .= "E-mail antigo inválido! \n" ;
            case !filter_var($datapost['rep_novo_email'], FILTER_VALIDATE_EMAIL):
                $error .= "Rep. novo E-mail inválido! \n" ;
        }
        unset($datapost['rep_novo_email']);
        unset($datapost['email_antigo']);
        unset($datapost['rep_novo_email']);
        unset($datapost['senha']);

        if( $error ){
            $this->response("error",$error);
        }
        if(empty($session['login'])){
            $this->session->sess_destroy();
            redirect();
        }

        $mail               = new Mail();
        $RestoreAccount     = new RestoreAccount();
        $codigo_verificacao = $RestoreAccount->gerarCodigoValidacao();
        $nome                       = ucfirst( $data['nome'] );
        $sobrenome                  = ucfirst( $data['sobrenome'] );
        $param = [];
        $param['from']              = 'account@atos.click';
        $param['to']                = $datapost['novo_email'];
        $param['name']              = "Atos";
        $param['name_to']           = $data['nome'];
        $param['assunto']           = 'Alteração de E-mail!';
        $data['codigo_confirmacao'] = $codigo_verificacao;
        $data['cadastro']           = true;
        $data['nome']               = $nome;
        $data['sobrenome']          = $sobrenome;
        $data['alteracao_email']    = true;

        unset($datapost['novo_email']);

        $html = $this->load->view("email/confirme",$data,true);
        $param['corpo']      = '';
        $param['corpo_html'] = $html;
        $send = $mail->send( $param );
        if( $send ){
            $datapost['_id'] = $data['_id'];
            $this->Us_usuarios_model->save_mongo($datapost);
            $this->response("success","Alterações salvas!");
        }else{
            $this->response("error");
        }
    }

    public function acao_salvar_nova_senha(){
        $datapost   = $this->input->post(NULL,true);
        $data       = $this->data_user();
        $error = '';

        $senha = $this->Us_usuarios_model->getWhereMongo(['_id'=>$data['_id']],"_id",-1,NULL,NULL,TRUE);

        if( $datapost['senha'] !== $datapost['rep_senha'] ){
         $error .= "As senhas não conferem!";
        }
        if( strlen($datapost['senha']) < 8 || strlen($datapost['rep_senha']) < 8 ){
         $error .= "A senha deve conter no mínimo 8 dígitos!";
        }

        if( !password_verify($datapost['senha_antiga'],$senha->senha )){
            $error .= 'Senha incorreta (mais 4 tentativas)';
        }
        if( $error ){
            $this->response("error",$error);
        }

        $save = [];
        $save['senha'] = password_hash($datapost['senha'], PASSWORD_DEFAULT);
        $save['_id']   = $senha['_id'];
        $this->Us_usuarios_model->save_mongo( $save );
        $this->response("success","Alterações salvas!");

    }


}
