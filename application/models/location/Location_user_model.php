<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Location_user_model extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        $this->set_table_index("codigo");
        $this->set_table("location_user");
    }


}
