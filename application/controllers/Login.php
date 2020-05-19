<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends Login_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->output->enable_profiler(FALSE);
        $this->load->helper("cookie");


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

                                    redirect('Home/index');
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

}
