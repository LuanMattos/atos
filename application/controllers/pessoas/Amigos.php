<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Amigos extends Home_Controller
{
    private $data_session;

    public function __construct(){
        parent::__construct();
        $this->load->model("usuarios/Us_amigos_model");
        $this->load->model("usuarios/Us_amigos_solicitacoes_model");
        $this->load->model("Us_usuarios_model");
        $this->output->enable_profiler(FALSE);
        $this->data_session = $this->session->get_userdata();

        if(empty($this->data_session['login'])){
            redirect();
            exit();
        }

    }
    /**
     * Verifica se usuario já adicinou amigo
     * @param $param
    **/
    public function validate_add_person($param){
        $validate       = $this->mongodb->atos->us_amigos_solicitacoes->find(['codamigo'=>$param['codamigo'],'codusuario'=>$param['codusuario']]);
        foreach($validate as $row){
            return $row;
        }
        return false;
    }

    public function add_person(){
        $datapost       = (object)$this->input->post(NULL,TRUE);
        $data_s         = $this->session->get_userdata();

        $data_user      = $this->Us_usuarios_model->data_user_by_session($data_s);


        $validate_data  = [
            'codamigo' => $datapost->id,
            'codusuario'=>$data_user['_id']
        ];
        $validate       = $this->validate_add_person($validate_data);

        if(!$validate){
            $data = [
                'codusuario'     => $data_user['_id'],
                'codamigo'       => $datapost->id,
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ];
            $this->Us_amigos_solicitacoes_model->save_mongo($data);
            $reponse = "add";

        }else{

            $mongobulkwrite         = $this->mongobulkwrite;
            $mongobulkwrite->delete(["codusuario"=>$data_user['_id'],'codamigo'=>$datapost->id], ['limit' => 1]);
            $this->mongomanager->executeBulkWrite('atos.us_amigos_solicitacoes',$mongobulkwrite);
            $reponse = "delete";
        }
        $this->response("success",$reponse);


    }
    public function aceitar_pessoa(){
        $datapost   = (object)$this->input->post(NULL,TRUE);

        $data_user      = $this->Us_usuarios_model->data_user_by_session($this->data_session);

        $data = [
            'codusuario'     => $data_user['_id'],
            'codamigo'       => $datapost->id,
            'created_at'     => date('Y-m-d H:i:s'),
            'updated_at'     => date('Y-m-d H:i:s'),
        ];

        $this->Us_amigos_model->save_mongo($data);


        $this->Us_amigos_solicitacoes_model->deleta_amizade($data_user['_id'],$datapost->id);
        $this->response("success");

    }

}
