<?php

class Json_supervisor extends CI_Controller {

    var $permission = array();

    public function __construct() {
        parent::__construct();
        $this->load->model('Trip_model');
        $this->load->model('Bu_model');
        $this->load->model('Bus_app_user_model');
        $this->load->model('Parent_app_user_model');
        $this->load->model('Child_model');
        $this->load->model('Tracking_model');
        $this->load->model('Attendance_model');
        $this->load->model('Push_msg_map_model');
        $this->load->model('Notification_model');
        $this->load->model('common_model');
        $this->load->model('Finish_trip_detail_model');
        $this->load->model('Logo_image_model');
        $this->load->model('Supervisor_app_user_model');
        $this->load->model('Setting_model');
        $this->load->model('Summery_model');

        header('Content-Type: application/json');
    }

// authentication from app



    public function supervisor_bus_details() {
        //  { "child_id": "2"  }

        $data = $this->input->post('data');
        $data = stripslashes($data);
        $json_data = json_decode($data);
        $login_id = $json_data->login_id;
//       $data = array('status' => 'success');
        if ($login_id) {
            
              $data = array('status' => 'success');
            $running_satus = 'running';
            //$data['bus_list'] = $this->Bu_model->get_bus_by_running_status($running_satus);
            $data['bus_list'] = $this->Bu_model->get_all_bus();
//           echo $this->db->last_query();exit();
            $i = 0;
             $settings = $this->Setting_model->get_lati_longi();
             $school_lati=$settings['school_latitude'];
             $school_longi=$settings['school_longitude'];
            $this->load->helper('map');
            if ($data['bus_list']) {
                foreach ($data['bus_list'] as $key => $bus) {

                    $trip_details = $this->Trip_model->get_trip($bus['bus_current_trip_id']);
                    $attendance = $this->Attendance_model->get_attendance_count_by_bus_id($bus['bus_id'], $bus['bus_current_trip_id'], $bus['bus_child_pickup_or_drop_off']);
                  //  echo $this->db->last_query();exit();
                    $total_child_list_count = $this->Child_model->get_total_count_child_trip($bus['bus_current_trip_id']);
                    // echo $this->db->last_query();exit();
                   
                     //echo $settings['school_latitude'];
                    
                    if($trip_details['trip_desc'])
                    $data['bus_list'][$i]['trip_name'] = $trip_details['trip_desc'];
                else {
                     $data['bus_list'][$i]['trip_name'] ="";
                }
                    $data['bus_list'][$i]['trip_pickedup'] = $attendance['count'];
                    $data['bus_list'][$i]['trip_total_no'] = $total_child_list_count['count'];
                    
                   

                    //$school_lati = "9.959855";
                    //$school_longi = "76.289505";
                    
                    $tracking = $this->Attendance_model->last_known_location_by_busn_id($bus['bus_id'], $bus['bus_current_trip_id']);
                    if(!empty($tracking)){
                            if($tracking['tracking_lati']!=0 and $tracking['tracking_logi'] !=0){
                               $data['bus_list'][$i]['distance'] = distance($school_lati, $school_longi, $tracking['tracking_lati'], $tracking['tracking_logi'], "K");
                               $data['bus_list'][$i]['distance'] = round($data['bus_list'][$i]['distance'], 1) . ""; 
                            } else {
                               $data['bus_list'][$i]['distance'] =""; 
                            }
                    }else {
                        $data['bus_list'][$i]['distance'] ="";  
                    }

                    $i++;
                }
                 $data['version_details']=$this->common_model->supervisor_app_version();
                
            } else {
                $data = array('status' => 'fail', 'error' => '117', 'msg' => 'There are no trips running at this time. Please check back later.');
            }
           $settings = $this->Setting_model->get_all_settings();
           foreach ($settings as $key => $value) {
            $data ['card_scan_type'] = $value['card_scan_type'];
            }
               
            echo json_encode($data);
        } else {
            $data = array('status' => 'fail', 'error' => '117', 'msg' => 'wrong login');
        }
    } 

