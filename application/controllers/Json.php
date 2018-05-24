<?php

class Json extends CI_Controller {

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
        $this->load->model('Setting_model');
        $this->load->model('Access_log_model');
        $this->load->model('School_attendance_model');
        $this->load->model('Attendance_device_model');
        $this->load->model('Child_live_buss_update_model');

        header('Content-Type: application/json');
    }

// authentication from app
    public function auth_bus() {
        //{ 	"user_name": "d", 	"passwod": "1"}
        $data = $this->input->post('data');
        $data = stripslashes($data);
        $json_data = json_decode($data);

        if ($json_data->user_name != '' && $json_data->passwod != '') {
            $result = $this->Bus_app_user_model->get_bus_app_user_by_username_pass($json_data->user_name, $json_data->passwod);
            // echo $this->db->last_query();
            if (!empty($result)) {
                $bus = $this->Bu_model->get_bu($result['bus_app_user_bus_id']);
                //$trip = $this->Trip_model->get_all_trip_by_bus_id($result['bus_app_user_bus_id']);
                //echo $this->db->last_query(); exit();
                $trip = array();
                $trip_time = $json_data->current_hour;
                $trip = $this->Trip_model->get_all_active_trip_by_bus_id($result['bus_app_user_bus_id'], $trip_time);

                // echo $this->db->last_query(); exit(); 

                $bus_detail['bus_name'] = $bus['bus_name'];
                $bus_detail['bus_desc'] = $bus['bus_desc'];
                $bus_detail['driver_name'] = $bus['driver_name'];
                $bus_detail['driver_assistant'] = $bus['driver_assistant'];
                $bus_detail['driver_phone'] = $bus['driver_phone'];
                // if(!empty($trip)){
                $output = array('status' => 'success');
                $output['trip_list'] = $trip;
                $output['bus_detail'] = $bus_detail;

                // }  else {
                //         $output = array('status' => 'fail','error'=>'103','msg'=>'No Trip is assigned for this bus Now ! Please contact Admin');   
                // }
            } else {
                $output = array('status' => 'fail', 'error' => '102', 'msg' => 'Invalid Username or Password !');
            }
        } else {
            $output = array('status' => 'fail', 'error' => '101', 'msg' => 'User name or Password empty !');
        }
        //  $output ['card_scan_type']="text";
        $settings = $this->Setting_model->get_all_settings();
        $output ['card_scan_type'] = 'text';
        $output ['master_card_id'] = '55555';
        foreach ($settings as $key => $value) {
            $output ['card_scan_type'] = $value['card_scan_type'];
            $output ['master_card_id'] = $value['set_master_card_id'];
        }
        echo json_encode($output);
    }

// Get trip list from backend
    public function trip_list() {

        //{ "trip_id": "1","bus_id":"1","bus_child_pickup_or_drop_off":"pickup"}

        $data = $this->input->post('data');
        $data = stripslashes($data);
        $json_data = json_decode($data);
        // print_r($json_data);exit();
        $bus_id = $json_data->bus_id;
        $trip_id = $json_data->trip_id;
        $sort_order = $json_data->sort_order;
        $bus_child_pickup_or_drop_off = $json_data->bus_child_pickup_or_drop_off;

        // $bus_child_pickup_or_drop_off='pickup';
        if ($json_data->trip_id != '' && $bus_id != '') {
            $params = array(
                'bus_running_satus' => 'running',
                'bus_child_pickup_or_drop_off' => $bus_child_pickup_or_drop_off,
                'bus_current_trip_id' => $json_data->trip_id
            );

            $output = array('status' => 'success');

            $this->Bu_model->update_bu($bus_id, $params);
            $child=array();
            $child_on_the_list = $this->Child_model->get_all_child_trip($json_data->trip_id, $sort_order);
             $child_ids=array();
              foreach ($child_on_the_list as $key => $value) {
                  $child_ids[]= $value['child_id'];
              }
           
            $att_off_the_list=$this->Attendance_model->get_attendance_list_not_in_the_list($json_data->trip_id, 'pickup', $child_ids);
            //print_r($att_off_the_list);exit();
            if(!empty($att_off_the_list)){
            $child_ids=array();
             foreach ($att_off_the_list as $key => $value) {
                  $child_ids[]= $value['at_child_id'];
              }
            $child_off_the_list=$this->Child_model->get_all_child_trip_not_in_the_list($child_ids, $sort_order);
            $child = array_merge($child_on_the_list, $child_off_the_list);
          
            }else {
            $child=$child_on_the_list;   
            }
            foreach ($child as $key => $value) {
                $att = $this->Attendance_model->get_attendance_list($json_data->trip_id, $bus_child_pickup_or_drop_off, $value['child_id']);

                if (!empty($att)) {
                    if ($att['at_child_status'] == 'present') {
                        $child[$key]['current_staus'] = $att['at_pickup_or_drop_off'];
                    } else {
                        $child[$key]['current_staus'] = $att['at_child_status'];
                    }
                } else if ($bus_child_pickup_or_drop_off == 'drop off') {

                    $child[$key]['current_staus'] = 'pickup';
                } else {
                    $child[$key]['current_staus'] = 'initial';
                }
            }
            $output = array('status' => 'success');
            $output['children_list'] = $child;
        } else {
            $output = array('status' => 'fail', 'error' => '104', 'msg' => 'Wrong Trip id !');
        }
        echo json_encode($output);
    }

// Trackiing bus 
    public function track_bus() {

        //{ 	"tracking_logi": "d", 	"tracking_lati": "1","tracking_trip_id": "1", 	"tracking_bus_id": "1","tracking_time_stamp_device": "","tracking_battery_status": "100", "tracking_data_type": "network"}

        if ($this->input->post('data')) {
            $data = $this->input->post('data');
            $data = stripslashes($data);
            $json_data = json_decode($data);
            $params = array(
                'tracking_logi' => $json_data->tracking_logi,
                'tracking_lati' => $json_data->tracking_lati,
                'tracking_trip_id' => $json_data->tracking_trip_id,
                'tracking_bus_id' => $json_data->tracking_bus_id,
                'tracking_time_stamp_device' => $json_data->tracking_time_stamp_device,
                'tracking_battery_status' => $json_data->tracking_battery_status,
                'tracking_data_type' => $json_data->tracking_data_type,
            );

            $tracking_id = $this->Tracking_model->add_tracking($params);

            $this->Tracking_model->delete_Last_location_details($params['tracking_bus_id'], $params['tracking_trip_id']);
            $last_position_id = $this->Tracking_model->add_Last_location_details($params);
            $output = array('status' => 'success');
        } else {
            $output = array('status' => 'fail', 'error' => '105', 'msg' => 'Data is null');
        }
        echo json_encode($output);
    }

