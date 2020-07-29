<?php
namespace Services;

class GeneralService extends \CI_Model {

    public  function __construct(){
        parent::__construct();
    }
    static public function Success( $data )
    {
        $info = ['info'=>1];

        if(!$data){
            $data = NULL;
            echo json_encode($info);
            exit();
        }

        array_push($data,$info);

        echo json_encode($data);
        exit();
    }
    static public function Error( $data )
    {
        $info = [ 'info'=>0 ];
        if( !$data ){
            $data = NULL;
            echo json_encode( $info );
            exit();
        }
        array_push( $data,$info );

        echo json_encode( $data );
        exit();


    }
}