    public function supervisor_bus_child_details() {
           $output = array('status' => 'success');
         $show=array();
        $data = $this->input->post('data');
        $data = stripslashes($data);
        $json_data = json_decode($data);
       $bus_id = $json_data->bus_id;
        $bus_current_trip_id = $json_data->bus_current_trip_id;
//        $output['to_show']=$show;
          $settings = $this->Setting_model->get_lati_longi();
                      $school_lati=$settings['school_latitude'];
                     $school_longi=$settings['school_longitude'];
       
//             $data['bus_list'] 
            $bus_running= $this->Bu_model->get_bu($bus_id);
          // echo $this->db->last_query();exit();
             $this->load->helper('map');
                    $trip_details = $this->Trip_model->get_trip($bus_current_trip_id);
                    
                    $attendance = $this->Attendance_model->get_attendance_count_by_bus_id($bus_id, $bus_current_trip_id, $bus_running['bus_child_pickup_or_drop_off']);
               //  echo $this->db->last_query();exit();
                    $total_child_list_count = $this->Child_model->get_total_count_child_trip($bus_current_trip_id);
                       $show['bus_name'] = $bus_running['bus_name'];
                        if($json_data->bus_current_trip_id==$bus_running['bus_current_trip_id'] and $bus_running['bus_running_satus']=='running') {
                             $running_satus = 'running';
                        }else {
                              $running_satus = 'not running';
                        }
           
                       
                       
                       $show['bus_running_satus'] = $bus_running['bus_running_satus'];
                       $show['driver_name'] = $bus_running['driver_name'];
                       $show['driver_assistant'] = $bus_running['driver_assistant'];
                       $show['driver_phone'] = $bus_running['driver_phone'];
                       $show['assistant_phone'] = $bus_running['assistant_phone'];
                       $show['bus_child_pickup_or_drop_off'] = $bus_running['bus_child_pickup_or_drop_off'];
                       $pickup_or_drop_off = $bus_running['bus_child_pickup_or_drop_off'];
                       if($trip_details['trip_desc']!='')
                       $show['trip_name'] = $trip_details['trip_desc'];
                       else
                       $show['trip_name'] = "";
                       $show['trip_pickedup'] = $attendance['count'];
                       $show['trip_total_no'] = $total_child_list_count['count'];
                       
                       
                   
 
                    //$school_lati = "9.959855";
                    //$school_longi = "76.289505";
                    $tracking = $this->Attendance_model->last_known_location_by_busn_id($bus_id, $bus_current_trip_id);

                   
                  //echo $this->db->last_query();exit(); 
                    
                    if($tracking['tracking_lati']!=0 and $tracking['tracking_logi'] !=0){
                    $show['distance'] = distance($school_lati, $school_longi, $tracking['tracking_lati'], $tracking['tracking_logi'], "K");
                    $show['distance'] = round($show['distance'], 1) . ""; 
                            } else {
                              $show['distance']  =""; 
                            }
                   $output['to_show']=$show;
                     $trip_type=$trip_details['trip_type'];
                     //------------------------------
        $child_bus = $this->Child_model->bus_child_details_pickup($bus_current_trip_id,$pickup_or_drop_off,$trip_type);  
 // echo $this->db->last_query();exit();
         
        $child_bus_not_present = $this->Child_model->bus_child_details_not_present($bus_current_trip_id,$pickup_or_drop_off,$trip_type);
        
        //  echo $this->db->last_query();exit();
   
        $child_bus_absent = $this->Child_model->bus_child_details_absent($bus_current_trip_id,$pickup_or_drop_off);
    //    echo $this->db->last_query();exit();
        $onbus=array();
       if($child_bus!=''){
           
        foreach($child_bus as $val)
        {
         $onbus[]= $val['child_name'] ; 
        }
         $output['on_bus'] = $onbus;
         }
         else {
             $output['on_bus'] = [];
        }
         
        if($child_bus_not_present){
         foreach($child_bus_not_present as $val2)
        {
         $notonthebus[]= $val2['child_name'] ; 
        }
         $output['not_on_the_bus'] = $notonthebus;
        }
        else {
         $output['not_on_the_bus'] = [];
        }
        
         if($child_bus_absent){
         foreach($child_bus_absent as $val1)
        {
         $absenttoday[]= $val1['child_name'] ; 
        }
        
        
         $output['absent_today'] = $absenttoday;
         }
        else {
             $output['absent_today'] = []; 
        }
      
        
        
        
        
        
        
        $date=date("Y/m/d");
        $time_stamp= date('Y-m-d', strtotime($date));
        
    /* $data1 = $this->Child_model->bus_child_details_pickup_report_pickup_json_supervisor($bus_current_trip_id,$time_stamp,$pickup_or_drop_off); 
//    echo $this->db->last_query();exit();
       for($j=0;$j<count($data1);$j++)
        {
         $child_id_pick=$data1[$j]['child_id'];
        $data2 = $this->Child_model->bus_child_details_pickup_report_dropoff_json_supervisor($bus_current_trip_id,$time_stamp,$pickup_or_drop_off); 
       // echo $this->db->last_query();exit();
         for($k=0;$k<count($data2);$k++)
        {
              $child_id_drop=$data2[$k]['child_id'];
              $child_id_time=$data2[$k]['at_time_stamp'];
        
   
        if($child_id_pick==$child_id_drop)
        {
          $data1[$j]['at_time_stamp_device']=$child_id_time;
        }
         }
     }
     
     */
     $data_for_time =$this->Child_model->bus_child_details_for_time($bus_current_trip_id,$time_stamp,$pickup_or_drop_off); 
    // echo $this->db->last_query();exit();
     $time=new ArrayObject();
         foreach($data_for_time as $super)
        {
             
             $time[$super['child_name']]= $super['at_time_stamp'] ;

        }
       
        $output['time'] = $time;

        
      echo json_encode($output);

    }
    
