<?php
class database_chat  {


    public function config_mongo($shell = false){
        $hostname = "mongo";

        if($shell){
            $hostname = "localhost";
        }

        return  [
            'hostname'      => 'mongo',
            'port'          => '27017',
            'username'      => 'atos',
            'password'      => 'atos',
            'database'      => 'atos'
        ];
    }
}
