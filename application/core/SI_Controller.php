<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class SI_Controller extends CI_Controller{
    public $mongodb;
    public $mongomanager;
    public $mongobulkwrite;

    public function __construct(){
        parent::__construct();
        $this->load_helpers();
        $this->conect_mongodb();

    }
    public function verifica_sessao(){
        $data_s = $this->session->get_userdata();
        $this->load->helper("cookie");

        if(!isset($data_s['logado'])) {
            $this->session->sess_destroy();
            delete_cookie('session_coo');
            redirect();
        }
    }
    public function mongocollection($param,$options = []){
        return new MongoDB\Collection($this->mongomanager,$param['database'],$param['collection'],$options);
    }
    protected function conect_mongodb(){
        $this->config->load('database');
        $configmongo                = (object)$this->config->item('mongodb');
//        mongodb://mongodb0.example.com:27017/admin

        $this->mongodb              = new MongoDB\Client("mongodb://".$configmongo->hostname . ":" . $configmongo->port . "/" .$configmongo->database,[],[]);
        $this->mongomanager         = new MongoDB\Driver\Manager("mongodb://".$configmongo->hostname . ":" . $configmongo->port. "/" .$configmongo->database,[],[]);
        $this->mongobulkwrite       =  new \MongoDB\Driver\BulkWrite();

    }
    /**
     * deixa apenas letras evitando SQL-inject 1
    **/
    public function clear_car($value){
        $value_a = preg_replace('/[^[:alpha:]_]/', '',$value);
        return addslashes($value_a);

    }
    public function id_mongo($data = ""){
        return md5($data).rand().uniqid();
    }
    public  function load_helpers(){
        $this->load->helper(
            array('date_helper')
        );
    }

    public function md5Crazy($pass){
        $argo_default               =  md5($pass);
        $abc                        =  md5($argo_default);
        $awerofsdfmadfje            =  md5($abc);
        $bmfgtrew                   =  md5($awerofsdfmadfje).$argo_default;
        $cddbcdf                    =  md5($bmfgtrew);
        $dovfmsptghu                =  md5($cddbcdf);
        $awerofsdfmadfje            =  md5($awerofsdfmadfje);
        $fayusdaksfa                =  md5($awerofsdfmadfje);
        $sdfkaslfs                  =  md5($fayusdaksfa);
        $sdlfjakfsudfjnsdf          =  md5($argo_default);
        $sfuavnsdfa                 =  md5($dovfmsptghu);
        $sfjsasdffbmamsdfasdkfs     =  md5($sdlfjakfsudfjnsdf);
        $e                          =  md5($bmfgtrew.$bmfgtrew.$bmfgtrew.$sfjsasdffbmamsdfasdkfs.$sfuavnsdfa.$sdfkaslfs);
        return $e;
    }
    /**
     * Criptografa os dados
     */
    public function encript_atos($pass){
        $final          = $this->md5Crazy($pass);
        $argo_bc        =  password_hash($final, PASSWORD_DEFAULT);
        return $argo_bc;
    }
    /**
     * Verifica se a senha corresponde a criptografia atos
    */
    public function verify_pass($pass,$datadb){
        $pass = $this->md5Crazy($pass);

        return password_verify($pass,$datadb);
    }


    /**
     * Traz dados padrão do usuário logado
    **/
    public function data_user(){
        $data_s             = $this->session->get_userdata();
        $this->load->model('location/Us_location_user_model');
        $this->load->model('storage/img/Us_storage_img_cover_model');
        $this->load->model('storage/img/Us_storage_img_profile_model');
        $this->load->model('Us_usuarios_model');

        if(!isset($data_s['logado'])){
            $this->session->sess_destroy();
            redirect();
        }else{
            if(!empty($data_s)){
                $dados      = $this->Us_usuarios_model->data_user_by_session($data_s);
                $dados['location'] = [];
                if(!empty($dados)){
                    $dados['location']      = reset($this->Us_location_user_model->getWhereMongo(["_id"=>$dados['_id']]));

                    $find_img               = reset($this->Us_storage_img_profile_model->getWhereMongo(['codusuario'=>$dados['_id']],$orderby = "created_at",$direction =  -1,$limit = NULL,$offset = NULL));
                    $dados['img_profile']   = $find_img['server_name'] . $find_img['bucket'] . '/' . $find_img['folder_user'] . '/' . $find_img['name_file'];

                    $find_img_cover         = reset($this->Us_storage_img_cover_model->getWhereMongo(['codusuario'=>$dados['_id']],$orderby = "created_at",$direction =  -1,$limit = NULL,$offset = NULL));
                    $dados['img_cover']     = $find_img_cover['server_name'] . $find_img_cover['bucket'] . '/' . $find_img_cover['folder_user'] . '/' . $find_img_cover['name_file'];

                }
               return $dados;

            }
        }
        redirect();
    }



}
