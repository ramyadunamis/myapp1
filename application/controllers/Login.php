<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Login
 *
 * @author dunamis
 */
class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
       // $this->load->library('session');
    }

    public function index() {
        $data['page_title'] = 'Lokate Student';
        $this->load->view('Login_index',$data);
    }
    public function LoginCheck() {

         $data['page_title'] = 'Lokate Student';
          $data = array(
                        'Username' => $this->input->post('Username'),
                        'Password' => $this->input->post('Password'),
                            );
        if( $this->user_model->auth($data)){
	
                redirect("index/dashboard");
	
        }else{
                   
           $this->session->set_flashdata('msg','Invalid Username or Password');
            redirect("Login");
        }
    }
    public function Logout() {
        $this->user_model->logout();
         redirect("Login"); 
    }
}
