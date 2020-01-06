<?php
use Modules\Account\RestoreAccount\RestoreAccount as RestoreAccount;
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends SI_Controller
{

    public function __construct(){
        parent::__construct();
        $this->load->model("Usuarios_model");
        $this->load->model("account/home/Account_home_model");
        $this->load->model("location/Location_user_model");
        $this->output->enable_profiler(FALSE);
        $this->load->helper("cookie");
        $this->load->helper("url");

    }

    public function index(){
        $data       = $this->input->post(NULL, TRUE);

        error_reporting(0);
        ini_set("display_errors",0);

        session_start();

        $sessao_atual   = $this->session->get_userdata()['__ci_last_regenerate'];

        $where          = ['__ci_last_regenerate'=>$sessao_atual];
        $session_db     = $this->Usuarios_model->getWhere($where);

        if(count($session_db)){
            if(is_array($session_db)):
                foreach($session_db as $row){

                    if($row['logado'] === 'f'){
                        $this->session->sess_destroy();
                        redirect();
                    }elseif($row['logado'] === 't'){

                        $this->valida_login_code_confirmation($data);

                        redirect("Home/Logged");
                    }
                }
            endif;

        }

        if (isset($data['login'])) {
            $user = $this->Usuarios_model->login($data['login']);
        } else {
            $this->session->sess_destroy();
            redirect("Home/back");
        }

//        var_dump(password_hash("admin", PASSWORD_DEFAULT));//criptografa a sessão
        if (!empty($data) && !empty($user)) {
            foreach ($user as $line) {

                if ($line['login'] === $data['login']) {
                    if (password_verify($data['senha'], $line['senha']) == true) {

                        if(isset($data['conectado'])){
                            set_cookie("session_coo",$sessao_atual,PHP_INT_MAX);
                            $data = [
                                "codigo"                => $line['codigo'],
                                "__ci_last_regenerate"  => $sessao_atual,
                                "logado"                => "t",
                                'session_coo'           => $_COOKIE['ci_session']

                            ];

                        }else{
                            $data = [
                                "codigo"                => $line['codigo'],
                                "__ci_last_regenerate"  => $sessao_atual,
                                "logado"                => "f",
                                'session_coo'           => ''

                            ];
                        }

                        $this->Usuarios_model->save($data);
                        $data = $this->Usuarios_model->getWhere(["codigo"=>$data['codigo']]);
                        $this->valida_login_code_confirmation($data);

                        if(count($data)){
                            $this->session->set_userdata(["logado"=>1,"login"=>$data[0]['login']]);
                            redirect("Home/logged");
                        }

                    } else {
                        $this->session->sess_destroy();
                        $this->session->set_userdata(["toError"=>1]);

                        redirect("Home/back");
                    }
                } else {
                    $this->session->sess_destroy();
                    $this->session->set_userdata(["toError"=>1]);
                    redirect("Home/back");
                }
            }
        } else {
            $this->session->sess_destroy();
            redirect("Home/back");
        }

    }
    public function valida_login_code_confirmation($data){
        if(is_array($data)) {
                $data = reset($data);
            //verifica se usuario ja confirmou cadastro atraves do codigo de validacao
            if (isset($data['login'])) {
                if (empty($data['login']) || empty($data['senha'])) {
                    redirect();
                }
                if (!empty($data['login']))
                    $validate_login = reset($this->Usuarios_model->validate_login($data['login']));

                if ($validate_login['verification'] === 'f' || empty($validate_login['verification'])):
                    $this->session->set_userdata(['verification_user' => $validate_login['email_hash']]);
                    redirect("verification/Verification/index");
                endif;
            }
        }
    }

    public function back(){
        $data = [];
        $error = $this->session->get_userdata();

        if(isset($error['toError'])){
            if($error['toError']):
                $data['error_senha'] = "Usuário/senha incorreto(s)";
            endif;
        }
        $this->session->sess_destroy();

        $this->load->view('index',$data);
    }
    public function logged(){
        $data_s = $this->session->get_userdata();

        if(!isset($data_s['logado'])){
            $this->session->sess_destroy();
            redirect("Home/index");
        }else{
            if(!empty($data_s)){
                $data = $this->Usuarios_model->getWhere(["login"=>$data_s['login']]);
                if(count($data)){
                    $dados = reset($data);
                }
                $location               = reset($this->Location_user_model->getWhere(['codusuario'=>$dados['codigo']]));
                $pais_cidade['nome']    = explode(',',$location['formatted_address_google_maps']);
                $this->load->view('home',compact("dados","location","pais_cidade"));
            }
        }
    }
    public function search(){
        $data_s = $this->session->get_userdata();

        if(!isset($data_s['logado'])){
            $this->session->sess_destroy();
            redirect();
        }else{
            if(!empty($data_s)){
                $data = $this->Usuarios_model->getWhere(["login"=>$data_s['login']]);
                if(count($data)){
                    $data = reset($data);
                }
                $this->load->view("search_full/index",$data);

            }
        }

    }
    public function register(){
        $this->load->view("register");
    }
    public function acao_cadastro(){
        $data           = (object)$this->input->post("data",TRUE);
        $sms            = new \ServiceSms\ServiceSms();
        $RestoreAccount = new RestoreAccount();

        $error  = [];

        $data->datanasc = date_to_us($data->datanasc);

        if(empty($data->telcodpais)){
            $error['telcel'] = "Preencha o código de telefone de seu país!";
        }
        if(!filter_var($data->email, FILTER_VALIDATE_EMAIL)){
            $error['email'] = "E-mail inválido!";
        }

        if(empty($data->email)){
            $error['email'] = " Preencha o campo e-mail!";
        }
        if(empty($data->senhacadastro)){

            $error['senhacadastro'] = "Preencha o campo senha!!";
        }
        if(empty($data->repsenha)){
            $error['repsenha'] = "Preencha o campo senha!";
        }
        if(empty($data->datanasc)){
            $error['datanasc'] = "Preencha o campo data nascimento!";
        }
        if(empty($data->telcel)){
            $error['telcel'] = "Preencha o campo  telefone!";
        }
        $numero_validado    = $sms->validaTelefoneBr($data->telcodpais . $data->telcel);

        if(!$numero_validado){
            $error['telcel'] = "Número de telefone inválido!";
        }

        if(!empty($data->senhacadastro)){
            if(strlen($data->senhacadastro) < 8){
                $error['senhacadastro'] = "Senha com no mínimo 8 caracteres!";
            }
        }
        if(!empty($data->repsenha)){
            if(strlen($data->repsenha) < 8){
                $error['repsenha'] = "Senha com no mínimo 8 caracteres!";
            }
        }
        $pre_snome = preg_match('/[^[:alpha:]_]/', $data->sobrenome);
        if(empty($data->sobrenome) || empty($data->nome) || !empty($pre_snome)){
            $error['sobrenome'] = "Nome e/ou sobrenome inválido(s)!";
        }

        if($data->senhacadastro !== $data->repsenha){
             $error['igualdadepass'] = "As senhas não correspondem!";
            $this->response("error",compact("error"));
        }

        $validate_login = $this->Usuarios_model->getwhere(["login"=>$data->email]);


        if(count($validate_login)){
            $validate_login         = reset($validate_login);
            $error['email']         = "Usuário " . $validate_login['login'] ." já está cadastrado!";
        }

        $numero_validado    = $sms->validaTelefoneBr($data->telcodpais . $data->telcel);
        $verifica_tel_repet = $this->Usuarios_model->getwhere(["telcel"=>"f"]);

        if(count($verifica_tel_repet)){
            $verifica_tel_repet           = reset($verifica_tel_repet);
            $error['telcel']         = "Telefone " . $verifica_tel_repet['telcel'] ." já está cadastrado!";
        }

        if(count($error) > 0){
            $this->response("error",compact("error"));
        }

        $argo_pass                  = password_hash($data->senhacadastro,PASSWORD_ARGON2I);
        $data = [
            "email"                 => $data->email,
            "login"                 => $data->email,
            "senha"                 => $argo_pass,
            "datanasc"              => $data->datanasc,
            "telcel"                => "{$numero_validado}",
            "nome"                  => $this->clear_car($data->nome),
            "sobrenome"             => $this->clear_car($data->sobrenome),
            "email_hash"            => $this->encript_atos($data->email)
        ];

        $error['telcel']    = "O número de telefone é inválido";

        if(!$numero_validado){
            $this->response("error",compact("error"));
        }
        $codigo_verificacao = $RestoreAccount->gerarCodigoValidacao();


        $dataSms = [
            "msg"           => $codigo_verificacao . " é o seu código de verificação atos",
            "destinatario"  => "$numero_validado",
            "date_to_send"  => date("Y-m-d H:i:s")
        ];
//        $sms->processesDirect($dataSms);

        $save = $this->Usuarios_model->save($data,["codigo","email_hash"]);
        if($save){
            $data_account = [
              "code_verification" => $codigo_verificacao,
              "codusuarios"       => $save['codigo']

            ];
            $this->Account_home_model->save($data_account);
        }

        $this->session->set_userdata(["verification_user"=>$save['email_hash'],"login"=>$data['login']], 1);
        $this->response("success");
    }
    public function logout(){
        $sessao_atual       = $this->session->get_userdata()['__ci_last_regenerate'];

        $where              = ['__ci_last_regenerate'=>$sessao_atual];
        $data               = $this->Usuarios_model->getWhere($where);

        if(is_array($data)){

            foreach($data as $user){
                $new_data = [
                    "codigo"                =>$user['codigo'],
                    "__ci_last_regenerate"  =>null,
                    "logado"                =>'f',
                    "session_coo"           =>''
                ];
                $this->Usuarios_model->save($new_data);
            }
        }

        $this->session->sess_destroy();
        redirect();
    }
    public function dashboard_activity(){
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
                $this->load->view("home/index",compact("dados","pais_cidade"));

            }
        }


    }

}