      public function supervisor_bus_child_details_for_map() {  
          
           $output = array('status' => 'success');
         $show=array();
        $data = $this->input->post('data');
        $data = stripslashes($data);
        $json_data = json_decode($data);
       $bus_id = $json_data->bus_id;
        $bus_current_trip_id = $json_data->bus_current_trip_id;
//        $output['to_show']=$show;
          $settings = $this->Setting_model->get_lati_longi();
                      $school_lati=$settings['school_latitude'];
                     $school_longi=$settings['school_longitude'];
       
//             $data['bus_list'] 
            $bus_running= $this->Bu_model->get_bu($bus_id);
          // echo $this->db->last_query();exit();
             $this->load->helper('map');
                    $trip_details = $this->Trip_model->get_trip($bus_current_trip_id);
                    
                    $attendance = $this->Attendance_model->get_attendance_count_by_bus_id($bus_id, $bus_current_trip_id, $bus_running['bus_child_pickup_or_drop_off']);
               //  echo $this->db->last_query();exit();
                    $total_child_list_count = $this->Child_model->get_total_count_child_trip($bus_current_trip_id);
                       $show['bus_name'] = $bus_running['bus_name'];
                        if($json_data->bus_current_trip_id==$bus_running['bus_current_trip_id'] and $bus_running['bus_running_satus']=='running') {
                             $running_satus = 'running';
                        }else {
                              $running_satus = 'not running';
                        }                                
                        
                       $show['bus_running_satus'] = $bus_running['bus_running_satus'];
                       $show['bus_desc'] = $bus_running['bus_desc'];
                       $show['driver_name'] = $bus_running['driver_name'];
                       $show['driver_assistant'] = $bus_running['driver_assistant'];
                       $show['driver_phone'] = $bus_running['driver_phone'];
                       $show['assistant_phone'] = $bus_running['assistant_phone'];
                       $show['bus_child_pickup_or_drop_off'] = $bus_running['bus_child_pickup_or_drop_off'];
                       $pickup_or_drop_off = $bus_running['bus_child_pickup_or_drop_off'];
                       if($trip_details['trip_desc']!='')
                       $show['trip_name'] = $trip_details['trip_desc'];
                       else
                       $show['trip_name'] = "";
                       $show['trip_pickedup'] = $attendance['count'];
                       $show['trip_total_no'] = $total_child_list_count['count'];

                    $tracking = $this->Attendance_model->last_known_location_by_busn_id($bus_id, $bus_current_trip_id);
   
                    if($tracking['tracking_lati']!=0 and $tracking['tracking_logi'] !=0){
                    $show['distance'] = distance($school_lati, $school_longi, $tracking['tracking_lati'], $tracking['tracking_logi'], "K");
                    $show['distance'] = round($show['distance'], 1) . ""; 
                            } else {
                              $show['distance']  =""; 
                            }
                   $output['to_show']=$show;
                   $trip_type=$trip_details['trip_type'];
                     //------------------------------
 

        
      echo json_encode($output);

    
      }
    
    
    

