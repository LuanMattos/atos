<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invite extends Home_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model("Us_usuarios_model");
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

                $this->load->view("invite/index");

            }
        }

    }
    public function enviar(){
        $this->load->library('email/mail');
        $datapost = (object)$this->input->post(NULL,true);
        $error = [];

        if(filter_var($datapost->email_telefone, FILTER_VALIDATE_EMAIL)){
            $email = $datapost->email_telefone;
        }elseif(validate_telcel_br("55".$datapost->email_telefone)){
            $telefone = validate_telcel_br("55".$datapost->email_telefone);
        }else{
            $error['msg'] = "Telefone/E-mail inválidos, para telefone, insirda o DD + os números do aparelho.";

        }
        if( $error ){
            $this->response("error",compact("error"));
        }

        if(isset($email)) {
            $mail = new Mail();
            $param = [];
            $param['from'] = 'account@atos.click';
            $param['to'] = $email;
            $param['name'] = "Atos";
            $param['name_to'] = "Convidado(a)";
            $param['assunto'] = 'Convite para o atos!';
            $data['nome'] = $this->data_user()['nome'];
            $html = $this->load->view("email/invite", $data, true);
            $param['corpo'] = '';
            $param['corpo_html'] = $html;
            $send = $mail->send( $param );
            if($send){
                $this->response("success", ['msg' => 'Convite enviado com sucesso!']);
            }
        }elseif(isset($telefone)){
            $dataSms = [
                "msg"           => "Você foi convidado para participar do Atos, acesse http://www.atos.click/sign/up",
                "destinatario"  => "$telefone",
                "date_to_send"  => date("Y-m-d H:i:s")
            ];

            $sms = new \ServiceSms\ServiceSms();
            $sms->processesDirect( $dataSms );
            $this->response("success", ['msg' => 'SMS enviado com sucesso!']);
        }
    }

}