// Trackiing bus 
    public function track_bus_batch() {

        //{ 	"tracking_logi": "d", 	"tracking_lati": "1","tracking_trip_id": "1", 	"tracking_bus_id": "1","tracking_time_stamp_device": "","tracking_battery_status": "100", "tracking_data_type": "network"}
        //  print_r($this->input->post('data'));exit();
        if ($this->input->post('data')) {
            $data = $this->input->post('data');
            $data = stripslashes($data);
            $json_data = json_decode($data);
            $params_data = array();
            $params = array();
            foreach ($json_data as $key => $value) {
                // print_r($value);exit();
                $tracking_logi=(isset($value->tracking_logi))?$value->tracking_logi:"";
                $tracking_lati=(isset($value->tracking_lati))?$value->tracking_lati:"";
                $tracking_trip_id=(isset($value->tracking_trip_id))?$value->tracking_trip_id:"";
                $tracking_bus_id=(isset($value->tracking_bus_id))?$value->tracking_bus_id:"";
                $tracking_time_stamp_device=(isset($value->tracking_time_stamp_device))?$value->tracking_time_stamp_device:"";
                $tracking_battery_status=(isset($value->tracking_battery_status))?$value->tracking_battery_status:"";
                $tracking_data_type=(isset($value->tracking_data_type))?$value->tracking_data_type:"";
                if($tracking_logi!='' and  $tracking_lati!=''){
                $params = array(
                    'tracking_logi' => $tracking_logi,
                    'tracking_lati' => $tracking_lati,
                    'tracking_trip_id' => $tracking_trip_id,
                    'tracking_bus_id' => $tracking_bus_id,
                    'tracking_time_stamp_device' => $tracking_time_stamp_device,
                    'tracking_battery_status' => $tracking_battery_status,
                    'tracking_data_type' => $tracking_data_type,
                );
                $params_data[] = $params;
                }
            }
            if(!empty($params_data)){
            $this->Tracking_model->add_tracking_batch($params_data);
            $this->Tracking_model->delete_Last_location_details($params['tracking_bus_id'], $params['tracking_trip_id']);
            $last_position_id = $this->Tracking_model->add_Last_location_details($params);
            }
            $output = array('status' => 'success');
        } else {
            $output = array('status' => 'fail', 'error' => '105', 'msg' => 'Data is null');
        }
        echo json_encode($output);
    }

// Mark attendance

 /*   public function mark_attendance() {

        //{ "at_child_id":"1", "at_trip_id":"1", "at_time_stamp_device":"", "at_loc_lati":"1.23333", "at_loc_longi":"1.888", "at_loc_data_type":"gprs", "at_bus_id":"1", "at_trip_type":"pickup","at_pickup_or_drop_off":"pickup","at_child_status":"present"}

        if ($this->input->post('data')) {

            $data = $this->input->post('data');
            $data = stripslashes($data);
            $json_data = json_decode($data);
            $check_list = $this->Attendance_model->is_dupplicate_entry($json_data->at_child_id, $json_data->at_trip_id, $json_data->at_bus_id, $json_data->at_trip_type, $json_data->at_pickup_or_drop_off,$json_data->at_time_stamp_device);

            //  echo  $this->db->last_query();exit();
            if ($check_list == 0) {

                $params = array(
                    'at_child_id' => $json_data->at_child_id,
                    'at_trip_id' => $json_data->at_trip_id,
                    'at_time_stamp_device' => $json_data->at_time_stamp_device,
                    'at_loc_lati' => $json_data->at_loc_lati,
                    'at_loc_longi' => $json_data->at_loc_longi,
                    'at_loc_data_type' => $json_data->at_loc_data_type,
                    'at_bus_no' => $json_data->at_bus_id,
                    'at_trip_type' => $json_data->at_trip_type,
                    'at_pickup_or_drop_off' => $json_data->at_pickup_or_drop_off,
                    'at_child_status' => $json_data->at_child_status,
                );
                $attendance_id = $this->Attendance_model->add_attendance($params);


                if ($json_data->at_child_status == 'absent') {
                    $params = array(
                        'at_child_id' => $json_data->at_child_id,
                        'at_trip_id' => $json_data->at_trip_id,
                        'at_time_stamp_device' => $json_data->at_time_stamp_device,
                        'at_loc_lati' => $json_data->at_loc_lati,
                        'at_loc_longi' => $json_data->at_loc_longi,
                        'at_loc_data_type' => $json_data->at_loc_data_type,
                        'at_bus_no' => $json_data->at_bus_id,
                        'at_trip_type' => $json_data->at_trip_type,
                        'at_pickup_or_drop_off' => 'drop off',
                        'at_child_status' => $json_data->at_child_status,
                    );
                    $attendance_id = $this->Attendance_model->add_attendance($params);
                }
                $output = array('status' => 'success');

                $push_list = $this->Push_msg_map_model->get_all_push_msg_map_child_id($json_data->at_child_id);
                //  echo $this ->db->last_query();exit();
                foreach ($push_list as $key => $value) {
                    $registatoin_ids[] = $value['push_msg_device_token'];
                }
                /* send push notification */

                // $registatoin_ids[0]='fEu-oFlxIYU:APA91bELcjyy47HE14P9K2JDpakRZdnG8HzYGm92oiy9deXO5LI57b6AjmZ4wq7vl1bUcS-i9pjEAYyNXsNAw_YDvx0NCLUTWFwR6zUXWVoBscA1gZy2EzIaXn0A9Vpc4M_GyVgRgu55';
             /*   $child = $this->Child_model->get_child($json_data->at_child_id);
                $formated_data = $this->common_model->get_push_message_and_title($json_data->at_trip_type, $json_data->at_pickup_or_drop_off, $json_data->at_child_status, $child['child_name']);

                $message = $formated_data['message'];
                $title = $formated_data['title'];
                $params = array(
                    'n_title' => $title,
                    'n_msg' => $message,
                    'n_send_type' => 'push',
                    'n_type' => $json_data->at_pickup_or_drop_off,
                    'n_child_id' => $json_data->at_child_id,
                    'n_status' => $json_data->at_child_status,
                    'n_trip_type' => $json_data->at_trip_type
                );

                $notification_id = $this->Notification_model->add_notification($params);


                if (!empty($registatoin_ids)) {

                    //$child_push=array('child_name' => $json_data->at_child_id);
                    $fields = array(
                        'registration_ids' => $registatoin_ids,
                        'notification' => array("body" => $message,
                            "title" => $title,
                            "From" => "Child safety app",
                            "sound" => 'default',
                            "click_action" => 'NotificationActivity',
                            'child_name' => $json_data->at_child_id,
                            'click_action' => 'NotificationActivity'
                        ),
                        'data' => array('child_name' => $json_data->at_child_id)
                    );

                    $this->common_model->send_push_notification($fields);
                }
            } else {

                $output = array('status' => 'success');
            }
        } else {
            $output = array('status' => 'fail', 'error' => '106', 'msg' => 'Data is null');
        }
        echo json_encode($output);
    }*/

