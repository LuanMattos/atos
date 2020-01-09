<?php
class Shell extends CI_Controller{

    public function __construct(){
        parent::__construct();
    }
    public function index(){

    }
    public function install_apache(){
        shell_exec('sudo apt-get install apache2');
    }
    public function php(){
        shell_exec('sudo apt-get -y purge php.*');
        shell_exec('sudo apt install php-pgsql');
        shell_exec('sudo apt install argon2 libargon2-0 libargon2-0-dev');
        shell_exec('sudo apt-get install php-xml');
        shell_exec('sudo apt-get install php libapache2-mod-php');
        shell_exec('cd /etc/apache2/mods-available');
        shell_exec('a2enmod rewrite');
        shell_exec('cd');
        shell_exec('sudo apt-get install curl');
        shell_exec('sudo apt-get install php-curl');
        shell_exec('sudo apt install php-mongodb');

    }
    public function install_mongo_ubuntu(){
        shell_exec('sudo apt-get install php7.0-mbstring');
        shell_exec('wget -qO - https://www.mongodb.org/static/pgp/server-4.2.asc | sudo apt-key add -');
        shell_exec('sudo apt-get install gnupg');
        shell_exec('wget -qO - https://www.mongodb.org/static/pgp/server-4.2.asc | sudo apt-key add -');
        shell_exec('echo "deb [ arch=amd64 ] https://repo.mongodb.org/apt/ubuntu bionic/mongodb-org/4.2 multiverse" | sudo tee /etc/apt/sources.list.d/mongodb-org-4.2.list');
        shell_exec('sudo apt-get update');
        shell_exec('sudo apt-get install -y mongodb-org');
        shell_exec('sudo service mongod start');
//        executar dentro da pasta do projeto
//        composer require mongodb/mongodb --ignore-platform-reqs

    }


}