     public function map_api() {
            
            //{"date":"2017-02-28","trip_id":"1"}
            $data=$this->input->post('data');
            $data=  stripslashes($data);
            $json_data=  json_decode($data);
            $date=$json_data->date;
            $trip_id=$json_data->trip_id;
           /*  $output = array('status' => 'fail','error'=>'140','msg'=>'This feature is coming soon. 
For now, please use www.giisbustrack.com to view the bus location on the map.');   
              echo json_encode($output);
             exit();*/
            if($trip_id!=''){
             $tracking_list = $this->Tracking_model->get_all_tracking_for_map_api($date,$trip_id);
             $output = array('status' => 'success');
             $output['map_list']=$tracking_list;
             $output['trip_id']=$trip_id;  
            }else {
               $output = array('status' => 'fail','error'=>'140','msg'=>'The trip is not running at this time.');       
            }

              echo json_encode($output);
        }
        
        
            public function map_refresh() {
//               {"date":"2017-02-28","trip_id":"1","last_id":"18720"}
            
            $data=$this->input->post('data');
            $data=  stripslashes($data);
            $json_data=  json_decode($data);
            $date=$json_data->date;
            $last_id=$json_data->last_id;
            $trip_id=$json_data->trip_id;
          
            $flag_finish_trip=$this->Tracking_model->is_finished_trip($date,$trip_id);
           if(!$flag_finish_trip) {
                 $tracking_list = $this->Tracking_model->get_lat_long_one_by_one_map($date,$trip_id,$last_id);
           if($tracking_list)
            {
            $output = array('status' => 'success');
            $output['map_list']=$tracking_list;
            }
            else {
             $output = array('status' => 'fail','error'=>'141','msg'=>'no data'); 
            }
           }
           else {
              $output = array('status' => 'fail','error'=>'140','msg'=>'The trip is not running at this time.');   
           }
            echo json_encode($output);
        }
        
        
            // authentication from parent app
    public function auth_supervisor() {
        //{ 	"user_name": "d", 	"passwod": "1"}
        $data=$this->input->post('data');
        $data=  stripslashes($data);
        $json_data=  json_decode($data);
       
        if($json_data->user_name!=''&& $json_data->passwod!='' ){
             $result=  $this->Supervisor_app_user_model->get_supervisor_app_user_by_username_pass($json_data->user_name,$json_data->passwod);
             
             if(!empty($result)){
              
                  $output = array('status' => 'success','login_id'=>$result['supervisor_app_user_id']);
                   $output ['card_scan_type']="tag";
             

             }else {
                 $output = array('status' => 'fail','error'=>'108','msg'=>'Invalid Username or Password !');   
             }
                         
        }     
        else {
            $output = array('status' => 'fail','error'=>'109','msg'=>'User name or Password empty !');   
        }
        $settings = $this->Setting_model->get_all_settings();
        foreach ($settings as $key => $value) {
            $output ['card_scan_type'] = $value['card_scan_type'];
        }
        echo json_encode($output);
    }
    
    
     public function bus_log() {
       //{ 	"bus_id": "1","date":"2017-02-28","trip_id":"1"}
        $data=$this->input->post('data');
        $data=  stripslashes($data);
        $json_data=  json_decode($data);
        $bus_id=$json_data->bus_id;
        $trip_id=$json_data->trip_id;
        $date=$json_data->date;
        $output=array();
        $pickup_list=array();
        $dropoff_list=array();
        $absent_list=array();
        $pickup_list=$this->Attendance_model->get_attendance_by_date_and_pickup_or_drop_off($bus_id,$trip_id,'pickup',$date,'present');
        $output ['pickup_list']=($pickup_list)?$pickup_list:array();
        $dropoff_list=$this->Attendance_model->get_attendance_by_date_and_pickup_or_drop_off($bus_id,$trip_id,'drop off',$date,'present');
        $output ['dropoff_list']=($dropoff_list)?$dropoff_list:array();
        $absent_list=$this->Attendance_model->get_attendance_by_date_and_pickup_or_drop_off($bus_id,$trip_id,'pickup',$date,'absent');
        $output ['absent_list']=($absent_list)?$absent_list:array();
        $child_list = $this->Child_model->get_all_child_trip($trip_id,"child_name");
         $output ['student_list']=$child_list;
        $total_count= count($absent_list)+count($pickup_list);
        $absent_count= count($absent_list);
        $output ['total_count']= "".$total_count;
        $output ['absent_count']= "".$absent_count;
        $bus=  $this->Bu_model->get_bu($bus_id); 
        $trip = $this->Trip_model->get_trip($trip_id);
        $output['status']= 'success';
        $output['trip_details']=$trip;     
        $output['bus_detail']=$bus;
        $bus_detail['bus_name']=$bus['bus_name'];
        $bus_detail['driver_name']=$bus['driver_name'];
        $bus_detail['driver_assistant']=$bus['driver_assistant'];
        $bus_detail['driver_phone']=$bus['driver_phone'];
        $finish_trip_detail=$this->Finish_trip_detail_model->get_finish_trip_detail_by_bustrip($trip_id,$bus_id,$date);
        $output['finish_trip_detail']=($finish_trip_detail)?$finish_trip_detail:new stdClass();
        echo json_encode($output);
     }
     
