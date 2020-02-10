<?php
use Modules\Account\RestoreAccount\RestoreAccount as RestoreAccount;

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Home_Controller
{

    public function __construct(){
        parent::__construct();
        $this->load->model("Us_usuarios_model");
        $this->load->model("storage/img/Us_storage_img_profile_model");
        $this->load->model("location/Us_location_user_model");
        $this->output->enable_profiler(FALSE);
        $this->load->helper("cookie");
        $this->load->helper("url");

    }

    public function index(){
        $datasession            = $this->session->get_userdata();

        if(isset($datasession['login'])){
            $data = $this->mongodb->atos->us_usuarios->find(['login'=>$datasession['login']]);
            foreach($data as $row){
                 $address = $this->Us_location_user_model->data_location_by_id($row['_id']);


                if(!empty($address)):
                    $row['address'] = $address['formatted_address_google_maps'];
                 endif;

                if($row['logado']):

                    $this->load->view('home',compact('row'));
                else:

                    if($row['permanecer_logado'] === false){
//                                            $this->valida_login_code_confirmation($row);

                        if($row['logado']):
                            $this->load->view('home',compact('row'));
                        else:
                            $this->session->sess_destroy();
                            redirect("Login");
                        endif;

                    }elseif($row['permanecer_logado'] === true){
                        if($row['logado']):
                            $this->load->view('home',compact('row'));
                        else:
                            $this->session->sess_destroy();
                            redirect("Login");
                        endif;
                    }else{
                        redirect('Login');
                    }
                endif;
            }

        }else{
            $this->session->sess_destroy();
            redirect("Login");
        }
//        var_dump(password_hash("admin", PASSWORD_DEFAULT));//criptografa a sessão

    }
    /**
     * verifica se usuario ja confirmou cadastro atraves do codigo de validacao
     * @param $data
    **/
    public function search(){
        $data_s = $this->session->get_userdata();

        if(!isset($data_s['logado'])){
            $this->session->sess_destroy();
            redirect();
        }else{

        }

    }
    public function register(){
        $this->load->view("register");
    }
    public function acao_cadastro(){
        $data           = (object)$this->input->post("data",TRUE);
        $sms            = new \ServiceSms\ServiceSms();
        $RestoreAccount = new RestoreAccount();
        $cimongo        = new Cimongo();

        $error  = [];

        if(empty($data->telcodpais)){
            $error['telcel'] = "Preencha o código de telefone de seu país!";
        }
        if(!filter_var($data->email, FILTER_VALIDATE_EMAIL)){
            $error['email'] = "E-mail inválido!";
        }

        if(empty($data->email)){
            $error['email'] = " Preencha o campo e-mail!";
        }
        if(empty($data->senhacadastro)){

            $error['senhacadastro'] = "Preencha o campo senha!!";
        }
        if(empty($data->repsenha)){
            $error['repsenha'] = "Preencha o campo senha!";
        }
        if(empty($data->datanasc) || (strlen($data->datanasc) != 10)){
            $error['datanasc'] = "Data de nascimento inválida!";
        }else{
            $data->datanasc = date_to_us($data->datanasc);
        }
        if(empty($data->telcel)){
            $error['telcel'] = "Preencha o campo  telefone!";
        }
        $numero_validado    = $sms->validaTelefoneBr($data->telcodpais . $data->telcel);

        if(!$numero_validado){
            $error['telcel'] = "Número de telefone inválido!";
        }

        if(!empty($data->senhacadastro)){
            if(strlen($data->senhacadastro) < 8){
                $error['senhacadastro'] = "Senha com no mínimo 8 caracteres!";
            }
        }
        if(!empty($data->repsenha)){
            if(strlen($data->repsenha) < 8){
                $error['repsenha'] = "Senha com no mínimo 8 caracteres!";
            }
        }
        $pre_snome = preg_match('/[^[:alpha:]_]/', $data->sobrenome);
        if(empty($data->sobrenome) || empty($data->nome) || !empty($pre_snome)){
            $error['sobrenome'] = "Nome e/ou sobrenome inválido(s)!";
        }

        if($data->senhacadastro !== $data->repsenha){
             $error['igualdadepass'] = "As senhas não correspondem!";
            $this->response("error",compact("error"));
        }

        $data_teste_email  = $this->mongodb->atos->us_usuarios->find(["login"=>$data->email]);

        foreach($data_teste_email as $validate_login){
            $login = $validate_login['login'];
        }

        if(!empty($login)){
            $error['email']         = "Usuário " . $login ." já está cadastrado!";
        }

        $numero_validado    = $sms->validaTelefoneBr($data->telcodpais . $data->telcel);
        $data_teste_tel     = $this->mongodb->atos->us_usuarios->find(["telcel"=>$numero_validado]);

        foreach($data_teste_tel as $validate_telcel){
            $telcel = $validate_telcel['telcel'];
        }

        if(!empty($telcel)){
            $error['telcel']         = "Telefone " . $telcel ." já está cadastrado!";
        }

        if(count($error) > 0){
            $this->response("error",compact("error"));
        }

        $argo_pass                  = password_hash($data->senhacadastro,PASSWORD_ARGON2I);


        $data = [
            "_id"                   => $this->Us_usuarios_model->object_id(),
            "id_atos"               => $this->id_mongo($data->email),
            "email"                 => $data->email,
            "login"                 => $data->email,
            "senha"                 => $argo_pass,
            "datanasc"              => $data->datanasc,
            "telcel"                => "{$numero_validado}",
            "nome"                  => $this->clear_car($data->nome),
            "sobrenome"             => $this->clear_car($data->sobrenome),
            "email_hash"            => $this->encript_atos($data->email),
            'logado'                => TRUE
        ];
        $error['telcel']    = "O número de telefone é inválido";

        if(!$numero_validado){
            $this->response("error",compact("error"));
        }
        $codigo_verificacao = $RestoreAccount->gerarCodigoValidacao();


        $dataSms = [
            "msg"           => $codigo_verificacao . " é o seu código de verificação atos",
            "destinatario"  => "$numero_validado",
            "date_to_send"  => date("Y-m-d H:i:s")
        ];

        $sms->processesDirect($dataSms);

        $save = $cimongo->insert("us_usuarios",$data,TRUE);
        if(empty($save)){
           exit("Erro ao salvar dados no banco!");
        }


        $data_conta = [
            "code_verification" => $codigo_verificacao,
            "_id"               => $data['_id']
        ];

        $cimongo->insert("us_usuarios_conta",$data_conta,TRUE);

        $this->session->set_userdata(["verification_user"=>$data['email_hash'],"login"=>$data['login']], 1);

        $this->response("success");
    }

    public function logout(){
        $data           = $this->session->get_userdata();
        $data['login']  = $this->mongodb->atos->us_usuarios->find(['login'=>$data['login']]);
        foreach($data['login'] as $row){

            $new_data = [
                "__ci_last_regenerate"  => null,
                "logado"                => false,
                'permanecer_logado'     => false,
                "session_coo"           => ''
            ];
            $mongobulkwrite         = $this->mongobulkwrite;
            $mongobulkwrite->update(["_id"=>$row['_id']],['$set' => $new_data], ['multi' => false, 'upsert' => true]);
            $this->mongomanager->executeBulkWrite('atos.us_usuarios',$mongobulkwrite);

        }

        $this->session->sess_destroy();
        redirect('Login');

    }

    /**
     * Adiciona as imagens ao bucket da Amazon
    **/
    public function add_time_line(){
        $this->load->library('amazon/S3');
        $data_file    = $_FILES['fileimagem'];
        $text         = $this->input->post('text',TRUE);

        if(!empty($text)){
            $text_timeline      = $text;
        }else{
            $text_timeline = NULL;
        }

        if(empty($data_file)) {
            $this->response(['error',['msg'=>'Selecione um a imagem!']]);
        }else{
            if ($data_file->size > 10000000) {
                $this->response('error', ['msg' => 'Tamanho de arquivo deve ser de no máximo 5MB']);
                exit();
            }
            $bucket_name  = 'atos.click';
            $s3           = new S3();
            $hash         = uniqid(rand()).date("Y-m-d H:i:so");
            $data_user    = $this->session->get_userdata();
            $get_usuarios  = $this->mongodb->atos->us_usuarios->find(['login'=>$data_user['login']]);

            foreach($get_usuarios as $get_usuario) {

                $search         = ["(", ")", ".", "-", " ", "X", "*", "!", "@", "'", "´", ",", "+", ":"];
                $name_replace   = str_replace($search, "", $hash);
                $name_file      = $name_replace . md5($get_usuario['login']);

                $data_file['name'] = $name_file;

                $s3->putBucket($bucket_name);
                $name_folder_user = $get_usuario['nome'] . md5($get_usuario['login']);

                if ($s3->putObjectFile($data_file['tmp_name'], $bucket_name, $name_folder_user . '/' . $name_file, S3::ACL_PUBLIC_READ)) {

//                        $us_storage     = $this->mongodb->atos->us_storage;
                    $us_storage_img = $this->mongodb->atos->us_storage_img;
                    $us_storage_img->insertOne([
                        'server_name'    => 'https://s3.amazonaws.com/',
                        'text_timeline'  => $text_timeline,
                        'bucket'         => $bucket_name,
                        'folder_user'    => $name_folder_user,
                        'name_file'      => $name_file,
                        'codusuario'     => $get_usuario['_id'],
                        'created_at'     => date('Y-m-d H:i:s'),
                        'updated_at'     => date('Y-m-d H:i:s'),


                    ]);
                    $path = 'https://s3.amazonaws.com/' . $bucket_name . '/' . $name_folder_user . '/' . $name_file;
                    $this->response('success', compact('path'));

                } else {
                    $this->response('error', ['msg' => 'Erro ao baixar a imagem para o servidor!']);
                }
            }
        }
    }
    /**
     * Postagens apenas do usuário logado (Própria timeline) ou quando visita usuário
    **/
    public function get_storage_img(){
        $id_external    = $this->input->post("id",true);
        $user_logado    = $this->data_user();
        $get_usuario    = $this->mongodb->atos->us_usuarios->find(['login'=>$user_logado['login']]);

        if(!empty($id_external)){
            $get_usuario    = $this->mongodb->atos->us_usuarios->find(['_id'=>$id_external]);
        }

        foreach ($get_usuario as $row_usuarios) {
            $us_storage_img     = $this->mongodb->atos->us_storage_img;
            $options            = ["sort" => ["created_at" => -1]];
            $data_time_line     = $us_storage_img->find(['codusuario' => $row_usuarios['_id']], $options);
            $data               = [];
            $row['img_profile'] = false;

            foreach ($data_time_line as $row) {
                $find_img   =  reset($this->Us_storage_img_profile_model->getWhereMongo(['codusuario'=>$row_usuarios['_id']],$orderby = "created_at",$direction =  -1,$limit = NULL,$offset = NULL));
                $imgprofile =  $find_img['server_name'] . $find_img['bucket'] . '/' . $find_img['folder_user'] . '/' . $find_img['name_file'];
                $url        = $row['server_name'] . $row['bucket'] . '/' . $row['folder_user'] . '/' . $row['name_file'];
                $text       = $row['text_timeline'];
                $name_user  = $row_usuarios['nome'];

                $data_row = [
                    'path'        => $url,
                    'text'        => $text,
                    'nome'        => $name_user,
                    'img_profile' => $imgprofile
                ];
                array_push($data, $data_row);

            }
        }

        $this->response('success',compact('data'));

    }
    /**
     * Postagens do usuário logado e seus amigos(se tiver)
     **/
    public function get_postagens(){
        $data_user      = $this->session->get_userdata();
        $get_usuario    = $this->mongodb->atos->us_usuarios->find(['login'=>$data_user['login']]);

        foreach ($get_usuario as $row_usuarios) {
            $us_storage_img     = $this->mongodb->atos->us_storage_img;
            $options            = ["sort" => ["created_at" => -1]];
            $data_time_line     = $us_storage_img->find(['codusuario' => $row_usuarios['_id']], $options);
            $data               = [];
            $row['img_profile'] = false;

            foreach ($data_time_line as $row) {
                $find_img   =  reset($this->Us_storage_img_profile_model->getWhereMongo(['codusuario'=>$row['_id']],$orderby = "created_at",$direction =  -1,$limit = NULL,$offset = NULL));
                $imgprofile =  $find_img['server_name'] . $find_img['bucket'] . '/' . $find_img['folder_user'] . '/' . $find_img['name_file'];
                $url        = $row['server_name'] . $row['bucket'] . '/' . $row['folder_user'] . '/' . $row['name_file'];
                $text       = $row['text_timeline'];
                $name_user  = $row_usuarios['nome'];

                $data_row = [
                    'path'        => $url,
                    'text'        => $text,
                    'nome'        => $name_user,
                    'img_profile' => $imgprofile
                ];
                array_push($data, $data_row);

            }
        }

        $this->response('success',compact('data'));

    }


}
