<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cadastro_usuarios extends SI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('unificado/Un_cadastro_usuarios_model');

    }

    public function index(){
        $datapost       = (object)$this->input->post( NULL,TRUE );
        $where["login NOT ILIKE "] = "adm@ibugsec%";

        if(isset( $datapost->search )){
            $datapost->search       = addslashes( $datapost->search );
            $where['login ILIKE ']  = "%$datapost->search%";
        }

        $data   = $this->Un_cadastro_usuarios_model->getwhere( $where,"codigo" );
        $html   = $this->load->view( 'unico/cadastro_usuarios/index',NULL,TRUE );
        $this->response("success",compact( "html","data") );
    }

    public function salvar(){
        $codigo     = reset( func_get_args() );

        $where      = [ 1 => 2];

        if(!empty($codigo)){

            $where = [ "codigo" => $codigo ];
        }
        $data = $this->db->get_where( 'usuarios', $where , $limit = NULL, $offset = NULL)->result_array();

        if(count($data) > 0){
            $data   = reset($data);
        }
        if(!empty( $data )){
            $data['senha'] = "";
        }

        $html   = $this->load->view( 'unico/cadastro_usuarios/form', NULL, TRUE );
        $this->response("success",compact( "html", "data" ) );
    }

    public function acao_salvar(){
        $data = $this->input->post("data",TRUE);
        $error = false;

        if( $data['repsenha'] !== $data['senha'] ){ $error = [ "msg" => "Senhas não conferem!" ]; }

        if( empty($data['login']) ){ $error = [ "msg" => "Preencha o campo login" ]; }

        if( strlen($data['senha']) < 8){ $error = [ "msg" => "Senha deve conter de 8 a 100 caractéres" ]; }

        if( strlen($data['repsenha']) < 8 ){ $error = [ "msg" => "Rep. senha deve conter de 8 a 100 caractéres" ]; }

        if( $error ){ $this->response("error",$error); }

        unset($data['repsenha']);

        $data['senha'] = password_hash( $data['senha'],PASSWORD_DEFAULT );

        $save = $this->Un_cadastro_usuarios_model->save( $data );
        if( !$save ){
            $error["msg"] = "Erro ao salvar o registro";
            $this->response("error",$error);
        }
        $this->response("success");

    }

    public function excluir(){
        $codigo = reset(func_get_args());
        $where = ['codigo'=>$codigo];

        $data = $this->db->get_where('usuarios', $where )->row_array();

         if($data['login'] !== 'adm@ibugsec'){
            $where = ['codigo'=>$codigo];
            $this->Un_cadastro_usuarios_model->deletewhere($where);

             $this->response("success");
        }
        $error = [ "msg" => "Usuário administrador não pode ser deletado!" ];
        $this->response("error",$error);

    }

}