     public function bus_details() {
        // { 	"bus_id": "1" }
        $data=$this->input->post('data');
        $data=  stripslashes($data);
        $json_data=  json_decode($data);
        $bus_id=$json_data->bus_id;
        $output = array('status' => 'success');
        $bus=  $this->Bu_model->get_bu($bus_id); 
        $trip = $this->Trip_model->get_all_trip_by_bus_id($bus_id);
        $bus_app_user=$this->Bus_app_user_model->get_bus_app_user_by_bus_id($bus_id);
        
        $output['status']= 'success';
        $output['trip_list']=$trip;            
        $bus_detail['bus_name']=$bus['bus_name'];
        $bus_detail['driver_name']=$bus['driver_name'];
        $bus_detail['bus_desc']=$bus['bus_desc'];
        $bus_detail['driver_assistant']=$bus['driver_assistant'];
        $bus_detail['driver_phone']=$bus['driver_phone'];
        $bus_detail['bus_user_name']=$bus_app_user['bus_app_user_name'];
        $bus_detail['bus_user_password']=$bus_app_user['bus_app_user_password'];
        $bus_detail['assistant_phone']=$bus['assistant_phone'];
        $output['bus_detail']=$bus_detail;
        echo json_encode($output);
     }
     
     public function search_child_satus_with_keywords() {
             //  
        
        $data=$this->input->post('data');
        $data=  stripslashes($data);
        $json_data=  json_decode($data);
        $search_key=$json_data->search_key;
        $search_word=$json_data->search_word;
        if($search_key=='phone_number'){
        
            $child_list = $this->Child_model->get_child_id_using_phone_number_like($search_word);
             $search_key1='PHONE NUMBER';
        }
          if($search_key=='register_number'){
        
            $child_list = $this->Child_model->get_child_id_using_register_number_like($search_word);
            $search_key1='REGISTRATION number';
//            echo $this->db->last_query();
//          exit();
        }
          if($search_key=='email'){
        
            $child_list = $this->Child_model->get_child_id_using_email_like($search_word);
             $search_key1='EMAIL';
        }
          if($search_key=='name'){
        
            $child_list = $this->Child_model->get_child_id_using_name_like($search_word);
             $search_key1='NAME';
        }
        
        
        
        if(!empty($child_list)){
            
         $output = array('status' => 'success');
          $bus_list=$this->Bu_model->get_all_bus();   
          $child_list= $this->common_model->Bus_id_to_Bus_name_in_child_list($child_list,$bus_list);
             $output['child_details']=$child_list;     
       } else {
           $output = array('status' => 'fail','error'=>'112','msg'=>$search_key1.' not found in the school database. Pls try again.');    
       }
       
        echo json_encode($output);
    }
    
