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
    public function index(){
        $dados = $this->data_user();
        $this->load->view('pessoas/full_amigos',compact("dados"));
    }
    public function full_amigos(){
        $user_logado    = $this->data_user();
        $datapost       = (object)$this->input->post(NULL,TRUE);
        $options        = ["amigos"=>["_id"=>["sort"=>1]]];
        $data           = $this->Us_amigos_model->data_full_amigos($user_logado,$options);

        $this->response('success',compact("data"));
    }
    /**
     * Filtra todos usuarios para o chat de acordo com configuração
     * offline 0
     * online 1
     * desconectado 2
     * ocupado 3
    **/
    public function full_amigos_chat(){
        $user_logado    = $this->data_user();
        $datapost       = (object)$this->input->post(NULL,TRUE);
        $options        = ["amigos"=>["_id"=>["sort"=>1]]];
        $data           = $this->Us_amigos_model->data_full_amigos($user_logado,$options);

        $this->response('success',compact("data"));
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

    /**
     * Adiciona ou remove usuario
     **/
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
    public function delete_amizade(){
        $datapost       = (object)$this->input->post(NULL,TRUE);
        if(isset($datapost->id[0])){
            $datapost->id = $datapost->id[0];
        }

        $data_user = $this->data_user();
        $data      = ['amigos' =>  ['_id'=>new \MongoDB\BSON\ObjectId($datapost->id)]];

        $this->Us_amigos_model->save_sub_document($data,['_id'=>$data_user['_id']],  '$pull');



        $this->response("success");

    }
    public function aceitar_pessoa(){
        $datapost   = (object)$this->input->post(NULL,TRUE);
        $this->load->model("account/config/Config_permissoes_informacoes_model");

        $data_user                  = $this->Us_usuarios_model->data_user_by_session($this->data_session);
        $amigo                      = reset($this->Us_usuarios_model->getWhereMongo(["_id"=>$datapost->id]));
        $permissoes_amigo           = reset($this->Config_permissoes_informacoes_model->getWhereMongo(["codusuario"=>$datapost->id]));

        $verify = $this->Us_amigos_model->getWhereMongo(['_id'=>$data_user['_id']]);

        if(empty($verify)){

            $data = [
                "_id" => $data_user['_id'],
                    "amigos"=>new \MongoDB\Model\BSONArray(["amigos"=>[
                            "_id"               => new \MongoDB\BSON\ObjectId($amigo['_id']),
                            "nome"              => $amigo['nome'],
                            "sobrenome"         => $amigo['sobrenome'],
                            "datanasc"          => $amigo['datanasc'],
                            "permissoes_view"   => $permissoes_amigo

                       ]])
                ,
            ];

            $this->Us_amigos_model->save_mongo($data);

        }else{
            $data = ['amigos' =>
                        ['$each' =>  new \MongoDB\Model\BSONArray(
                                ["amigos"=>[
                                    '_id'=>new \MongoDB\BSON\ObjectId($amigo['_id']),
                                    "nome"              => $amigo['nome'],
                                    "sobrenome"         => $amigo['sobrenome'],
                                    "datanasc"          => $amigo['datanasc'],
                                    "permissoes_view"   => $permissoes_amigo
                                ]
                        ])
                     ]
            ];
            $where = ['_id'=>$data_user['_id']];
            $this->Us_amigos_model->save_sub_document($data,$where, $type = '$addToSet');

        }

        $verify             = $this->Us_amigos_model->getWhereMongo(['_id'=>$datapost->id]);
        $permissoes_amigo   = reset($this->Config_permissoes_informacoes_model->getWhereMongo(["codusuario"=>$data_user['_id']]));


        if(empty($verify)){

            $data = [
                "_id" => $datapost->id,
                "amigos"=>new \MongoDB\Model\BSONArray(["amigos"=>[
                        "_id"               => new \MongoDB\BSON\ObjectId($data_user['_id']),
                        "nome"              => $data_user['nome'],
                        "sobrenome"         => $data_user['sobrenome'],
                        "datanasc"          => $data_user['datanasc'],
                        "permissoes_view"   => $permissoes_amigo

                    ]]),
            ];



            $this->Us_amigos_model->save_mongo($data);

        }else{

            $data = ['amigos' =>
                ['$each' =>  new \MongoDB\Model\BSONArray(
                    ["amigos"=>[
                        '_id'=>new \MongoDB\BSON\ObjectId($data_user['_id']),
                        "nome"              => $data_user['nome'],
                        "sobrenome"         => $data_user['sobrenome'],
                        "datanasc"          => $data_user['datanasc'],
                        "permissoes_view"   => $permissoes_amigo
                    ]
                    ])
                ]
            ];
            $where = ['_id'=>$datapost->id];
            $this->Us_amigos_model->save_sub_document($data,$where, $type = '$addToSet');

        }


        $this->Us_amigos_solicitacoes_model->deleta_amizade($data_user['_id'],$datapost->id);
        $this->response("success");

    }
    public function amigos_by_usuario_limit(){
        $this->load->model("storage/img/Us_storage_img_profile_model");

        $identificador = $this->input->post("id",TRUE);
        $id = $this->Us_usuarios_model->getWhereMongo(['login_atos'=>$identificador],"_id",-1,NULL,NULL,TRUE);
        $data_user  = $this->Us_usuarios_model->data_user_by_session($this->data_session);
        $_id        = $data_user['_id'];

        if($id){
            $_id = $id['_id'];
        }

        $data                   = reset($this->Us_amigos_model->getWhereMongo(['_id'=>$_id],$orderby = "_id",$direction =  -1,$limit = 6,$offset = NULL));
        $row['img_profile']     = [];
        foreach($data['amigos'] as $row){

            $path                   = $this->Us_storage_img_profile_model->getWhereMongo(['codusuario'=>reset($row['_id'])],$orderby = "created_at",-1,NULL,NULL,TRUE);
            $row['img_profile']     =  !empty($path['server_name'])?$path['server_name'] . $path['bucket'] . '/' . $path['folder_user'] . '/' . $path['name_file']:false;
            $atos_login   = $this->Us_usuarios_model->getWhereMongo(['_id'=>reset($row['_id'])],$orderby = "created_at",-1,NULL,NULL,TRUE);
            $row['login_atos'] = $atos_login['login_atos'];
        }
        $this->response("success",compact("data"));

    }
    public function solicitacoes_by_usuario_limit(){
        $data_user          = $this->data_user();
        $find_sol           = $this->Us_amigos_solicitacoes_model->getWhereMongo(['codamigo'=>$data_user['_id']]);
        $data               = [];
        $row['img_profile'] = [];
        foreach($find_sol as $row){
            $data_amigos                   = reset($this->Us_usuarios_model->getWhereMongo(['_id'=>$row['codusuario']]));
            $path                          = reset($this->Us_storage_img_profile_model->getWhereMongo(['codusuario'=>$data_amigos['_id']],$orderby = "created_at",$direction =  -1,$limit = NULL,$offset = NULL));
            $data_amigos['img_profile']    = !empty($path['server_name'])?$path['server_name'] . $path['bucket'] . '/' . $path['folder_user'] . '/' . $path['name_file']:false;
            $data_amigos['notified']       = $row['notified'];

            array_push($data,$data_amigos);
        }

        $this->response('sucess',compact('data'));
    }

}
