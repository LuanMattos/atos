<?php
namespace Service\Modules\Mongo;

class MongoDb
{
    public $mongodb;
    public $mongomanager;
    public $mongobulkwrite;
    public function __construct(){
        $this->load_helpers();
        $this->conect_mongodb();
    }

}