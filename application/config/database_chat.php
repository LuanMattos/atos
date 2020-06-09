<?php
class database_chat  {


    public function config_mongo($shell = false){
        $hostname = "172.18.0.2";
//        if(ENVIRONMENT === 'production'){
//            $hostname = '172.18.0.2';
//        }else{
//            $hostname = 'mongo';
//        }

        if($shell){
            $hostname = "localhost";
        }
//        172.18.0.2

        return  [
            'hostname'      => $hostname,
            'port'          => '27017',
            'username'      => 'atos',
            'password'      => 'atos',
            'database'      => 'atos'
        ];
    }
}
