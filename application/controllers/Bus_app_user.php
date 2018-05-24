<?php
/* 
 * Generated by CRUDigniter v2.3 Beta 
 * www.crudigniter.com
 */
 
class Bus_app_user extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Bus_app_user_model');
        $this->load->model('User_model');
        $this->load->model('Bu_model');
        if(!$this->User_model->auth_session()){
            redirect('Login');
       }
    } 

    /*
     * Listing of bus_app_user
     */
    function index()
    {
        $data['page_title'] = 'Bus App User';
        
        $data['bus_app_user'] = $this->Bus_app_user_model->get_all_bus_app_user();
       // print_r($data);
//        echo $this->db->last_query();
//        exit();
      $this->load->view('bus_app_user/index',$data);
    }

    /*
     * Adding a new bus_app_user
     */
    function add()
    {   
         $data['page_title'] = 'Bus App User Adding';
         $data['bus_numbers'] = $this->Bu_model->get_all_bus();
        $this->load->library('form_validation');

		$this->form_validation->set_rules('bus_app_user_name','User Name','required');
		$this->form_validation->set_rules('bus_app_user_password','Password','required');
//		$this->form_validation->set_rules('bus_app_user_bus_id','Bus Number','required');
		
		if($this->form_validation->run())     
        {   
            $params = array(
				'bus_app_user_name' => $this->input->post('bus_app_user_name'),
				'bus_app_user_password' => $this->input->post('bus_app_user_password'),
				'bus_app_user_bus_id' => $this->input->post('bus_app_user_bus_id'),
//				'bus_user_status' => $this->input->post('bus_user_status'),
            );
            
            $bus_app_user_id = $this->Bus_app_user_model->add_bus_app_user($params);
            redirect('bus_app_user/index');
        }
        else
        {
            $this->load->view('bus_app_user/add',$data);
        }
    }  

    /*
     * Editing a bus_app_user
     */
    function edit($bus_app_user_id)
    {   
         $data['page_title'] = 'Bus App User Editing';
         $data['bus_numbers'] = $this->Bu_model->get_all_bus();
        // check if the bus_app_user exists before trying to edit it
        $bus_app_user = $this->Bus_app_user_model->get_bus_app_user($bus_app_user_id);
        
        if(isset($bus_app_user['bus_app_user_id']))
        {
            $this->load->library('form_validation');

			$this->form_validation->set_rules('bus_app_user_name','User Name','required');
		$this->form_validation->set_rules('bus_app_user_password','Password','required');
		
			if($this->form_validation->run())     
            {   
                $params = array(
					'bus_app_user_name' => $this->input->post('bus_app_user_name'),
					'bus_app_user_password' => $this->input->post('bus_app_user_password'),
					'bus_app_user_bus_id' => $this->input->post('bus_app_user_bus_id'),
//					'bus_user_status' => $this->input->post('bus_user_status'),
                );

                $this->Bus_app_user_model->update_bus_app_user($bus_app_user_id,$params);            
                redirect('bus_app_user/index');
            }
            else
            {   
                $data['bus_app_user'] = $this->Bus_app_user_model->get_bus_app_user($bus_app_user_id);
    
                $this->load->view('bus_app_user/edit',$data);
            }
        }
        else
            show_error('The bus_app_user you are trying to edit does not exist.');
    } 

    /*
     * Deleting bus_app_user
     */
    function remove($bus_app_user_id)
    {
         $data['page_title'] = 'Bus App User Deleting';
         
        $bus_app_user = $this->Bus_app_user_model->get_bus_app_user($bus_app_user_id);

        // check if the bus_app_user exists before trying to delete it
        if(isset($bus_app_user['bus_app_user_id']))
        {
            $this->Bus_app_user_model->delete_bus_app_user($bus_app_user_id);
            redirect('bus_app_user/index');
        }
        else
            show_error('The bus_app_user you are trying to delete does not exist.');
    }
    
  function change_status()
    {
      $bus_app_user_id =  $this->uri->segment(3);
      $bus_user_status =  $this->uri->segment(4);
         if($bus_user_status==0)
         {
             $status=1;
         }
         else
         {
             $status=0;
         }
      // echo $status;
        // check if the child exists before trying to update it
        if($bus_app_user_id)
        {
           $this->Bus_app_user_model->status_bus_app_user($bus_app_user_id,$status);
            redirect('bus_app_user/index');
        }
        else
            show_error('The child you are trying to delete does not exist.');
    }
}
