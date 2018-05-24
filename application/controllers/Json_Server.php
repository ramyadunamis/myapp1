<?php

class Json_Server extends CI_Controller {

    var $permission = array();

    public function __construct() {
        parent::__construct();
        $this->load->model('common_model');
        header('Content-Type: application/json');
        
    }
    function get_server() {
                
         $output=$this->common_model->get_server_parent_app();
            echo json_encode($output);
    }
    function get_production_server() {
                
        $output=$this->common_model->get_production_server_parent_app();
            echo json_encode($output);
    }
    
    function get_server_supervisor() {
                
         $output=$this->common_model->get_server_supervisor_app();
            echo json_encode($output);
    }
    function get_production_server_supervisor() {
                
        $output=$this->common_model->get_production_server_supervisor_app();
            echo json_encode($output);
    }
    
    function get_server_time() {
                
        $output['current_time']=date('Y-m-d H:i:s');
        echo json_encode($output);
    }
    
        
}

?>
