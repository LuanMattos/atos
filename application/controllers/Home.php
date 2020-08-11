<?php
use Modules\Account\RestoreAccount\RestoreAccount as RestoreAccount;
use Modules\Register\RegisterMeService;
use Libraries\Amazon;

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Home_Controller
{

    public function __construct(){
        parent::__construct();
        $this->load->model("Us_usuarios_model");
        $this->load->model("usuarios/Us_amigos_model");
        $this->load->model("storage/img/Us_storage_img_profile_model");
        $this->load->model("location/Us_location_user_model");
        $this->load->model('account/Us_usuarios_conta_model');
        $this->load->model('storage/img/Us_storage_img_model');
        $this->output->enable_profiler(FALSE);
        $this->load->library('email/mail');

    }

    public function index(){
//        debug(password_hash("kvmxea", PASSWORD_DEFAULT));//criptografa a sessão
        $datasession    = $this->session->get_userdata();

        if( ENVIRONMENT === 'production' ){
            $sec = [];
            $sec['HTTP_CLIENT_IP'] = isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : '';
            $sec['HTTP_CLIENT_IP'] = isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : '';
            $sec['HTTP_X_FORWARDED_FOR'] = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : '';
            $sec['REMOTE_ADDR'] = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
            $externalContent = file_get_contents('http://checkip.dyndns.com/');
            $cleanIp = strip_tags($externalContent);
            $ip_externo_clear = preg_replace("/[^0-9]/", "", $cleanIp);
            $sec['ip_external_1'] = $ip_externo_clear;
            $this->load->model('security/Access_login_model');
            $this->Access_login_model->save_mongo($sec);
        }

        if(isset($datasession['login'])){
            $data = $this->mongodb->atos->us_usuarios->find(['login'=>$datasession['login']]);
            foreach($data as $row){

                 $address = $this->Us_location_user_model->data_location_by_id($row['_id']);

                $data_user      = $this->data_user();
                $row['count_amigos'] = $data_user->count_amigos;

                if(!empty($address)):
                    $row['address']      = $address['formatted_address_google_maps'];
                 endif;
                $this->valida_login_code_confirmation($row);

                if($row['logado']):

                    $this->load->view('home',compact('row'));
                else:

                    if($row['permanecer_logado'] === false){

                        if($row['logado']):
                            $this->load->view('home',compact('row'));
                        else:
                            $this->session->sess_destroy();
                            redirect("go");
                        endif;

                    }elseif($row['permanecer_logado'] === true){
                        if($row['logado']):
                            $this->load->view('home',compact('row'));
                        else:
                            $this->session->sess_destroy();
                            redirect("go");
                        endif;

                    }else{
                        redirect('go');
                    }
                endif;
            }
        }else{
            $this->session->sess_destroy();
            redirect("go");
        }
//        var_dump(password_hash("kvmxea", PASSWORD_DEFAULT));//criptografa a sessão
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
            $this->load->view('search_full/index');
        }

    }

    public function register(){
        $this->load->view("register");
    }
    public function acao_cadastro(){

        $data           = (object)$this->input->post("data",TRUE);
        $RestoreAccount = new RestoreAccount();

        $mail  = new Mail();


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
//        if(empty($data->datanasc) || (strlen($data->datanasc) != 10)){
//            $error['datanasc'] = "Data de nascimento inválida!";
//        }else{
//            $data->datanasc = date_to_us($data->datanasc);
//        }
        if(empty($data->telcel)){
            $error['telcel'] = "Preencha o campo  telefone!";
        }
        $numero_validado    = validate_telcel_br($data->telcodpais . $data->telcel);

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
        if(empty($data->sobrenome) || empty($data->nome) || is_numeric($data->sobrenome)){
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

        $numero_validado    = validate_telcel_br($data->telcodpais . $data->telcel);
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

        if(ENVIRONMENT !== 'development'){
            $sms = new \ServiceSms\ServiceSms();
            $sms->processesDirect( $dataSms );
        }

        $this->Us_usuarios_model->save_mongo($data);

        $data_conta = [
            "code_verification" => $codigo_verificacao,
            "_id"               => $data['_id']
        ];


        $this->session->set_userdata(["verification_user"=>$data['email_hash'],"login"=>$data['login']], 1);
        $nome                       = ucfirst( $data['nome'] );
        $sobrenome                  = ucfirst( $data['sobrenome'] );
        $param = [];
        $param['from']              = 'account@atos.click';
        $param['to']                = $data['email'];
        $param['name']              = "Atos";
        $param['name_to']           = $data['nome'];
        $param['assunto']           = 'Ativação de conta Atos!';
        $data['codigo_confirmacao'] = $codigo_verificacao;
        $data['cadastro']           = true;
        $data['nome']               = $nome;
        $data['sobrenome']          = $sobrenome;

        $html = $this->load->view("email/confirme",$data,true);
        $param['corpo']      = '';
        $param['corpo_html'] = $html;
        $send = $mail->send( $param );

        if( $send ){
            $this->Us_usuarios_conta_model->save_mongo( $data_conta );

            try{
                new RegisterMeService\RegisterMeService( $data['email'] );
            }catch ( Exception $e ){
                $e->getMessage();
            }

            $this->response("success");
        }else{
            $error['erro_envio_email'] = "E-mail inválido, para criar uma conta, digite um E-mail válido!";
            $this->response("error",compact("error"));
        }
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
        redirect('go');

    }

    public function compute_like(){
        $id = $this->input->post('id',true);
        $user = (object)$this->data_user();

        $data = [
            "like" => [
                '_id'=>new \MongoDB\BSON\ObjectId( $user->_id )
            ]
        ];
        $liked    =  reset($this->Us_storage_img_model->getWhereMongo( ["_id" => new \MongoDB\BSON\ObjectId( $id ),'like._id'=>new \MongoDB\BSON\ObjectId( $user->_id )]));
        if( count($liked['like']) ){
            $this->Us_storage_img_model->save_sub_document( $data,["_id" => new \MongoDB\BSON\ObjectId( $id )],'$pull' );
            $this->response('success','dislike');

        }else{
            $data = [
                "like" => [
                    '_id'=>new \MongoDB\BSON\ObjectId( $user->_id ),
                    'created_at' => date('Y-m-d H:i:s')
                ]
            ];
            $this->Us_storage_img_model->save_sub_document( $data,["_id" => new \MongoDB\BSON\ObjectId( $id )] );
            $this->response('success','like');
        }
    }

    public function delete_time_line(){
        $id = $this->input->post("id",true);
        $user_local = $this->data_user();
        $validate = reset( $this->Us_storage_img_model->getWhereMongo( [ "_id" => new \MongoDB\BSON\ObjectId($id) ] ) );

        if($validate['codusuario'] === $user_local['_id']){
            $delete = $this->Us_storage_img_model->deleteWhereMongo( [ "_id" => new \MongoDB\BSON\ObjectId($id) ] );
            if(!$delete){
                $this->response('error');
            }
        }

        $this->response('success');

    }

    /**
     * Adiciona as imagens ao bucket da Amazon
    **/
    public function add_time_line(){
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
            $s3           = new Amazon\S3();
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

                if ($s3->putObjectFile($data_file['tmp_name'], $bucket_name, $name_folder_user . '/' . $name_file, Amazon\S3::ACL_PUBLIC_READ)) {

//                        $us_storage     = $this->mongodb->atos->us_storage;
                    $us_storage_img = $this->mongodb->atos->us_storage_img;
                    $id = $us_storage_img->insertOne([
                        'server_name'    => 'https://s3.amazonaws.com/',
                        'text_timeline'  => $text_timeline,
                        'bucket'         => $bucket_name,
                        'folder_user'    => $name_folder_user,
                        'name_file'      => $name_file,
                        'codusuario'     => $get_usuario['_id'],
                        'created_at'     => date('Y-m-d H:i:s'),
                        'updated_at'     => date('Y-m-d H:i:s'),
                        'like'           => [],
                    ]);
                    $id   = reset($id->getInsertedId());
                    $path = 'https://s3.amazonaws.com/' . $bucket_name . '/' . $name_folder_user . '/' . $name_file;
//                    $return = [];
//                    $return['text_timeline'] = $text_timeline;
                    $img_profile = $this->data_user()['img_profile'];
                    $this->response('success', compact('path','id','text_timeline','img_profile'));

                } else {
                    $this->response('error', ['msg' => 'Erro ao baixar a imagem para o servidor!']);
                }
            }
        }
    }
    /**
     * Retorna postagens
    **/
    public function get_storage_img(){
        $timeline       = $this->input->post('timeline',true);
        $lim            = $this->input->post('limit',true);
        $limit          = $lim?(integer)$lim:10;
        $off            = $this->input->post('offset',true);
        $offset         = $off?$off:0;

        $id_external    = $this->input->post("id",true);
        $user_logado    = $this->data_user();
        $get_usuario    = $this->mongodb->atos->us_usuarios->find(['login'=>$user_logado['login']]);

        $ids = [0=>$user_logado['_id']];


        if(!empty($id_external)){
            $get_usuario    = $this->mongodb->atos->us_usuarios->find(['_id'=>$id_external]);
            $ids = [0=>$id_external];

        }

        if( $timeline ){
            $limit = (integer)$limit;
            $amigos =  $this->Us_amigos_model->getWhereMongo( ['_id'=>$user_logado['_id']],"_id",-1,NULL,NULL,TRUE );

            if( $amigos ){
                foreach ( $amigos['amigos'] as $row_amizades ) {
                    array_push($ids,reset($row_amizades['_id']));
                }
            }
        }


        foreach ($get_usuario as $row_usuarios) {
            $us_storage_img     = $this->mongodb->atos->us_storage_img;
            $options            = ["sort" => ["created_at" => -1],'limit'=>$limit, 'skip'=>(integer)$offset];
            $data_time_line     = $us_storage_img->find(['codusuario'=>['$in'=>$ids]], $options);

            $data               = [];
            $row['img_profile'] = false;

            foreach ($data_time_line->toArray() as $row) {

                $find_img   = $this->Us_storage_img_profile_model->getWhereMongo(['codusuario'=>$row['codusuario']],"created_at",-1 ,1 ,NULL,TRUE);

                $imgprofile = !empty($find_img['server_name'])?$find_img['server_name'] . $find_img['bucket'] . '/' . $find_img['folder_user'] . '/' . $find_img['name_file']:false;
                $url        = !empty($row['server_name'])?$row['server_name'] . $row['bucket'] . '/' . $row['folder_user'] . '/' . $row['name_file']:false;
                $text       = $row['text_timeline'];
                $name_user  = $this->Us_usuarios_model->getWhereMongo(['_id'=>$row['codusuario']],"created_at",-1 ,1 ,NULL,TRUE);
                $liked      = false;
                foreach($row['like'] as $line){
                    if(reset($line['_id']) === $user_logado['_id']){
                        $liked = true;
                    }
                }
                $delete = true;
                if($row['codusuario'] !== $user_logado['_id']){
                    $delete = false;
                }

                $data_row = [
                    '_id'         => reset($row['_id']),
                    'path'        => $url,
                    'text'        => $text,
                    'nome'        => $name_user['nome'],
                    'img_profile' => $imgprofile,
                    'like'        => $row['like']  ? $row['like'] : [],
                    'id_local'    => $user_logado['_id'],
                    'count_like'  => count($row['like']),
                    'liked'       => $liked,
                    'delete'      => $delete,
                    'created_at'  => $find_img['created_at']

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
                $imgprofile =  !empty($find_img['server_name'])?$find_img['server_name'] . $find_img['bucket'] . '/' . $find_img['folder_user'] . '/' . $find_img['name_file']:false;
                $url        = !empty($row['server_name'])?$row['server_name'] . $row['bucket'] . '/' . $row['folder_user'] . '/' . $row['name_file']:false;
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

    public function buscar(){
        $data_session   = $this->data_user();
        $datapost       = $this->input->post('search',true);
        $datapost       = strtolower( $datapost );
        $datapost       = $this->clear_car( $datapost );
        $searchQuery    = array(
              '$or' => array(
                array(
                    'nome' => new \MongoDB\BSON\Regex( $datapost )
                ),
                array(
                    'sobrenome' => new \MongoDB\BSON\Regex( $datapost ),
                ),
            ),"_id"=>['$nin' => [0=>$data_session->_id]]
        );

        $data = $this->Us_usuarios_model->getWhereMongo($searchQuery,$orderby = "created_at",$direction =  -1,$limit = 8,$offset = NULL);

        foreach ($data as $row) {
            $find_img   =  reset($this->Us_storage_img_profile_model->getWhereMongo(['codusuario'=>$row['_id']],$orderby = "created_at",$direction =  -1,$limit = NULL,$offset = NULL));
            $imgprofile =  !empty($find_img['server_name'])?$find_img['server_name'] . $find_img['bucket'] . '/' . $find_img['folder_user'] . '/' . $find_img['name_file']:false;

            $row['img_profile'] = $imgprofile;

        }

        $this->response('success',compact( 'data' ) );

    }

    public function error_404(){
        $this->load->view('errors/404');
    }

}
