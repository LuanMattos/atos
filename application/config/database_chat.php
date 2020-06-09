<?php
class database_chat  {


    public function config_mongo($shell = false){
        $hostname = "mongo";

        if($shell){
            $hostname = "localhost";
        }

        return  [
            'hostname'      => '172.18.0.2',
            'port'          => '27017',
            'username'      => 'atos',
            'password'      => 'atos',
            'database'      => 'atos'
        ];
    }
}
