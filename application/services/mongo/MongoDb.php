<?php
namespace Service\Modules\Mongo;

class MongoDb extends \CI_Model
{
    public $mongodb;
    public $mongomanager;
    public $mongobulkwrite;
    public function __construct(){
        $this->load_helpers();
        $this->conect_mongodb();
    }

}