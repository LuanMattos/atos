<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Verification extends SI_Controller
{

    public function __construct(){
        parent::__construct();
        $this->output->enable_profiler(FALSE);
        $this->load->model("account/home/Account_home_model");
        $this->load->model("Usuarios_model");
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
                $this->load->view('home',compact("dados"));
            }
        }
    }

    public function index(){
        $this->load->view("verification/index");
    }
    public function validate_code(){
        $datapost        = $this->input->post("data",TRUE);
        $session         = $this->session->get_userdata();
        $verify          = $this->Usuarios_model->getWhere(["email_hash"=>"{$session['verification_user']}"]);

        if(count($verify)){
            $verify = reset($verify);
        }
        $codeUser = $verify['codigo'];
        $verificationCode = $this->Account_home_model->getWhere(["codusuarios"=>$codeUser]);
        if(count($verificationCode)){
            $verificationCode = reset($verificationCode);
        }

        if($verificationCode['code_verification'] === $datapost){
            $this->db->update("account_home",["verification_ok"=>TRUE],["code_verification"=>$datapost],1);
            $this->session->set_userdata(["logado" => 1]);
            $this->response("success");
        }else{
            $error['codigov'] = "Código de verificação inválido";
            $this->response("error",compact("error"));
        }
    }



}
