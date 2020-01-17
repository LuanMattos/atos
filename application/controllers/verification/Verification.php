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
        $cimongo         = new Cimongo();

        $us_usuarios            = $this->mongodb->atos->us_usuarios;
        $us_usuarios_conta      = $this->mongodb->atos->us_usuarios_conta;
        $mongobulkwrite         = $this->mongobulkwrite;

        $verify             = $us_usuarios->find(["email_hash"=>"{$session['verification_user']}"]);
        $codeUser           = "";

        foreach ($verify as $key=>$row){

            $codeUser = $row['_id'];
        }
        $us_usuarios_conta_data = $us_usuarios_conta->find(["codusuarios"=>"{$codeUser}"]);

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
