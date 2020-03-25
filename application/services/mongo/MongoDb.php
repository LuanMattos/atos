<?php
namespace Service\Modules\Mongo;


include '../GeneralService.php';
use Service\GeneralService;


class MongoDb extends GeneralService
{
    public $mongodb;
    public $mongomanager;
    public $mongobulkwrite;
    public function __construct(){
        $this->load_helpers();
        $this->conect_mongodb();
    }

}