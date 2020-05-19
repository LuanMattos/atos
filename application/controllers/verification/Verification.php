<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Verification extends SI_Controller
{

    public function __construct(){
        parent::__construct();
        $this->output->enable_profiler(FALSE);
        $this->load->model("account/us_usuarios_conta_model");
        $this->load->model("Us_usuarios_model");
    }

    public function index(){
        $this->load->view("verification/index");
    }
    public function validate_code(){
        $datapost        = $this->input->post("data",TRUE);
        if(!$datapost){
            $error['codigov'] = "Preencha o campo com o código de verificação enviado para seu E-mail ou telefone";
            $this->response("error",compact("error"));
        }

        $session         = $this->session->get_userdata();

        $us_usuarios            = $this->mongodb->atos->us_usuarios;
        $us_usuarios_conta      = $this->mongodb->atos->us_usuarios_conta;
        $mongobulkwrite         = $this->mongobulkwrite;

        $verify             = $us_usuarios->find(["email_hash"=>"{$session['verification_user']}"]);
        $codeUser           = "";

        foreach ($verify as $key=>$row){
            $codeUser = $row['_id'];
        }
        $us_usuarios_conta_data = $us_usuarios_conta->find(["_id"=>"{$codeUser}"]);

        $code_verification      = "";

        foreach ($us_usuarios_conta_data as $row){
            $code_verification = $row['code_verification'];
        }
        if($code_verification === $datapost){
            $mongobulkwrite->update(["code_verification"=>$datapost],['$set' => ["verification_ok"=>TRUE]], ['multi' => false, 'upsert' => true]);
            $this->mongomanager->executeBulkWrite('atos.us_usuarios_conta',$mongobulkwrite);

            $this->session->set_userdata(["logado" => 1]);
            $this->response("success");
        }else{
            $error['codigov'] = "Código de verificação inválido";
            $this->response("error",compact("error"));
        }
    }



}