        public function child_satus_nfc() {
        //  { "nfc_id": "2"  }

        $data = $this->input->post('data');
        $data = stripslashes($data);
        $json_data = json_decode($data);
        $nfc_id = $json_data->nfc_id;

        if ($nfc_id != '') {
            $children = $this->Child_model->get_child_id_using_nfc_like($nfc_id);

            if (!empty($children)) {
                $output = array('status' => 'success');

                $bus_list = $this->Bu_model->get_all_bus();
                $children = $this->common_model->Bus_id_to_Bus_name_in_child_list($children, $bus_list);

                $output['child_list'] = $children[0];
            } else {
                $output = array('status' => 'fail', 'error' => '115', 'msg' => 'No child is added yet ! Please contact Admin');
            }
        } else {
            $output = array('status' => 'fail', 'error' => '114', 'msg' => ' Parent id is null');
        }
        echo json_encode($output);
    }
public function search_child_satus_with_keywords_result() {
             //  { "child_id": "2"  }
        
        $data=$this->input->post('data');
        $data=  stripslashes($data);
        $json_data=  json_decode($data);
        $child_id=$json_data->child_id;
    
            
            if($child_id!=''){
           
           $notfications = $this->Notification_model->get_last_notification_by_child_id($child_id);
          // echo $this->db->last_query();
            $child = $this->Child_model->get_child($child_id);
            $bus_list=$this->Bu_model->get_all_bus();  
            
            $child= $this->common_model->Bus_id_to_Bus_name_in_child($child,$bus_list);
            $children []=$child;
            $trip_list=$this->Trip_model->get_all_trip();   
            
            $child= $this->common_model->trip_id_to_Trip_name_in_child_list($children,$trip_list);
            
            for ($j = 0; $j < count($child); $j++) {
             $child_id = $child[$j]['child_id'];
             $signed_status = $this->Parent_app_user_model->get_signedup_or_not($child_id);
             if($signed_status==0)
             {
                 $status='Yes';
             }
             else
             {
                  $status='No';
             }
             $child[$j]['parent_signed_up_status'] = $status;
             }
        
             $output = array('status' => 'success');
             $output['child_details']=$child;  
             $output['notification_list']=$notfications;
       
       } else {
           $output = array('status' => 'fail','error'=>'112','msg'=>'child id is null !');    
       }
       
        echo json_encode($output);
    }
      public function email_trip_child_list() {
       //{ 	"bus_id": "1","date":"2017-02-28","trip_id":"1"}
        $this->load->library('email');
        $data=$this->input->post('data');
        $data=  stripslashes($data);
        $json_data=  json_decode($data);
        $bus_id=$json_data->bus_id;
        $trip_id=$json_data->trip_id;
        $date=$json_data->date;
        $child_list=$this->Attendance_model->get_child_id_from_attandence_with_type_c($trip_id,$date);
         $bus=  $this->Bu_model->get_bu($bus_id); 
         $trip = $this->Trip_model->get_trip($trip_id);
      // echo $this->db->last_query();exit();
       $msg='';  
if($child_list){
         $msg.='<table><tr> <td><b>Bus Name: '.$bus['bus_name']. ' Trip Number: '.$trip['trip_no'].'</b><td></tr>'
                  . '<tr> <td><b>Name</b><td><td><b>Register Number</b><td><td><b>Class </b><td></tr>';
       foreach ($child_list as $value) {
         $data2= $this->Child_model->get_child_email_details($value['at_child_id']);
          
          $msg.= '<tr> <td>'.$data2[0]['child_name'].'<td><td>'.$data2[0]['child_nfc_id'].'<td><td>'.$data2[0]['child_class'].'<td></tr>';
//              print_r($data2[0]['child_id']);    
         }
       $msg.='</table>';
       
        $to='online@dunamisworld.com';     
        $from='lokatestudent@dunamisworld.com';
        $subject = 'Child Details Based on Trip Id';


        $body = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=' . strtolower(config_item('charset')) . '" />
            <title>' . html_escape($subject) . '</title>
            <style type="text/css">
                body {
                    font-family: Arial, Verdana, Helvetica, sans-serif;
                    font-size: 16px;
                }
            </style>
        </head>
        <body>
        ' . $msg . '
        </body>
        </html>';

        $headers = "MIME-Version: 1.0\r\n"; 
        $headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
        $headers  .= "From:$from\r\n"; 
        $mail=mail($to, $subject, $body, $headers)or die("mail error");
        if($mail)
        {
             $output = array('status' => 'success');
             $output['msg']='Child Details has been sent !';  
        }
       
        }
         else {
                 $output = array('status' => 'fail','error'=>'104','msg'=>'All students are scanned using cards');     
            }
          echo json_encode($output);
     }
    
