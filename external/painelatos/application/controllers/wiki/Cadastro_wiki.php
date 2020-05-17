<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cadastro_wiki extends Wk_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->library('pagination');
        $this->load->model("wiki/Wk_cadastro_wiki_model");
    }

    public function index(){

        $datapost = (object)$this->input->post(NULL,TRUE);
        $where = NULL;

        if(isset($datapost->search)){
            $datapost->search = addslashes($datapost->search);
            $where['nome ILIKE '] = "%$datapost->search%";
        }

        $data = $this->Wk_cadastro_wiki_model->getwhere($where,"codigo");

        $html   = $this->load->view('cadastro_wiki/index',NULL,TRUE);
        $this->response("success",compact("html","data"));
    }

    public function salvar(){
        $codigo     = reset(func_get_args());
        $where = [1=>2];
        if(!empty($codigo)){
            $where = [ "codigo" => $codigo ];
        }
        $data = $this->db->get_where('wiki', $where , $limit = NULL, $offset = NULL)->result_array();

        if(count($data) > 0){
            $data   = reset($data);
        }

        $html   = $this->load->view('cadastro_wiki/form',NULL,TRUE);
        $this->response("success",compact("html","data"));
    }

    public function acao_salvar(){
        $data = $this->input->post("data",TRUE);
        $save = $this->Wk_cadastro_wiki_model->save($data);
        if(!$save){
            $error["msg"] = "Erro ao salvar o registro";
            $this->response("error",$error);
        }
        $this->response("success");


    }

    public function excluir(){
        $codigo = reset(func_get_args());
        $where = ['codigo'=>$codigo];
        $this->Wk_cadastro_wiki_model->deletewhere($where);
    }

    public function logout(){
        $this->session->sess_destroy();
        redirect();
    }

}
