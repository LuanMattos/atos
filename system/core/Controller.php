<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class CI_Controller
{

    /**
     * Reference to the CI singleton
     *
     * @var    object
     */
    private static $instance;

    /**
     * Class constructor
     *
     * @return    void
     */
    public function __construct()
    {
        self::$instance =& $this;

        // Assign all the class objects that were instantiated by the
        // bootstrap file (CodeIgniter.php) to local class variables
        // so that CI can run as one big super object.
        foreach (is_loaded() as $var => $class) {
            $this->$var =& load_class($class);
        }

        $this->load =& load_class('Loader', 'core');
        $this->load->initialize();
        log_message('info', 'Controller Class Initialized');
    }


    /**
     * Get the CI singleton
     *
     * @static
     * @return    object
     */
    public static function &get_instance(){
        return self::$instance;
    }

    public function response($type="",$data = NULL){

        if($type === "success"){
            $info = ['info'=>1];
        }elseif($type === "error"){
            $info = ['info'=>0];
        }
        if(!$data){
            $data = NULL;
            echo json_encode($info);
            exit();
        }

        array_push($data,$info);

        echo json_encode($data);
        exit();

    }


}