       public function bus_push_single_child() {
        
          //{ "child_id": "9","message": "Test Breakdown","title": "Test Title"}
       if($this->input->post('data')){
            
        $data=$this->input->post('data');
        $data=  stripslashes($data);
        $json_data=  json_decode($data);
        
           $push_list=$this->Push_msg_map_model->get_all_push_msg_map_child_id($json_data->child_id);
          //  echo $this ->db->last_query();exit();
           foreach ($push_list as $key=>$value)
           {
               $registatoin_ids[]=$value['push_msg_device_token'];
           }
           
         //  print_r($registatoin_ids);exit();
           if(!empty($registatoin_ids)){
               
           //$child_push=array('child_name' => $json_data->at_child_id);
               
               $fields = array(
                       'registration_ids' => $registatoin_ids,
                       'notification'=>array( "body" =>$json_data->message,
                        "title" => $json_data->title,
                        "From"=>"Child safety app",
                        "sound"=>'default' ,                                 
                        "click_action"=>'NotificationActivity' ,                                 
                       'child_name'=>$json_data->child_id,
                        'click_action'=>'NotificationActivity'
                        
                         
                           
                           ) ,
                'data'=>array('child_name' => $json_data->child_id)

                   );
                     
           $this->common_model->send_push_notification($fields);
           
            $params = array(
				'n_title' => $json_data->title,
				'n_msg' =>$json_data->message,
				'n_send_type' => 'push',
				'n_type' => 'other',
				'n_child_id' => $json_data->child_id,
				'n_status' => '',
                                'n_trip_type'=>''
                                
            );
            
            $notification_id = $this->Notification_model->add_notification($params);
            
            
           }
            $output = array('status' => 'success'); 
            }
            else {
                $output = array('status' => 'fail','error'=>'106','msg'=>'Data is null');     
             }
            echo json_encode($output);
    }
    
    
    
       public function bus_push_single_trip() {
        
          //{ "child_id": "9","message": "Test Breakdown","title": "Test Title"}
       if($this->input->post('data')){
            
        $data=$this->input->post('data');
        $data=  stripslashes($data);
        $json_data=  json_decode($data);
        
           $push_list=$this->Push_msg_map_model->get_all_push_msg_map_multiple_child_id($json_data->trip_id);
           
           foreach ($push_list as $key=>$value)
           {
               $registatoin_ids[]=$value['push_msg_device_token']; 
           }
           
         // print_r($registatoin_ids);exit();
           if(!empty($registatoin_ids)){
               
           //$child_push=array('child_name' => $json_data->at_child_id);
               
               $fields = array(
                       'registration_ids' => $registatoin_ids,
                       'notification'=>array( "body" =>$json_data->message,
                        "title" => $json_data->title,
                        "From"=>"Child safety app",
                        "sound"=>'default' ,                                 
                        "click_action"=>'NotificationActivity' ,                                 
                        'child_name'=>'',
                        'click_action'=>'NotificationActivity'
                        
                         
                           
                           ) ,
                'data'=>array('child_name' => '')

                   );
                     
           $this->common_model->send_push_notification($fields);
           
             foreach ($push_list as $key => $value) {
                          
            $params = array(
				'n_title' => $json_data->title,
				'n_msg' =>$json_data->message,
				'n_send_type' => 'push',
				'n_type' => 'other',
				'n_child_id' => $value['push_msg_child_id'],
				'n_status' => '',
                                'n_trip_type'=>''
                                
            );
            
            $notification_id = $this->Notification_model->add_notification($params);
        //    echo $this ->db->last_query();exit(); 
             }
            
           }
            $output = array('status' => 'success'); 
            }
            else {
                $output = array('status' => 'fail','error'=>'106','msg'=>'Data is null');     
             }
            echo json_encode($output);
    }
    
