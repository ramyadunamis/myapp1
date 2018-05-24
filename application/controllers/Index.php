<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {

    public function __construct() {
        parent::__construct();
         $this->load->model('User_model');
//        if(!$this->User_model->auth_session()){
//            redirect('Login');
//       }
        
        $this->load->model('Bu_model');
        $this->load->model('Trip_model');
        $this->load->model('Tracking_model');
        $this->load->model('Attendance_model');
        $this->load->model('Parent_app_user_model');
        $this->load->model('Child_model');
        $this->load->model('Access_log_model');
         $this->load->model('Setting_model');
        
    }

    public function index() {
        $data['page_title'] = 'Lokate Student-SAFETY';
        $this->load->view('theme_skeliton',$data);
    }
    

    public function dashboard() {
       $data['page_title'] = 'Lokate Student-SAFETY';
       $data['msg'] = '';
       
        $settings = $this->Setting_model->get_all_settings();
                 $is_truncate='No';
                 foreach ($settings as $key => $value) {
                       $is_truncate = $value['truncate'];
                        }
               
         $data['is_truncate']=$is_truncate;
         $data['signed']=$this->Parent_app_user_model->signedup_count();
         $data['notsigned']=$this->Parent_app_user_model->count();
         $data['child']=$this->Child_model->count();
         $data['count_parents']=$this->Parent_app_user_model->count_parents();
         $data['count_buses']=$this->Bu_model->count();
         $data['access_log']=$this->Access_log_model->count_log();
         $data['total_devices']=$this->Access_log_model->count_devices();
        // echo $this->db->last_query(); exit();
        
       
       if($this->input->post('submit')){
          
           $this->db->truncate('Attendance');
           $this->db->truncate('Notification');
           $this->db->truncate('Finish_trip_details');
           $data['msg'] = 'Db cleared';
       }
       
        if($this->input->post('track')){
          
           $this->db->truncate('Tracking');
          $data['msg'] = 'Tracking Table cleared';
       }
       
        if($this->input->post('clear_school_attendance')){
          
           $this->db->truncate('School_attendance');
          $data['msg'] = 'School Attendance Table cleared';
       }
       
       
       if($this->input->post('finish_trip')){
           
         $running_buses= $this->Bu_model->get_running_buses();   
        foreach($running_buses as $value)
        {
         $params = array(
               
					'finish_bus_id' => trim($value['bus_id']),
					'finish_trip_id' => trim($value['bus_current_trip_id']),
					 );
             
            $insert_finish_trip_table=$this->Trip_model->insert_finish_trip_details($params);  
            
            $change_status_running_buses= $this->Bu_model->update_bus_running_satus($value['bus_id']); 
//             echo $this->db->last_query();
//            exit();
        }
           
          $data['msg'] = 'All trips are Finished';
       }
       
       

        if($this->input->post('copy_tacking_table')){
            $copy_table=$this->Tracking_model->copy_and_save_values_before_7();
            $delete=$this->Tracking_model->delete_values_before_7(); 
            $data['msg'] = 'Tracking data cleared( Before one week)';
        }

      
        
         if($this->input->post('copy_attendance_table')){
            $copy_table=$this->Attendance_model->copy_and_save_values_before_7();
             $delete=$this->Attendance_model->delete_values_before_7(); 
             $data['msg'] = 'Attendance data cleared( Before one week)';
        }
         if($this->input->post('clear_push_msg')){
          
           $this->db->truncate('Push_msg_map');
          $data['msg'] = "Push Message Id's cleared"; 
       }
        
        
     $this->load->view('dashboard',$data);
    }

    
}
