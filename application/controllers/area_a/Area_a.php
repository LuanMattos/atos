<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Services\Modules\Area_a as area;

class Area_a extends SI_Controller
{

    protected $Area_a_Service;

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Us_usuarios_model");
        $this->load->model("location/Us_location_user_model");
        $this->load->model('storage/img/Us_storage_img_profile_model');
        $this->output->enable_profiler(FALSE);
        $this->load->helper("cookie");
        $this->load->helper("url");
        $this->Area_a_Service = new area\Area_a_Service();

    }

    public function get_img()
    {
        $datapost = (object)$this->input->post(null, TRUE);

        $this->Area_a_Service->get_img($datapost->type, $datapost->id);
    }

    public function data_user_local()
    {
        $data = $this->data_user();
        $this->response('success', compact("data"));
    }

    public function update_img_cover()
    {
        $data_file = $_FILES['fileimagemcover'];
        $this->Area_a_Service->update_img_cover($data_file);
    }

    public function zerar_notificacoes_menu()
    {
        $datapost = $this->input->post('data', TRUE);
        $this->config->load('database');
        $configmongo = (object)$this->config->item('mongodb');
        $local = $this->data_user();

        foreach ($datapost as $row) {
            $data = [];
            $data['notified'] = true;
            $mongobulkwrite = new \MongoDB\Driver\BulkWrite();
            $mongobulkwrite->update(["codusuario" => $row['_id'], 'codamigo' => $local['_id']], ['$set' => $data], ['multi' => false, 'upsert' => false]);
            $this->mongomanager->executeBulkWrite($configmongo->database . '.' . 'us_amigos_solicitacoes', $mongobulkwrite);
        }

    }

}