      public function bus_push_single_bus() {
        
          //{ "child_id": "9","message": "Test Breakdown","title": "Test Title"}
       if($this->input->post('data')){
            
        $data=$this->input->post('data');
        $data=  stripslashes($data);
        $json_data=  json_decode($data);
      //  print_r($json_data);exit(); 
           $push_list=$this->Push_msg_map_model->get_all_push_msg_map_multiple_child_id_bus_id($json_data->bus_id);
       //     echo $this ->db->last_query();exit(); 
           foreach ($push_list as $key=>$value)
           {
               $registatoin_ids[]=$value['push_msg_device_token']; 
           }
           
         // print_r($registatoin_ids);exit();
           if(!empty($registatoin_ids)){
               
           //$child_push=array('child_name' => $json_data->at_child_id);
               
               $fields = array(
                       'registration_ids' => $registatoin_ids,
                       'notification'=>array( "body" =>$json_data->message,
                        "title" => $json_data->title,
                        "From"=>"Child safety app",
                        "sound"=>'default' ,                                 
                        "click_action"=>'NotificationActivity' ,                                 
                        'child_name'=>'',
                        'click_action'=>'NotificationActivity'
                        
                         
                           
                           ) ,
                'data'=>array('child_name' => '') 

                   );
                     
           $this->common_model->send_push_notification($fields);
           
             foreach ($push_list as $key => $value) {
                          
            $params = array(
				'n_title' => $json_data->title,
				'n_msg' =>$json_data->message,
				'n_send_type' => 'push',
				'n_type' => 'other',
				'n_child_id' => $value['push_msg_child_id'],
				'n_status' => '',
                                'n_trip_type'=>''
                                
            );
            
            $notification_id = $this->Notification_model->add_notification($params);
           
             }
            
           }
            $output = array('status' => 'success'); 
            }
            else {
                $output = array('status' => 'fail','error'=>'106','msg'=>'Data is null');     
             }
            echo json_encode($output);
    }
    
    
       // Get trip list from backend
    public function trip_list() {
        
        //{ "trip_id": "1","bus_id":"1","sort_order":""}
      
        $data=$this->input->post('data');
        $data=  stripslashes($data);
        $json_data=  json_decode($data);
        $bus_id=$json_data->bus_id; 
        $trip_id=$json_data->trip_id; 
        $sort_order=$json_data->sort_order; 

        if($json_data->trip_id!='' &&  $bus_id!=''){
        
            
        $child = $this->Child_model->get_all_child_trip($json_data->trip_id,$sort_order);
  
        $output = array('status' => 'success');
        $output['children_list']=$child;      
        }else {
           $output = array('status' => 'fail','error'=>'104','msg'=>'Wrong Trip id !');     
        }
        echo json_encode($output);
    }
    
         
     public function bus_count_details() {
        $output = array('status' => 'success');
        $running_notrunning=  $this->Summery_model->get_count_bus_running_notrunning(); 
        foreach ($running_notrunning as $key => $run_or_not) {
            if($run_or_not['type']=='count_running'){
                $bus_detail['running_bus']=$run_or_not['count'];
            }
            else{
                $bus_detail['notrunning_bus']=$run_or_not['count'];
            }
           }
            $pickup_dropoff = $this->Summery_model->get_count_bus_pickup_dropoff();
            foreach ($pickup_dropoff as $key => $pick_or_drop) {
            if($pick_or_drop['type']=='count_pickup'){
              $bus_detail['current_pickup_bus']=$pick_or_drop['count'];
            }
            else{
              $bus_detail['current_dropoff_bus']=$pick_or_drop['count'];
            }
            }
         $output['bus_summery']=$bus_detail;
        
         $trip_pickup_dropoff = $this->Summery_model->get_count_child_trip_pickup_dropoff();
            foreach ($trip_pickup_dropoff as $key => $trip_pick_or_drop) {
            if($trip_pick_or_drop['type']=='count_pickup'){
                $child_p_d['total_students_morning_trip']=$trip_pick_or_drop['count'];
            }
            else{
                $child_p_d['total_students_evening_trip']=$trip_pick_or_drop['count'];
            }
        }
         $output['child_summery']=$child_p_d;
        $output['status']= 'success';
      
      
        echo json_encode($output);
     }
     
}

?>
