<?php
namespace Service\Modules\Mongo;

class MongoDb extends \SI_Controller
{
    public $mongodb;
    public $mongomanager;
    public $mongobulkwrite;
    public function __construct(){
        parent::__construct();

        $this->load_helpers();
        $this->conect_mongodb();
    }

}