// Mark attendance

    public function mark_attendance_batch() {

        //{ "at_child_id":"1", "at_trip_id":"1", "at_time_stamp_device":"", "at_loc_lati":"1.23333", "at_loc_longi":"1.888", "at_loc_data_type":"gprs", "at_bus_id":"1", "at_trip_type":"pickup","at_pickup_or_drop_off":"pickup","at_child_status":"present",,"child_nfc":"","child_change_bus":"No"}

        if ($this->input->post('data')) {

            $data = $this->input->post('data');
            $data = stripslashes($data);
            $json_data = json_decode($data);
            $settings_main = $this->Setting_model->get_current_settings();
            $localization_lang=$this->common_model->get_localization($settings_main['set_language']);
            if($settings_main['set_language1']){
            $localization_lang1=$this->common_model->get_localization($settings_main['set_language1']); 
            }else {
                $localization_lang1="";
            }
           $count=0;
           $send_push_trip='Yes';
            foreach ($json_data as $key => $value) {
                
                 
                if ($value->child_change_bus == 'Yes') {
                    $split=  explode('@', $value->child_nfc);
                    $value->child_nfc=$split[1];
                    if($split[0]=='reg_no'){
                    $value->at_child_id = $this->Child_model->get_child_id_using_reg_no($value->child_nfc);
                    }else if ($split[0]=='nfc'){
                     $value->at_child_id = $this->Child_model->get_child_id_using_nfc_id($value->child_nfc);    
                    }else {
                        $value->at_child_id ="";
                    }
                    if ($value->at_child_id == "") {
                        continue;
                    }
                } 
                if($count==0){
                 $trip = $this->Trip_model->get_trip($value->at_trip_id);
                 $send_push_trip=$trip['push_notification'];
                }
                $count++;
                $check_list = $this->Attendance_model->is_dupplicate_entry($value->at_child_id, $value->at_trip_id, $value->at_bus_id, $value->at_trip_type, $value->at_pickup_or_drop_off,$value->at_time_stamp_device);
                $value->at_loc_lati=(isset($value->at_loc_lati))?$value->at_loc_lati:"0.0";
                $value->at_loc_longi=(isset($value->at_loc_longi))?$value->at_loc_longi:"0.0";
                //  echo  $this->db->last_query();
                if ($check_list == 0) {
                     $params_live = array(
                           'live_child_id' => $value->at_child_id,
                           'live_trip_id' => $value->at_trip_id,
                           'live_buss_id' => $value->at_bus_id
                         );
                    $live_update = $this->Child_live_buss_update_model->replace_status($params_live);
                            
                            
                    if ($value->at_child_status == 'absent' && $value->at_pickup_or_drop_off=='pickup') {
                        $params = array(
                        'at_child_id' => $value->at_child_id,
                        'at_trip_id' => $value->at_trip_id,
                        'at_time_stamp_device' => $value->at_time_stamp_device,
                        'at_loc_lati' => $value->at_loc_lati,
                        'at_loc_longi' => $value->at_loc_longi,
                        'at_loc_data_type' => $value->at_loc_data_type,
                        'at_bus_no' => $value->at_bus_id,
                        'at_trip_type' => $value->at_trip_type,
                        'at_pickup_or_drop_off' => $value->at_pickup_or_drop_off,
                        'at_child_status' => $value->at_child_status,
                    );
                    $attendance_id = $this->Attendance_model->add_attendance($params);
                        $params = array(
                            'at_child_id' => $value->at_child_id,
                            'at_trip_id' => $value->at_trip_id,
                            'at_time_stamp_device' => $value->at_time_stamp_device,
                            'at_loc_lati' => $value->at_loc_lati,
                            'at_loc_longi' => $value->at_loc_longi,
                            'at_loc_data_type' => $value->at_loc_data_type,
                            'at_bus_no' => $value->at_bus_id,
                            'at_trip_type' => $value->at_trip_type,
                            'at_pickup_or_drop_off' => 'drop off',
                            'at_child_status' => $value->at_child_status,
                        );
                        $attendance_id = $this->Attendance_model->add_attendance($params);
                    }else  if ($value->at_child_status == 'absent' && $value->at_pickup_or_drop_off=='drop off') 
                    {
                        // do nothing ! we have already inserted into the db
                    }
                    
                    else {
                        
                          $params = array(
                        'at_child_id' => $value->at_child_id,
                        'at_trip_id' => $value->at_trip_id,
                        'at_time_stamp_device' => $value->at_time_stamp_device,
                        'at_loc_lati' => $value->at_loc_lati,
                        'at_loc_longi' => $value->at_loc_longi,
                        'at_loc_data_type' => $value->at_loc_data_type,
                        'at_bus_no' => $value->at_bus_id,
                        'at_trip_type' => $value->at_trip_type,
                        'at_pickup_or_drop_off' => $value->at_pickup_or_drop_off,
                        'at_child_status' => $value->at_child_status,
                    );
                          
                    $attendance_id = $this->Attendance_model->add_attendance($params);
               if($settings_main['set_attendance']=='Yes')  {   
                // marking school attendance 
               if ($value->at_child_status == 'present' && $value->at_pickup_or_drop_off=='drop off' && $value->at_trip_type=='pickup')  {   
                        $value->at_in_or_out="in";
                        $check_list_school_at=$this->School_attendance_model->is_dupplicate_entry($value->at_child_id,$value->at_in_or_out,$value->at_time_stamp_device);
                        if($check_list_school_at==0){
                        $device=$this->Attendance_device_model->get_attendance_device_by_bus_id($value->at_bus_id);
                        if(!empty($device)){
                             $value->at_device_id=$device['device_id'];
                        }else {
                             $value->at_device_id='0';
                        }
                       
                        $params_s = array(
                            'at_child_id' => $value->at_child_id,
                            'at_time_stamp_device' => $value->at_time_stamp_device,
                            'at_loc_lati' => $value->at_loc_lati,
                            'at_loc_longi' => $value->at_loc_longi,
                            'at_loc_data_type' => $value->at_loc_data_type,
                            'at_device_id' => $value->at_device_id,
                            'at_in_or_out' => $value->at_in_or_out,
                            'at_child_status' => $value->at_child_status,
                        );
                        $attendance_s_id = $this->School_attendance_model->add_attendance($params_s);                
                        }
                    }else if ($value->at_child_status == 'present' && $value->at_pickup_or_drop_off=='pickup' && $value->at_trip_type=='drop off')  {  
                        $value->at_in_or_out="out";
   
                        $check_list_school_at=$this->School_attendance_model->is_dupplicate_entry($value->at_child_id,$value->at_in_or_out,$value->at_time_stamp_device);
                        if($check_list_school_at==0){
                        $device=$this->Attendance_device_model->get_attendance_device_by_bus_id($value->at_bus_id);
                        if(!empty($device)){
                             $value->at_device_id=$device['device_id'];
                        }else {
                             $value->at_device_id='0';
                        }    
                        $params_s = array(
                            'at_child_id' => $value->at_child_id,
                            'at_time_stamp_device' => $value->at_time_stamp_device,
                            'at_loc_lati' => $value->at_loc_lati,
                            'at_loc_longi' => $value->at_loc_longi,
                            'at_loc_data_type' => $value->at_loc_data_type,
                            'at_device_id' => $value->at_device_id,
                            'at_in_or_out' => $value->at_in_or_out,
                            'at_child_status' => $value->at_child_status,
                        );
                        $attendance_s_id = $this->School_attendance_model->add_attendance($params_s);                
                        }
                        
                    }else {
                        //do nothing for school attendance
                    }
                    
                    
                    }// settings check for school attendance
                    
                    }// presnt pickup or dropff buss attendance  entry end else case
                    
                    $output = array('status' => 'success');

                    $push_list = $this->Push_msg_map_model->get_all_push_msg_map_child_id($value->at_child_id);
                    //  echo $this ->db->last_query();exit();

                    $registatoin_ids = array();
                    $registatoin_ids_lang1 = array();
                    foreach ($push_list as $key11 => $value11) {
                        if($value11['push_language_name']==$settings_main['set_language']){
                        $registatoin_ids[] = $value11['push_msg_device_token'];
                        }else if ($value11['push_language_name']==$settings_main['set_language1']){
                         $registatoin_ids_lang1[] = $value11['push_msg_device_token']; 
                        }else {
                            // do nothing somthing wrong with either settings or push message map tables
                        }
                    }
                    /* send push notification */

                    // $registatoin_ids[0]='fEu-oFlxIYU:APA91bELcjyy47HE14P9K2JDpakRZdnG8HzYGm92oiy9deXO5LI57b6AjmZ4wq7vl1bUcS-i9pjEAYyNXsNAw_YDvx0NCLUTWFwR6zUXWVoBscA1gZy2EzIaXn0A9Vpc4M_GyVgRgu55';

                    $child = $this->Child_model->get_child($value->at_child_id);
                    //echo $child['child_push_notification'].$send_push_trip;
                    if($child['child_push_notification']=='Yes' && $send_push_trip=='Yes'){
                        
                    $formated_data = $this->common_model->get_push_message_and_title_multi_lang($value->at_trip_type, $value->at_pickup_or_drop_off, $value->at_child_status, $child['child_name'],$localization_lang,$localization_lang1);

                    $message = $formated_data['message'];
                    $title = $formated_data['title'];
                    $message_lang1 = $formated_data['message_lang1'];
                    $title_lang1 = $formated_data['title_lang1'];
                    $params = array(
                        'n_title' => $title,
                        'n_title_lang1' => $title_lang1,
                        'n_msg' => $message,
                        'n_msg_lang1' => $message_lang1,
                        'n_send_type' => 'push',
                        'n_type' => $value->at_pickup_or_drop_off,
                        'n_child_id' => $value->at_child_id,
                        'n_status' => $value->at_child_status,
                        'n_trip_type' => $value->at_trip_type,
                        'n_time_stamp' => $value->at_time_stamp_device,
                        'n_longi' => $value->at_loc_longi,
                        'n_lati' => $value->at_loc_lati
                    );

                    $notification_id = $this->Notification_model->add_notification($params);
                    
                    $device_date_format = date_create_from_format('Y-m-d H:i:s', $value->at_time_stamp_device);
                    $device_date= date_format($device_date_format, 'Y-m-d');

                    
                    if($device_date==date('Y-m-d')){

                    //if($value->at_time_stamp_device)
                    // for first language send push notification
                    if (!empty($registatoin_ids)) {

                        //$child_push=array('child_name' => $value->at_child_id);
                        $fields = array(
                            'registration_ids' => $registatoin_ids,
                            'notification' => array("body" => $message,
                                "title" => $title,
                                "From" => "Child safety app",
                                "sound" => 'default',
                                "click_action" => 'NotificationActivity',
                                'child_name' => $value->at_child_id,
                                'click_action' => 'NotificationActivity'
                            ),
                            'data' => array('child_name' => $value->at_child_id)
                        );

                        $this->common_model->send_push_notification($fields);
                    }
                    //for second language send push notification
                    if (!empty($registatoin_ids_lang1)) {

                        //$child_push=array('child_name' => $value->at_child_id);
                        $fields = array(
                            'registration_ids' => $registatoin_ids_lang1,
                            'notification' => array("body" => $message_lang1,
                                "title" => $title_lang1,
                                "From" => "Child safety app",
                                "sound" => 'default',
                                "click_action" => 'NotificationActivity',
                                'child_name' => $value->at_child_id,
                                'click_action' => 'NotificationActivity'
                            ),
                            'data' => array('child_name' => $value->at_child_id)
                        );

                        $this->common_model->send_push_notification($fields);
                    }
                    
                    } // end of checking of device dat to sever gmt date
                    
                    } //end of push messsage notification key check in child talbe 
                    
                    
                 
                } else {
                    // do nothing 
                }                              
                
                
            }//end of forach loop

            $output = array('status' => 'success');
        } else {
            $output = array('status' => 'fail', 'error' => '106', 'msg' => 'Data is null');
        }
        echo json_encode($output);
    }

    // finish a trip 

    public function finish_trip() {

        //{ "bus_id":"1", "trip_id":"1" }
        $data = $this->input->post('data');
        $data = stripslashes($data);
        $json_data = json_decode($data);
        $bus_id = $json_data->bus_id;
        $trip_id = $json_data->trip_id;
        $exit_flag=FALSE;
        if(isset($json_data->trip_taken_date)){
            $date = new DateTime($json_data->trip_taken_date);
            if($date->format('Y-m-d')!=gmdate('Y-m-d')){
                 $output = array('status' => 'fail', 'error' => '404', 'msg' => 'Wrong date. Please check the device date');
                $exit_flag=TRUE;
            }
        }
        
        if($exit_flag){
            //do nothing
        }else {
           if ($bus_id != '' && $trip_id != '') {
            $params = array(
                'bus_running_satus' => 'not running'
            );

            $output = array('status' => 'success');

            $this->Bu_model->update_bu($bus_id, $params);



            $params_trip = array(
                'finish_trip_id' => $trip_id,
                'finish_bus_id' => $bus_id
            );

            $finish_trip_detail_id = $this->Finish_trip_detail_model->add_finish_trip_detail($params_trip);
        } else {

            $output = array('status' => 'fail', 'error' => '130', 'msg' => 'Bus id is null');
        }  
        }
       

        echo json_encode($output);
    }

    // finish first half of a  trip 

    public function finish_first_half_trip() {

        //{ "bus_id":"1", "trip_id":"1" }
        $data = $this->input->post('data');
        $data = stripslashes($data);
        $json_data = json_decode($data);
        $bus_id = $json_data->bus_id;
        if ($bus_id != '') {
            $params = array(
                'bus_child_pickup_or_drop_off' => 'drop off'
            );

            $output = array('status' => 'success');

            $this->Bu_model->update_bu($bus_id, $params);
        } else {

            $output = array('status' => 'fail', 'error' => '131', 'msg' => 'Bus id is null');
        }

        echo json_encode($output);
    }

    // authentication from parent app
    public function auth_parent() {
        //{ 	"user_name": "d", 	"passwod": "1"}
        $data = $this->input->post('data');
        $data = stripslashes($data);
        $json_data = json_decode($data);

        if ($json_data->user_name != '' && $json_data->passwod != '') {

            if ($json_data->passwod == '123') {
                $output = array('status' => 'fail', 'error' => '107', 'msg' => 'The email you have entered exists in the school transportation database, but the account has not been activated.'
                    . ' Please enter your Email ID & access code (provided by the school) in the SIGN-UP/FORGOT PASSWORD page.');
            } else {
                $result = $this->Parent_app_user_model->get_parent_app_user_by_username_pass($json_data->user_name, $json_data->passwod);

                if (!empty($result)) {


                    $children = $this->Child_model->get_all_child_by_parent_id($result['parent_app_user_id']);
                    //echo $this->db->last_query();
                    if (!empty($children)) {
                        $output = array('status' => 'success');
                        $bus_list = $this->Bu_model->get_all_bus();
                        $children = $this->common_model->Bus_id_to_Bus_name_in_child_list($children, $bus_list);


                        $output['child_list'] = $children;
                        $output['push_msg_parent_id'] = $result['parent_app_user_id'];
                        $output['parent_id'] = $result['parent_app_user_id'];
                        $settings = $this->Setting_model->get_all_settings();
                        $output['settings'] = $settings;
                        $output['version_details'] = $this->common_model->parent_app_version_production();
                        if (isset($json_data->device)) {
                            $params = array(
                                'alog_parent_id' => $result['parent_app_user_id'],
                                'alog_device' => $json_data->device,
                                'alog_model' => $json_data->model,
                                'alog_os_version' => $json_data->os_version,
                                'alog_ip_address' => $this->common_model->getRealIpAddr(),
                                'alog_country' => $json_data->country,
                                'alog_time_zone' => $json_data->time_zone,
                                'alog_status' => "",
                                'alog_delete' => "",
                            );

                            $access_log_id = $this->Access_log_model->add_access_log($params);
                        }
                    } else {
                        $output = array('status' => 'fail', 'error' => '107', 'msg' => 'No child is added yet ! Please contact Admin');
                    }
                } else {
                    $output = array('status' => 'fail', 'error' => '108', 'msg' => 'Invalid Username or Password !');
                }
            }
        } else {
            $output = array('status' => 'fail', 'error' => '109', 'msg' => 'User name or Password empty !');
        }

        echo json_encode($output);
    }

    // Geting updated token from parent app


    public function update_token() {

        // for updating { 		"new_token": "xxx" , "push_msg_id":"1","push_msg_child_id":"2","push_msg_parent_id":"1","push_language_name":"English"}
        // for adding  { 		"new_token": "xxx" , "push_msg_id":"","push_msg_child_id":"2","push_msg_parent_id":"1","push_language_name":"English"}

        $data = $this->input->post('data');
        $data = stripslashes($data);
        $json_data = json_decode($data);
        $push_msg_id = $json_data->push_msg_id;
        if ($json_data->new_token != '' && $push_msg_id != '') {

            $params = array(
                'push_msg_device_token' => $json_data->new_token,
                'push_msg_child_id' => $json_data->push_msg_child_id,
                'push_msg_parent_id' => $json_data->push_msg_parent_id,
                'push_language_name' => $json_data->push_language_name,
            );

            $this->Push_msg_map_model->update_push_msg_map($push_msg_id, $params);
            $output = array('status' => 'success');
            $output['push_msg_id'] = $push_msg_id;
        } else if ($json_data->new_token != '' && $push_msg_id == '') {

            if ($json_data->push_msg_child_id != '' && $json_data->push_msg_parent_id != '') {
                $params = array(
                    'push_msg_child_id' => $json_data->push_msg_child_id,
                    'push_msg_parent_id' => $json_data->push_msg_parent_id,
                    'push_msg_device_token' => $json_data->new_token,
                    'push_language_name' => $json_data->push_language_name,
                );

                $push_msg_map_id = $this->Push_msg_map_model->add_push_msg_map($params);
                $output = array('status' => 'success');
                $output['push_msg_id'] = $push_msg_map_id;
            } else {
                $output = array('status' => 'fail', 'error' => '111', 'msg' => 'Child id or Parent id is missing ! Please contact admin');
            }
        } else {
            $output = array('status' => 'fail', 'error' => '110', 'msg' => 'Both old and new token are empty  or push push_msg_id is empty! Please contact admin');
        }

        echo json_encode($output);
    }

    // Geting updated token from parent app


    public function update_token_batch() {


        // for adding  { 		"new_token": "xxx" , "push_msg_id":"","push_msg_child_id":"2","push_msg_parent_id":"1"}

        $data = $this->input->post('data');
        $data = stripslashes($data);
        $json_data = json_decode($data);
       

        foreach ($json_data as $key_dat => $push_msg_data) {
        $push_language_name='English';
        if(isset($push_msg_data->push_language_name)){
            $push_language_name=$push_msg_data->push_language_name;
        }
            if ($push_msg_data->push_msg_child_id != '' && $push_msg_data->push_msg_parent_id != '') {
                $params = array(
                    'push_msg_child_id' => $push_msg_data->push_msg_child_id,
                    'push_msg_parent_id' => $push_msg_data->push_msg_parent_id,
                    'push_msg_device_token' => $push_msg_data->new_token,
                    'push_language_name' => $push_language_name,
                );
                $push_msg_map_id = $this->Push_msg_map_model->add_push_msg_map($params);
                $output['push_msg_ids'][] = "" . $push_msg_map_id;
            }
        }

        $output ['status'] = 'success';

        echo json_encode($output);
    }

    // list all notification for a child

    public function notification() {

        //   { "child_id": "2"  }

        $data = $this->input->post('data');
        $data = stripslashes($data);
        $json_data = json_decode($data);
        $child_id = $json_data->child_id;

        if ($child_id != '') {

            $notfications = $this->Notification_model->get_notification_by_child_id($child_id);


            $child = $this->Child_model->get_child($child_id);
            $bus_list = $this->Bu_model->get_all_bus();
            $child = $this->common_model->Bus_id_to_Bus_name_in_child($child, $bus_list);

            $output = array('status' => 'success');
            $output['child_details'] = $child;
            $output['notification_list'] = $notfications;
            // for development     $output['version_details']=$this->common_model->parent_app_version();
            $output['version_details'] = $this->common_model->parent_app_version_production();
        } else {
            $output = array('status' => 'fail', 'error' => '112', 'msg' => 'child id is null !');
        }

        echo json_encode($output);
    }

    // list attendance deails in parent app

    public function attendance() {

        //  { "parent_id": "2"  }

        $data = $this->input->post('data');
        $data = stripslashes($data);
        $json_data = json_decode($data);
        $parent_id = $json_data->parent_id;

        $children = $this->Child_model->get_all_child_by_parent_id($parent_id);

        $output['attendance_details'] = array();
        if (!empty($children)) {

            foreach ($children as $key => $child) {


                $child_id = $child['child_id'];

                if ($child_id != '') {
                    $total_morning_section_attendance = $this->Attendance_model->get_total_morning_section_attendance($child_id);
                    $total_after_noon_section_attendance = $this->Attendance_model->get_total_after_noon_section_attendance($child_id);
                    $total_morning_halfday_leave = $this->Attendance_model->get_total_morning_halfday_leave($child_id);
                    $total_after_noon_halfday_leave = $this->Attendance_model->get_total_after_noon_halfday_leave($child_id);
                    $full_day_leave = $this->Attendance_model->get_full_day_leave($child_id);
                    // echo $this->db->last_query();
                    if ($total_morning_section_attendance > $total_after_noon_section_attendance) {
                        $total_attendance = $total_after_noon_section_attendance;
                    } else {
                        $total_attendance = $total_morning_section_attendance;
                    }
                    $half_day_leave = ($total_morning_halfday_leave - $full_day_leave) + ($total_after_noon_halfday_leave - $full_day_leave);

                    $total_working_days = $total_attendance + $half_day_leave + $full_day_leave;

                    $attendance_percentage = ($total_attendance + ($half_day_leave / 2)) / $total_working_days;

                    $attendance_percentage = $attendance_percentage * 100;

                    $total_attendance_morning_only = $total_after_noon_halfday_leave - $full_day_leave;
                    $total_attendance_after_noon_only = $total_morning_halfday_leave - $full_day_leave;
                    $attendance_details = array(
                        'child_id' => $child_id,
                        'child_class' => $child['child_class'],
                        'child_section' => $child['child_section'],
                        'total_working_days' => $total_working_days . '',
                        'half_day_leave' => $half_day_leave . '',
                        'full_day_leave' => $full_day_leave . '',
                        'total_attendance_full_day' => $total_attendance . '',
                        'total_attendance_morning_only' => $total_attendance_morning_only . '',
                        'total_attendance_after_noon_only' => $total_attendance_after_noon_only . '',
                        'attendance_percentage' => $attendance_percentage . '',
                        'school_year' => '2017-2018'
                    );

                    $output['attendance_details'] [] = $attendance_details;
                }
            }// end of foreach


            $output ['status'] = 'success';
        } else {
            $output = array('status' => 'fail', 'error' => '113', 'msg' => 'No child is added yet ! Please contact Admin');
        }


        echo json_encode($output);
    }

    // get all child details for a parent in parent app

    public function child_satus() {
        //  { "parent_id": "2"  }

        $data = $this->input->post('data');
        $data = stripslashes($data);
        $json_data = json_decode($data);
        $parent_id = $json_data->parent_id;

        if ($parent_id != '') {
            $children = $this->Child_model->get_all_child_by_parent_id($parent_id);

            //echo $this->db->last_query();




            if (!empty($children)) {
                $output = array('status' => 'success');
                $output['version_details'] = $this->common_model->parent_app_version_production();
                $bus_list = $this->Bu_model->get_all_bus();
                $children = $this->common_model->Bus_id_to_Bus_name_in_child_list($children, $bus_list);

                $output['child_list'] = $children;
            } else {
                $output = array('status' => 'fail', 'error' => '115', 'msg' => 'No child is added yet ! Please contact Admin');
            }
        } else {
            $output = array('status' => 'fail', 'error' => '114', 'msg' => ' Parent id is null');
        }
        echo json_encode($output);
    }

    public function child_satus_notification() {
        //  { "child_id": "2"  }

        $data = $this->input->post('data');
        $data = stripslashes($data);
        $json_data = json_decode($data);
        $child_id = $json_data->child_id;

        if ($child_id != '') {
            $child = $this->Child_model->get_child($child_id);

            //echo $this->db->last_query();


            if (!empty($child)) {
                $output = array('status' => 'success');
                $output['version_details'] = $this->common_model->parent_app_version_production();
                $bus_list = $this->Bu_model->get_all_bus();
//                    print_r($bus_list);
                $child = $this->common_model->Bus_id_to_Bus_name_in_child($child, $bus_list);

                $output['child_details'] = $child;

                $notfications = $this->Notification_model->get_notification_by_child_id($child_id);
                $output['notification_list'] = $notfications;
                $settings = $this->Setting_model->get_supervisor_details();

                $output['supervisor_name'] = $settings['supervisor_name'];
                $output['supervisor_phone'] = $settings['supervisor_phone'];
            } else {
                $output = array('status' => 'fail', 'error' => '116', 'msg' => 'child is not exist in db !');
            }
        } else {
            $output = array('status' => 'fail', 'error' => '117', 'msg' => ' Parent id is null');
        }
        echo json_encode($output);
    }

    public function child_notification_list_for_calender() {



        if ($this->input->post('data')) {
            $data = $this->input->post('data');
            $data = stripslashes($data);
            $json_data = json_decode($data);
            $child_id = $json_data->child_id;
            $date = str_replace('-', '/', $json_data->date);

            $notfications = $this->Notification_model->get_notification_by_child_id_and_date($child_id, $date);

            $output = array('status' => 'success');
            $output['notfications_details'] = $notfications;
            $output['version_details'] = $this->common_model->parent_app_version_production();
        } else {
            $output = array('status' => 'fail', 'error' => '106', 'msg' => 'Data is null');
        }
        echo json_encode($output);
    }

    public function logo_image_list() {

        $notfications = $this->Logo_image_model->get_all_logo_images();
        if ($notfications) {
            $output = array('status' => 'success');
            $output['logo_images'] = $notfications;
        } else {
            $output = array('status' => 'fail', 'error' => '106', 'msg' => 'Data is null');
        }
        echo json_encode($output);
    }

    public function logout_parentapp() {

        //   //  { "push_msg_id": "2"  }

        $data = $this->input->post('data');
        $data = stripslashes($data);
        $json_data = json_decode($data);

        if ($json_data) {

            $push_msg_id = $json_data->push_msg_id;

            $this->Push_msg_map_model->delete_push_msg_map($push_msg_id);
            $output = array('status' => 'success');
        } else {
            $output = array('status' => 'fail', 'error' => '106', 'msg' => 'Push id is null !');
        }

        echo json_encode($output);
    }

    public function logout_parentapp_updated() {

        //   //  { "push_msg_id": "2"  }

        $data = $this->input->post('data');
        $data = stripslashes($data);
        $json_data = json_decode($data, TRUE);
        $push = array();
        foreach ($json_data as $key => $pus_data_value) {
            $push[] = $pus_data_value['push_msg_id'];
        }
        if (!empty($push)) {


            $this->Push_msg_map_model->delete_push_msg_map_batch($push);
            $output = array('status' => 'success');
        } else {
            $output = array('status' => 'fail', 'error' => '106', 'msg' => 'Push id is null !');
        }

        echo json_encode($output);
    }

    public function map_api() {

        //{"date":"2017-02-28","child_id":"1"}
        $data = $this->input->post('data');
        $data = stripslashes($data);
        $json_data = json_decode($data);
        $date = $json_data->date;
        $child_id = $json_data->child_id;
        $child = $this->Child_model->get_child($child_id);
        /*   $output = array('status' => 'fail','error'=>'140','msg'=>'This feature is coming soon. 
          For now, please use www.giisbustrack.com to view the bus location on the map.');
          echo json_encode($output);

          exit(); */
        // $trip = $this->Trip_model->get_all_active_trip_by_bus_id($result['bus_app_user_bus_id'], $trip_time);
         //&& $trip['push_notification']=='Yes'
        if($child['child_push_notification']=='Yes' ){
        
        $trip_id = '';
        
         
         
        if ($child['child_trip_no_pickup']) {
            $bus_drop = $this->Bu_model->get_bu($child['child_bus_no_pickup']);
            if ($bus_drop['bus_running_satus'] == 'running' and $bus_drop['bus_current_trip_id'] == $child['child_trip_no_pickup']) {
                $trip_id = $child['child_trip_no_pickup'];
            }
        }
        if ($child['child_trip_no_drop_off']) {
            $bus_drop = $this->Bu_model->get_bu($child['child_bus_no_drop_off']);
            
            if ($bus_drop['bus_running_satus'] == 'running' and $bus_drop['bus_current_trip_id'] == $child['child_trip_no_drop_off']) {
                $trip_id = $child['child_trip_no_drop_off'];
            }
        }
//$trip_id=3;
            if ($trip_id == '') {
  
            $current_buss= $this->Child_live_buss_update_model->get_child_live_buss_update($child_id);
            $bus_drop = $this->Bu_model->get_bu($current_buss['live_buss_id']);
            $trip = $this->Trip_model->get_trip($current_buss['live_trip_id']);
            $send_push_trip=$trip['push_notification'];          
            
            if ($bus_drop['bus_running_satus'] == 'running'  && $send_push_trip=='Yes' ){
                $trip_id=$current_buss['live_trip_id']; 
            }
           
            }
             
        if ($trip_id != '') {
            $tracking_list = $this->Tracking_model->get_all_tracking_for_map_api($date, $trip_id);
            $output = array('status' => 'success');
            $output['map_list'] = $tracking_list;
            $output['trip_id'] = $trip_id;
            $output['bus_details'] = $bus_drop;
            
        } else {
            $output = array('status' => 'fail', 'error' => '140', 'msg' => 'The trip with your child is not running at this time.');
        }
       } // end of checking for child push notification
       else {
            $output = array('status' => 'fail','error'=>'198','msg'=>'This feature has been disabled for your child. Please contact the Transport Supervisor to activate it.');
       }
        echo json_encode($output);
    }

    public function map_refresh() {
//               {"date":"2017-02-28","trip_id":"1","last_id":"18720"}

        $data = $this->input->post('data');
        $data = stripslashes($data);
        $json_data = json_decode($data);
        $date = $json_data->date;
        $last_id = $json_data->last_id;
        $trip_id = $json_data->trip_id;

        $flag_finish_trip = $this->Tracking_model->is_finished_trip($date, $trip_id);
        if (!$flag_finish_trip) {
            $tracking_list = $this->Tracking_model->get_lat_long_one_by_one_map($date, $trip_id, $last_id);

            //   echo $this->db->last_query();
            if ($tracking_list) {
                $output = array('status' => 'success');
                $output['map_list'] = $tracking_list;
            } else {
                $output = array('status' => 'fail', 'error' => '141', 'msg' => 'no data');
            }
        } else {
            $output = array('status' => 'fail', 'error' => '140', 'msg' => 'The trip with your child is not running at this time.');
        }
        echo json_encode($output);
    }

    public function user_verification() {
//               {"user_name":"ramya@dunamisworld.com","password":"123"}

        $data = $this->input->post('data');
        $data = stripslashes($data);
        $json_data = json_decode($data);
        $user_name = $json_data->user_name;
        $password = $json_data->password;

        $result = $this->Parent_app_user_model->is_user_name($user_name, $password);
        $id = $result['parent_app_user_id'];
        //echo $this->db->last_query();
//           exit();
        $passing_data = array();
        $passing_data['pin_number'] = $result['pin_number'];
        if ($result) {
            $to = $user_name;
            $from = 'lokatestudent@dunamisworld.com';
            $subject = 'LOKATE STUDENT: Account Activation with OTP';


            $message = $this->load->view('web_view/otp', $passing_data, TRUE);
            $headers = 'MIME-Version: 1.0' . "\n";
            $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
            $headers .= 'From: Lokate Student <' . $from . '>' . "\r\n";
            $mail = @mail($to, $subject, $message, $headers);
            if ($mail) {
                $output = array('status' => 'success', 'id' => $id, 'msg' => "We have sent you the One Time Password (OTP) to your email ID to complete the SIGN-UP process. Please enter it in the next screen. If you are unable to view the email in the INBOX, pls check the SPAM folder.");
            }
        } else {
            $present = array();
            $present = $this->Parent_app_user_model->is_user_name_present($user_name);
            if (empty($present)) {
                $output = array('status' => 'fail', 'error' => '140', 'msg' => "Your email id does not exist in the school database. Pls try again or send an email with your details to lokatestudent@dunamisworld.com");
            } else {



                $active_usr = array();
                $active_usr = $this->Parent_app_user_model->is_user_name_present_active($user_name);
                // print_r($active_usr); 
                // exit(); 
                if (empty($active_usr)) {


                    $output = array('status' => 'fail', 'error' => '191', 'msg' => "Your Email ID is not present in the transportation database. Please contact the school.");
                } else {
                    $st_act = $this->Parent_app_user_model->is_user_name_present_active_pass($user_name, $password);

                    if (!empty($st_act)) {
                        $output = array('status' => 'fail', 'error' => '140', 'msg' => "Your account is already active. Pls click FORGOT PASSWORD to receive your existing password by email.");
                    } else {
                        $output = array('status' => 'fail', 'error' => '140', 'msg' => "The access code you have entered is incorrect. Please try again.");
                    }
                }
            }
        }
        echo json_encode($output);
    }

    public function email_user_verification() {
        $data = $this->input->post('data');
        $data = stripslashes($data);
        $json_data = json_decode($data);
        $user_name = $json_data->user_name;
        $password = $json_data->password;
        $pin_number = $json_data->pin_number;
        $result = $this->Parent_app_user_model->is_pin_number($user_name, $password, $pin_number);

        if ($result) {
            $id = $result['parent_app_user_id'];
            $params = array(
                'parent_app_user_status' => '0'
            );
            //   $this->Parent_app_user_model->change_status($id,$params); 
            $output = array('status' => 'success', 'msg' => "To complete the account activation process, please enter a new password");
        } else {
            $output = array('status' => 'fail', 'error' => '140', 'msg' => "The OTP you have entered is incorrect. Please try again.");
        }
        echo json_encode($output);
    }

    public function change_password() {
        $data = $this->input->post('data');
        $data = stripslashes($data);
        $json_data = json_decode($data);
        $id = $json_data->id;
        $password = $json_data->new_password;
        $params = array(
            'parent_app_user_password' => $password,
            'parent_app_user_status' => '0'
        );
        $result = $this->Parent_app_user_model->update_password($id, $params);
//          echo $this->db->last_query();
//          exit();
        if ($result) {
            $output = array('status' => 'success', 'msg' => "Your account has been activated. Please use your email ID & the new password to login into the App.");
        } else {
            $output = array('status' => 'fail', 'error' => '140', 'msg' => 'Wrong ID.');
        }
        echo json_encode($output);
    }

    public function forgpt_password() {
        $data = $this->input->post('data');
        $data = stripslashes($data);
        $json_data = json_decode($data);
        $user_name = $json_data->user_name;

        $exist = $this->Parent_app_user_model->check_parent_email($user_name);
        if ($exist == '') {
            $output = array('status' => 'fail', 'msg' => 'Your email id does not exist in the school database. Pls try again or send an email with your details to lokatestudent@dunamisworld.com.');
        } else {
            $result = $this->Parent_app_user_model->forgot_password($user_name);
            // $password=$result['parent_app_user_password'];
            $passing_data = array();
            $passing_data['password'] = $result['parent_app_user_password'];


            $to = $user_name;

            $from = 'lokatestudent@dunamisworld.com';
            $headers = 'MIME-Version: 1.0' . "\n";
            $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
            $headers .= 'From: Lokate Student <' . $from . '>' . "\r\n";
            $headers .= "Reply-To: " . $from . "\r\n";
            $headers .= "X-Mailer: PHP/" . phpversion();
            $headers .= "X-Priority: 1" . "\r\n";


//mail('anoopgkrishna@gmail.com', 'the subject', 'the message', null,'-fwebmaster@example.com'); 



            $subject = 'LOKATE STUDENT: Forgot Password';

            $message = $this->load->view('web_view/password', $passing_data, TRUE);
//  $message='this is a test message';
            if ($to != '')
                $mail = mail($to, $subject, $message, $headers);




            if ($mail) {
                $output = array('status' => 'success', 'msg' => "The password has been sent to your email ID. Pls check your email.");
            } else {
                $output = array('status' => 'fail', 'error' => '140', 'msg' => "Your email id does not exist in the school database. Pls try again or send an email with your details to lokatestudent@dunamisworld.com");
            }
        }
        echo json_encode($output);
    }

    public function mail_test() {



        $this->load->library('email');

        $subject = 'This is a test';
        $message = '<p>This message has been sent for testing purposes.</p>';

// Get full html:
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
' . $message . '
</body>
</html>';
// Also, for getting full html you may use the following internal method:
//$body = $this->email->full_html($subject, $message);

        $result = $this->email
                ->from('anoopgkrishna@gmail.com')
                ->reply_to('anoopgkrishna@gmail.com')    // Optional, an account where a human being reads.
                ->to('anoopgispg@gmail.com')
                ->subject($subject)
                ->message($body)
                ->send();

        var_dump($result);
        echo '<br />';
        echo $this->email->print_debugger();

        exit;
    }

    // child update

    public function child_details_update() {

        //{"child_father_tel":"00000","child_home_tel":"048425633561","child_ids":["9"],"child_mother_tel":"9666555555","child_address":"Kochi"}
        $data = $this->input->post('data');
        $json_data = json_decode($data);
        $child_id = $json_data->child_ids;
        // $child_id= implode(",", $json_data->child_ids);
        if($json_data){
        $child_father_tel = $json_data->child_father_tel;
        $child_mother_tel = $json_data->child_mother_tel;
        $child_home_tel = $json_data->child_home_tel;
        $child_address = $json_data->child_address;
        if (!empty($child_id)) {
            $output = array('status' => 'success');
            $params = array(
                'child_father_tel' => $child_father_tel,
                'child_mother_tel' => $child_mother_tel,
                'child_home_tel' => $child_home_tel,
                'child_address' => $child_address
            );

            $update = $this->Child_model->json_update_child($child_id, $params);
            $output['msg']="Your profile has been updated successfully.";
            // $this->db->last_query();
            //  exit();
        } else {

            $output = array('status' => 'fail', 'error' => '130', 'msg' => 'child id is null !');
        }
        } else {

            $output = array('status' => 'fail', 'error' => '130', 'msg' => 'Data is null !');
        }

        echo json_encode($output);
    }

    public function bus_push_single_child() {

        //{ "child_id": "9","message": "Test Breakdown","title": "Test Title"}
        if ($this->input->post('data')) {

            $data = $this->input->post('data');
            $data = stripslashes($data);
            $json_data = json_decode($data);

            $push_list = $this->Push_msg_map_model->get_all_push_msg_map_child_id($json_data->child_id);
            //  echo $this ->db->last_query();exit();
            foreach ($push_list as $key => $value) {
                $registatoin_ids[] = $value['push_msg_device_token'];
            }

            //  print_r($registatoin_ids);exit();
            if (!empty($registatoin_ids)) {

                //$child_push=array('child_name' => $json_data->at_child_id);

                $fields = array(
                    'registration_ids' => $registatoin_ids,
                    'notification' => array("body" => $json_data->message,
                        "title" => $json_data->title,
                        "From" => "Child safety app",
                        "sound" => 'default',
                        "click_action" => 'NotificationActivity',
                        'child_name' => $json_data->child_id,
                        'click_action' => 'NotificationActivity'
                    ),
                    'data' => array('child_name' => $json_data->child_id)
                );

                $this->common_model->send_push_notification($fields);

                $params = array(
                    'n_title' => $json_data->title,
                    'n_msg' => $json_data->message,
                    'n_send_type' => 'push',
                    'n_type' => 'other',
                    'n_child_id' => $json_data->child_id,
                    'n_status' => '',
                    'n_trip_type' => ''
                );

                $notification_id = $this->Notification_model->add_notification($params);
            }
            $output = array('status' => 'success');
        } else {
            $output = array('status' => 'fail', 'error' => '106', 'msg' => 'Data is null');
        }
        echo json_encode($output);
    }

    public function bus_push_single_trip() {

        //{ "child_id": "9","message": "Test Breakdown","title": "Test Title"}
        if ($this->input->post('data')) {

            $data = $this->input->post('data');
            $data = stripslashes($data);
            $json_data = json_decode($data);

            $push_list = $this->Push_msg_map_model->get_all_push_msg_map_multiple_child_id($json_data->trip_id);

            foreach ($push_list as $key => $value) {
                $registatoin_ids[] = $value['push_msg_device_token'];
            }

            // print_r($registatoin_ids);exit();
            if (!empty($registatoin_ids)) {

                //$child_push=array('child_name' => $json_data->at_child_id);

                $fields = array(
                    'registration_ids' => $registatoin_ids,
                    'notification' => array("body" => $json_data->message,
                        "title" => $json_data->title,
                        "From" => "Child safety app",
                        "sound" => 'default',
                        "click_action" => 'NotificationActivity',
                        'child_name' => '',
                        'click_action' => 'NotificationActivity'
                    ),
                    'data' => array('child_name' => '')
                );

                $this->common_model->send_push_notification($fields);

                foreach ($push_list as $key => $value) {

                    $params = array(
                        'n_title' => $json_data->title,
                        'n_msg' => $json_data->message,
                        'n_send_type' => 'push',
                        'n_type' => 'other',
                        'n_child_id' => $value['push_msg_child_id'],
                        'n_status' => '',
                        'n_trip_type' => ''
                    );

                    $notification_id = $this->Notification_model->add_notification($params);
                    //    echo $this ->db->last_query();exit(); 
                }
            }
            $output = array('status' => 'success');
        } else {
            $output = array('status' => 'fail', 'error' => '106', 'msg' => 'Data is null');
        }
        echo json_encode($output);
    }

    public function bus_push_single_bus() {

        //{ "child_id": "9","message": "Test Breakdown","title": "Test Title"}
        if ($this->input->post('data')) {

            $data = $this->input->post('data');
            $data = stripslashes($data);
            $json_data = json_decode($data);
            //  print_r($json_data);exit(); 
            $push_list = $this->Push_msg_map_model->get_all_push_msg_map_multiple_child_id_bus_id($json_data->bus_id);
            //     echo $this ->db->last_query();exit(); 
            foreach ($push_list as $key => $value) {
                $registatoin_ids[] = $value['push_msg_device_token'];
            }

            // print_r($registatoin_ids);exit();
            if (!empty($registatoin_ids)) {

                //$child_push=array('child_name' => $json_data->at_child_id);

                $fields = array(
                    'registration_ids' => $registatoin_ids,
                    'notification' => array("body" => $json_data->message,
                        "title" => $json_data->title,
                        "From" => "Child safety app",
                        "sound" => 'default',
                        "click_action" => 'NotificationActivity',
                        'child_name' => '',
                        'click_action' => 'NotificationActivity'
                    ),
                    'data' => array('child_name' => '')
                );

                $this->common_model->send_push_notification($fields);

                foreach ($push_list as $key => $value) {

                    $params = array(
                        'n_title' => $json_data->title,
                        'n_msg' => $json_data->message,
                        'n_send_type' => 'push',
                        'n_type' => 'other',
                        'n_child_id' => $value['push_msg_child_id'],
                        'n_status' => '',
                        'n_trip_type' => ''
                    );

                    $notification_id = $this->Notification_model->add_notification($params);
                }
            }
            $output = array('status' => 'success');
        } else {
            $output = array('status' => 'fail', 'error' => '106', 'msg' => 'Data is null');
        }
        echo json_encode($output);
    }

    // finish a trip 

    public function change_parent_password() {

        //{ "use_name":"ramya@dunamisworld.com", "password":"1234" }
        $data = $this->input->post('data');
        $data = stripslashes($data);
        $json_data = json_decode($data);
        $user_name = $json_data->use_name;
        $old_password = $json_data->old_password;
        $new_password = $json_data->new_password;
        if ($user_name != '' && $old_password != '' && $new_password != '') {

            $username_and_password_exist = $this->Parent_app_user_model->is_usename_and_password($user_name, $old_password);
            // echo $this ->db->last_query();exit(); 
            if ($username_and_password_exist) {
                $params = array(
                    'parent_app_user_password' => $new_password
                );

                $updated = $this->Parent_app_user_model->update_password_using_usename($user_name, $params);
                //  echo $this ->db->last_query();exit(); 
                $output = array('status' => 'success');
                $output['msg']="Your password has been updated successfully."; 
            } else {
                $output = array('status' => 'fail', 'error' => '130', 'msg' => 'The password you have entered is incorrect. Pls try again.');
            }
        } else {

            $output = array('status' => 'fail', 'error' => '130', 'msg' => 'Wrong User ID');
        }

        echo json_encode($output);
    }

    //for students stayback

    public function student_list() {
        $output = array('status' => 'success');
        $output['student_list'] = $this->Child_model->get_all_child();
        echo json_encode($output);
    }
    public function app_config() {
        $output = array('status' => 'success');
        $output['settings'] = $this->Setting_model->get_current_settings();
        echo json_encode($output);
    }
    
//    public function testapi() {
//        $data = $this->input->post('data');
//        $data = stripslashes($data);
//        $json_data = json_decode($data,true);
//        $_POST = $json_data;
// 
//        echo $this->input->post('name');
//    }


}

?>
