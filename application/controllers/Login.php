<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Modules\Account\RestoreAccount\RestoreAccount as RestoreAccount;

class Login extends Login_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->output->enable_profiler(FALSE);
        $this->load->helper("cookie");
        $this->load->model('Us_usuarios_model');
        $this->load->model('account/Us_usuarios_conta_model');
        $this->load->library('email/mail');

    }

    public function index(){
        $this->load->view('index');
    }
	public function start_login(){
        $datapost       = (object)$this->input->post(NULL, TRUE);

        $sessao_atual   = $this->session->get_userdata()['__ci_last_regenerate'];
        error_reporting(0);
        ini_set("display_errors",0);
        session_start();
        if (isset($datapost->login)) {
            $user_find = $this->mongodb->atos->us_usuarios->find(['login'=>$datapost->login]);
            foreach($user_find as $row){
                if (!empty($datapost) && !empty($row)) {
                    $this->valida_login_code_confirmation($row);

                    if ($row['login'] === $datapost->login) {
                        if (password_verify($datapost->senha, $row['senha']) == true) {

                            if(isset($datapost->conectado)){
                                $cookie_manter_conectado = $sessao_atual . rand() . md5(date('Y-m-d H:i:U')) . uniqid();
                                set_cookie("session_coo",$cookie_manter_conectado,PHP_INT_MAX);
                                $update = [
                                    "__ci_last_regenerate"  => $sessao_atual,
                                    "permanecer_logado"     => true,
                                    'session_coo'           => $cookie_manter_conectado,
                                    'logado'                => true

                                ];

                            }else{
                                $update = [
                                    "__ci_last_regenerate"  => $sessao_atual,
                                    "permanecer_logado"     => false,
                                    'session_coo'           => '',
                                    'logado'                => true

                                ];
                            }
                            $mongobulkwrite         = $this->mongobulkwrite;
                            $mongobulkwrite->update(["_id"=>$row['_id']],['$set' => $update], ['multi' => false, 'upsert' => true]);
                            $this->mongomanager->executeBulkWrite('atos.us_usuarios',$mongobulkwrite);

                            $data = $this->mongodb->atos->us_usuarios->find(["_id"=>$row['_id']]);
                            foreach($data as $line){

                                if(isset($line['login'])){
                                    $this->session->set_userdata(["logado"=>1,"login"=>$row['login']]);

                                    redirect('home');
                                }
                            }
                        }
                    }
                }
            }

        }
        $this->session->sess_destroy();
        redirect("Login");
    }
    public function renew_senha(){
        $this->load->view('redefinir_senha');
    }
    public function send_link_renew_pass(){
        $datapost = (object)$this->input->post(NULL,TRUE);

        $getuser = $this->Us_usuarios_model->getWhereMongo(['email'=>$datapost->email],"_id",-1,NULL,NULL,TRUE);

        $msg = '';

        if( !$getuser ){
            $msg.= "Não existe conta para este E-mail!";
        }elseif(!$datapost->email){
            $msg.= "Preencha o campo E-mail";
        }
        if($msg){
            $this->response('success',compact('msg'));
        }

        $mail  = new Mail();
        $RestoreAccount = new RestoreAccount();
        $codigo_verificacao = $RestoreAccount->gerarCodigoValidacao();
        $link = $RestoreAccount->generate_link_pass(true);

        $nome                       = ucfirst( $getuser['nome'] );
        $sobrenome                  = ucfirst( $getuser['sobrenome'] );
        $param = [];
        $param['from']              = 'account@atos.click';
        $param['to']                = $getuser['email'];
        $param['name']              = "Atos";
        $param['name_to']           = $getuser['nome'];
        $param['assunto']           = 'Redefinição de senha!';
        $data['alteracao_senha']    = true;
        $data['codigo_confirmacao'] = $codigo_verificacao;
        $data['link']               = "https://www.atos.click" . $link;

        if(ENVIRONMENT == 'development'){
            $data['link']               = "http://localhost/" . $link;
        }

        $data['link_nao_fui_eu']    = '';
        $data['nome']               = $nome;
        $data['sobrenome']          = $sobrenome;

        $html = $this->load->view("email/confirme",$data,true);
        $param['corpo']      = '';
        $param['corpo_html'] = $html;

        $data_save = [];
        $data_save['_id'] = $getuser['_id'];
        $data_save['codigo_confirmacao'] = $codigo_verificacao;
        $data_save['link'] = $link;
        $this->Us_usuarios_conta_model->save_mongo( $data_save );
        $send = $mail->send( $param );

        if( $send ){
            $msg = "Enviamos as informações para sua conta de E-mail";
        }

        $this->response('success',compact('msg'));

    }
    public function verify_pass_index(){
        $segment = $this->uri->segment(1);
        $segment .= "/" . $this->uri->segment(2);
        $geturl = $this->Us_usuarios_conta_model->getWhereMongo(['link'=>$segment],"_id",-1,NULL,NULL,TRUE);
        if( !$geturl ){
            redirect('404_override');
        }
        $this->load->view('tela_redefinicao_senha');
    }
    public function save_pass(){
        $datapost = (object)$this->input->post(NULL,TRUE);
        $response['msg_error'] = [];
        if( !$datapost->email ){
            array_push( $response['msg_error'],"Preencha o campo E-mail" );
        }
        if( !$datapost->senha ){
            array_push( $response['msg_error'],"Preencha o campo senha" );
        }
        if(!$datapost->confirmar_senha){
            array_push($response['msg_error'],"Preencha o campo Confirmar Senha");
        }
        if(  $datapost->senha !== $datapost->confirmar_senha  ){
            array_push( $response['msg_error'],"As Senhas não conferem" );
        }
        if( strlen( $datapost->senha ) < 8 || strlen( $datapost->confirmar_senha ) < 8 ){
            array_push($response['msg_error'],"As Senhas devem conter no mínimo 8 caracteres, entre elas maiúscula e minúsculas");
        }

        $valida_email = $this->Us_usuarios_model->getWhereMongo( ['email'=>$datapost->email],"_id",-1,NULL,NULL,TRUE );

        if( !$valida_email ){
            array_push( $response['msg_error'],"E-mail não possui conta Atos" );
        }


        $geturl = $this->Us_usuarios_conta_model->getWhereMongo(['_id'=>$valida_email['_id']],"_id",-1,NULL,NULL,TRUE);

        if($geturl){

            $url = str_replace($_SERVER['HTTP_ORIGIN']."/","",$_SERVER['HTTP_REFERER']);
            if($geturl['link'] !== "$url") {

                $sec = [];
                $sec['HTTP_CLIENT_IP'] = isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : '';
                $sec['HTTP_CLIENT_IP'] = isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : '';
                $sec['HTTP_X_FORWARDED_FOR'] = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : '';
                $sec['REMOTE_ADDR'] = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
                $externalContent = file_get_contents('http://checkip.dyndns.com/');
                $cleanIp = strip_tags($externalContent);
                $ip_externo_clear = preg_replace("/[^0-9]/", "", $cleanIp);
                $sec['ip_external_1'] = $ip_externo_clear;
                $sec['email_input'] = $datapost->email;

                $this->load->model('security/Controll_acess_external_model');

                $this->Controll_acess_external_model->save_mongo($sec);

                array_push($response['msg_error'], "Esta conta não possui pedido de recuperação!");
            }
        }else{
            array_push( $response['msg_error'],"E-mail não está registrado no atos!" );
        }

        if( $response['msg_error'] ){
            $this->response('error',$response );
        }

        $data = [];
        $data['_id'] = $valida_email['_id'];
        $data['senha'] = password_hash($datapost->senha,PASSWORD_DEFAULT);
        $this->Us_usuarios_model->save_mongo( $data );
        $this->Us_usuarios_conta_model->save_mongo( ['_id'=>$valida_email['_id'],'link'=>false] );
        array_push($response['msg_success'], "Sucesso!");
        $this->response('success',$response);


    }

}
