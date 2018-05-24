<?php

class Json_lsedit extends CI_Controller {

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
        $this->load->model('Lsedit_app_user_model');
        $this->load->model('Setting_model');
        $this->load->model('Custom_notification_model');
         $this->load->model('Parent_child_mapping_model');

        header('Content-Type: application/json');
    }

    // authentication from parent app
    public function auth_lsedit() {
        //{ 	"user_name": "d", 	"passwod": "1"}
        $data = $this->input->post('data');
        $data = stripslashes($data);
        $json_data = json_decode($data);

        if ($json_data->user_name != '' && $json_data->passwod != '') {
            $result = $this->Lsedit_app_user_model->get_lsedit_app_user_by_username_pass($json_data->user_name, $json_data->passwod);

            if (!empty($result)) {

                $output = array('status' => 'success', 'login_id' => $result['lsedit_app_user_id']);
            } else {
                $output = array('status' => 'fail', 'error' => '108', 'msg' => 'Invalid Username or Password !');
            }
        } else {
            $output = array('status' => 'fail', 'error' => '109', 'msg' => 'User name or Password empty !');
        }
        $settings = $this->Setting_model->get_all_settings();
        foreach ($settings as $key => $value) {
            $output ['card_scan_type'] = $value['card_scan_type'];
        }
        echo json_encode($output);
    }

    public function bus_list() {
        // { 	"login_id": "1" }
        $output = array('status' => 'success');
        $data = $this->input->post('data');
        $data = stripslashes($data);
        $json_data = json_decode($data);
        $bus = $this->Bu_model->get_all_bus();
        $custom_notification_list = $this->Custom_notification_model->get_all_notification();
        // print_r($bus);
        foreach ($bus as $key => $bus_val) {
            $bus_detail[$key]['bus_id'] = $bus_val['bus_id'];
            $bus_detail[$key]['bus_name'] = $bus_val['bus_name'];
            $bus_detail[$key]['bus_desc'] = $bus_val['bus_desc'];
            $bus_detail[$key]['driver_name'] = $bus_val['driver_name'];
            $bus_detail[$key]['driver_phone'] = $bus_val['driver_phone'];
            $bus_detail[$key]['driver_assistant'] = $bus_val['driver_assistant'];
            $bus_detail[$key]['assistant_phone'] = $bus_val['assistant_phone'];
        }
        
        $output['bus_details'] = $bus_detail;
        $output['custom_notification_list'] = $custom_notification_list;
        echo json_encode($output);
    }

    public function bus_details() {
        // { 	"bus_id": "1" }
        $data = $this->input->post('data');
        $data = stripslashes($data);
        $json_data = json_decode($data);
        $bus_id = $json_data->bus_id;
        $output = array('status' => 'success');
        $bus = $this->Bu_model->get_bu($bus_id);
        $trip = $this->Trip_model->get_all_trip_by_bus_id($bus_id);
        $bus_app_user = $this->Bus_app_user_model->get_bus_app_user_by_bus_id($bus_id);

        $output['status'] = 'success';
        $output['trip_list'] = $trip;
        $bus_detail['bus_name'] = $bus['bus_name'];
        $bus_detail['driver_name'] = $bus['driver_name'];
        $bus_detail['bus_desc'] = $bus['bus_desc'];
        $bus_detail['driver_assistant'] = $bus['driver_assistant'];
        $bus_detail['driver_phone'] = $bus['driver_phone'];
        $bus_detail['bus_user_name'] = $bus_app_user['bus_app_user_name'];
        $bus_detail['bus_user_password'] = $bus_app_user['bus_app_user_password'];
        $bus_detail['assistant_phone'] = $bus['assistant_phone'];
        $output['bus_detail'] = $bus_detail;
        $custom_notification_list = $this->Custom_notification_model->get_all_notification();
        $output['custom_notification_list'] = $custom_notification_list;
        echo json_encode($output);
    }

    public function search_child_satus_with_keywords() {
        //  

        $data = $this->input->post('data');
        $data = stripslashes($data);
        $json_data = json_decode($data);
        $search_key = $json_data->search_key;
        $search_word = $json_data->search_word;
        if ($search_key == 'phone_number') {

            $child_list = $this->Child_model->get_child_id_using_phone_number_like($search_word);
            $search_key1='PHONE NUMBER';
        }
        if ($search_key == 'register_number') {

            $child_list = $this->Child_model->get_child_id_using_register_number_like($search_word);
            $search_key1='REGISTRATION number';
//            echo $this->db->last_query();
//          exit();
        }
        if ($search_key == 'email') {

            $child_list = $this->Child_model->get_child_id_using_email_like($search_word);
             $search_key1='EMAIL';
        }
        if ($search_key == 'name') {

            $child_list = $this->Child_model->get_child_id_using_name_like($search_word);
            $search_key1='NAME';
        }



        if (!empty($child_list)) {

            $output = array('status' => 'success');
            $bus_list = $this->Bu_model->get_all_bus();
            $child_list = $this->common_model->Bus_id_to_Bus_name_in_child_list($child_list, $bus_list);
            $output['child_details'] = $child_list;
        } else {
            $output = array('status' => 'fail', 'error' => '112', 'msg' => $search_key1 . ' not found in the school database. Pls try again.');
        }

        echo json_encode($output);
    }

    public function search_child_satus_with_keywords_result() {
        //  { "child_id": "2"  }

        $data = $this->input->post('data');
        $data = stripslashes($data);
        $json_data = json_decode($data);
        $child_id = $json_data->child_id;


        if ($child_id != '') {

            $notfications = $this->Notification_model->get_last_notification_by_child_id($child_id);
            // echo $this->db->last_query();
            $child = $this->Child_model->get_child($child_id);
            $bus_list = $this->Bu_model->get_all_bus();

            $child = $this->common_model->Bus_id_to_Bus_name_in_child($child, $bus_list);
            $children [] = $child;
            $trip_list = $this->Trip_model->get_all_trip();

            $child = $this->common_model->trip_id_to_Trip_name_in_child_list($children, $trip_list);

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
            $output['child_details'] = $child;
            $output['notification_list'] = $notfications;
        } else {
            $output = array('status' => 'fail', 'error' => '112', 'msg' => 'child id is null !');
        }

        echo json_encode($output);
    }

    // Get trip list from backend
    public function trip_list() {

        //{ "trip_id": "1","bus_id":"1","sort_order":""}

        $data = $this->input->post('data');
        $data = stripslashes($data);
        $json_data = json_decode($data);
        $bus_id = $json_data->bus_id;
        $trip_id = $json_data->trip_id;
        $sort_order = $json_data->sort_order;

        if ($json_data->trip_id != '' && $bus_id != '') {


            $child = $this->Child_model->get_all_child_trip($json_data->trip_id, $sort_order);

            $output = array('status' => 'success');
            $output['children_list'] = $child;
            $custom_notification_list = $this->Custom_notification_model->get_all_notification();
            $output['custom_notification_list'] = $custom_notification_list;
        } else {
            $output = array('status' => 'fail', 'error' => '104', 'msg' => 'Wrong Trip id !');
        }
        echo json_encode($output);
    }

    public function child_satus() {
        //  { "child_id": "2"  }

        $data = $this->input->post('data');
        $data = stripslashes($data);
        $json_data = json_decode($data);
        $child_id = $json_data->child_id;

        if ($child_id != '') {
            $children[] = $this->Child_model->get_child($child_id);

            if (!empty($children)) {
                $output = array('status' => 'success');

                $bus_list = $this->Bu_model->get_all_bus();
                // $children= $this->common_model->Bus_id_to_Bus_name_in_child_list($children,$bus_list);

                $output['child_list'] = $children;

                $trip_list = $this->Trip_model->get_all_trip();
                $output['trip_list'] = $trip_list;
                $bus = $this->Bu_model->get_all_bus();
                $output['bus_list'] = $bus;
            } else {
                $output = array('status' => 'fail', 'error' => '115', 'msg' => 'No child is added yet ! Please contact Admin');
            }
        } else {
            $output = array('status' => 'fail', 'error' => '114', 'msg' => ' Parent id is null');
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

    public function child_update() {


        $data = $this->input->post('data');
        // $data=  stripslashes($data);
        $json_data = json_decode($data);
        $child_id = $json_data->child_id;

        if ($child_id != '') {
            if ($this->Child_model->get_count_all_student_by_nfc_id($json_data->child_nfc_id, $child_id) == 0) {

                if ($this->Child_model->get_count_all_student_by_nfc_id($json_data->child_nfc_id, $child_id) == 0) {

                    $params = array(
                        'child_name' => $json_data->child_name,
                        'child_gender' => $json_data->child_gender,
                        'child_class' => $json_data->child_class,
                        'child_section' => $json_data->child_section,
                        'child_teacher' => $json_data->child_teacher,
                        'child_bus_no_pickup' => ($json_data->child_bus_no_pickup)?$json_data->child_bus_no_pickup:"0",
                        'child_bus_no_drop_off' => ($json_data->child_bus_no_drop_off)?$json_data->child_bus_no_drop_off:"0",
                        'child_drop_off_order' => $json_data->child_drop_off_order,
                        'child_pickup_order' => $json_data->child_pickup_order,
                        'child_father_name' => $json_data->child_father_name,
                        'child_mother_name' => $json_data->child_mother_name,
                        'child_father_tel' => $json_data->child_father_tel,
                        'child_mother_tel' => $json_data->child_mother_tel,
                        'child_home_tel' => $json_data->child_home_tel,
                        'child_blood_group' => $json_data->child_blood_group,
                        'child_address' => $json_data->child_address,
                        'child_area' => $json_data->child_area,
                        'child_city' => $json_data->child_city,
                        'child_pickup_lati' => $json_data->child_pickup_lati,
                        'child_pickup_longi' => $json_data->child_pickup_longi,
                        'child_drop_off_lati' => $json_data->child_drop_off_lati,
                        'child_drop_off_longi' => $json_data->child_drop_off_longi,
                        'child_sms' => $json_data->child_sms,
                        'child_push_notification' => $json_data->child_push_notification,
                        'child_trip_no_pickup' => ($json_data->child_trip_no_pickup)?$json_data->child_trip_no_pickup:"0",
                        'child_trip_no_drop_off' => ($json_data->child_trip_no_drop_off)?$json_data->child_trip_no_drop_off:"0",
                        'child_personal_transport_pickup' => $json_data->child_personal_transport_pickup,
                        'child_personal_transport_drop_off' => $json_data->child_personal_transport_drop_off,
                        'child_pickup_time' => $json_data->child_pickup_time,
                        'child_dropoff_time' => $json_data->child_dropoff_time,
                        'child_handicapped_type' => $json_data->child_handicapped_type,
                        'child_nfc_id' => $json_data->child_nfc_id,
                        'child_reg_no' => $json_data->child_reg_no,
                    );


                    $this->Child_model->update_child($child_id, $params);

                    $output = array('status' => 'success', 'msg' => 'Student details updated successfully!');
                } else {
                    $output = array('status' => 'fail', 'error' => '190', 'msg' => 'Registration id already exist in school database !');
                }
            } else {
                $output = array('status' => 'fail', 'error' => '190', 'msg' => 'NFC Card id already exist in school database !');
            }
        } else {
            $output = array('status' => 'fail', 'error' => '130', 'msg' => 'Student id is empty ! Please contact Admin');
        }

        echo json_encode($output);
    }
    public function child_update_nfc() {


        $data = $this->input->post('data');
        // $data=  stripslashes($data);
        $json_data = json_decode($data);
        $child_id = $json_data->child_id;

        if ($child_id != '') {
            if ($this->Child_model->get_count_all_student_by_nfc_id($json_data->child_nfc_id, $child_id) == 0) {

                if ($this->Child_model->get_count_all_student_by_nfc_id($json_data->child_nfc_id, $child_id) == 0) {

                    $params = array(

                        'child_nfc_id' => $json_data->child_nfc_id
                    );


                    $this->Child_model->update_child($child_id, $params);

                    $output = array('status' => 'success', 'msg' => 'Student details updated successfully!');
                } else {
                    $output = array('status' => 'fail', 'error' => '190', 'msg' => 'Registration id already exist in school database !');
                }
            } else {
                $output = array('status' => 'fail', 'error' => '190', 'msg' => 'NFC Card id already exist in school database !');
            }
        } else {
            $output = array('status' => 'fail', 'error' => '130', 'msg' => 'Student id is empty ! Please contact Admin');
        }

        echo json_encode($output);
    }

    public function child_bus_change() {


        $data = $this->input->post('data');
        // $data=  stripslashes($data);
        $json_data = json_decode($data);
        $child_id = $json_data->child_id;
        if ($child_id != '') {
            $params = array(
                'child_bus_no_pickup' => $json_data->child_bus_no_pickup,
                'child_bus_no_drop_off' => $json_data->child_bus_no_drop_off,
                //'child_drop_off_order' => $json_data->child_drop_off_order,
                //'child_pickup_order' => $json_data->child_pickup_order,                       
                'child_trip_no_pickup' => $json_data->child_trip_no_pickup,
                'child_trip_no_drop_off' => $json_data->child_trip_no_drop_off,
            );


            $this->Child_model->update_child($child_id, $params);

            $output = array('status' => 'success', 'msg' => 'Student details updated successfully!');
        } else {
            $output = array('status' => 'fail', 'error' => '130', 'msg' => 'Student id is empty ! Please contact Admin');
        }

        echo json_encode($output);
    }

    public function bus_update() {
        $data = $this->input->post('data');
        $data = stripslashes($data);
        $json_data = json_decode($data);
        $bus_id = $json_data->bus_id;
        if ($bus_id != '') {
            $params = array(
                'driver_name' => $json_data->driver_name,
                'driver_assistant' => $json_data->driver_assistant,
                'driver_phone' => $json_data->driver_phone,
                'assistant_phone' => $json_data->assistant_phone,
            );

            $this->Bu_model->update_bu($bus_id, $params);
            $params_bus_app = array(
                'bus_app_user_name' => $json_data->user_name,
                'bus_app_user_password' => $json_data->user_password,
            );
            $this->Bus_app_user_model->update_bus_app_user_by_bus_id($bus_id, $params_bus_app);

            $output = array('status' => 'success', 'msg' => 'Bus details updated successfully!');
        } else {
            $output = array('status' => 'fail', 'error' => '130', 'msg' => 'Bus id is empty ! Please contact Admin');
        }
        echo json_encode($output);
    }

    public function bus_push_single_child() {

        //{ "child_id": "9","message": "Test Breakdown","title": "Test Title"}
        if ($this->input->post('data')) {

            $data = $this->input->post('data');
            $data = stripslashes($data);
            $json_data = json_decode($data);

            
           $settings_main = $this->Setting_model->get_current_settings();   
           $push_list = $this->Push_msg_map_model->get_all_push_msg_map_child_id($json_data->child_id);
            
            foreach ($push_list as $key => $value) {
                if($value['push_language_name']==$settings_main['set_language']){
                $registatoin_ids[] = $value['push_msg_device_token'];
                }else if ($value['push_language_name']==$settings_main['set_language1']){
                 $registatoin_ids_lang1[] = $value['push_msg_device_token']; 
                }else {
                    // do nothing somthing wrong with either settings or push message map tables
                }
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
             }
               //for second language send push notification
                if (!empty($registatoin_ids_lang1)) {

                //$child_push=array('child_name' => $json_data->at_child_id);

                $fields = array(
                    'registration_ids' => $registatoin_ids_lang1,
                    'notification' => array("body" => $json_data->message_lang1,
                        "title" => $json_data->title_lang1,
                        "From" => "Child safety app",
                        "sound" => 'default',
                        "click_action" => 'NotificationActivity',
                        'child_name' => $json_data->child_id,
                        'click_action' => 'NotificationActivity'
                    ),
                    'data' => array('child_name' => $json_data->child_id)
                );
                  $this->common_model->send_push_notification($fields);
                }
                $params = array(
                    'n_title' => $json_data->title,
                    'n_msg' => $json_data->message,
                    'n_send_type' => 'push',
                    'n_type' => 'other',
                    'n_child_id' => $json_data->child_id,
                    'n_status' => 'custom',
                    'n_title_lang1' => $json_data->title_lang1,
                    'n_msg_lang1' => $json_data->message_lang1,                   
                    'n_trip_type' => '',
                    'n_time_stamp' => date('Y-m-d H:i:s')
                );

                $notification_id = $this->Notification_model->add_notification($params);
            
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

           
            $settings_main = $this->Setting_model->get_current_settings();
            $push_list = $this->Push_msg_map_model->get_all_push_msg_map_multiple_child_id($json_data->trip_id);
            
            foreach ($push_list as $key => $value) {
                if($value['push_language_name']==$settings_main['set_language']){
                $registatoin_ids[] = $value['push_msg_device_token'];
                }else if ($value['push_language_name']==$settings_main['set_language1']){
                 $registatoin_ids_lang1[] = $value['push_msg_device_token']; 
                }else {
                    // do nothing somthing wrong with either settings or push message map tables
                }
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
                        'child_name' => '',
//                        'click_action' => 'NotificationActivity'
                    ),
                    'data' => array('child_name' => '')
                );

                $this->common_model->send_push_notification($fields);
             }
               //for second language send push notification
                if (!empty($registatoin_ids_lang1)) {

                //$child_push=array('child_name' => $json_data->at_child_id);

                
                $fields = array(
                    'registration_ids' => $registatoin_ids_lang1,
                    'notification' => array("body" => $json_data->message_lang1,
                        "title" => $json_data->title_lang1,
                        "From" => "Child safety app",
                        "sound" => 'default',
                        'child_name' => '',
//                        'click_action' => 'NotificationActivity'
                    ),
                    'data' => array('child_name' => '')
                );
                  $this->common_model->send_push_notification($fields);
                }
                $push_list_temp=$push_list;
                $push_list=array();
                 foreach ($push_list_temp as $key => $value) {
                    $push_list[]= $value['push_msg_child_id'];
                 }
                
                 $push_list = array_unique($push_list);
                
                foreach ($push_list as $key => $value) {

                    $params = array(
                        'n_title' => $json_data->title,
                        'n_msg' => $json_data->message,
                        'n_send_type' => 'push',
                        'n_type' => 'custom',
                        'n_child_id' => $value,
                        'n_status' => 'custom',
                        'n_title_lang1' => $json_data->title_lang1,
                        'n_msg_lang1' => $json_data->message_lang1,                        
                        'n_trip_type' => '',
                        'n_time_stamp' => date('Y-m-d H:i:s')
                    );

                    $notification_id = $this->Notification_model->add_notification($params);
                    //    echo $this ->db->last_query();exit(); 
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

            $settings_main = $this->Setting_model->get_current_settings();
            $push_list = $this->Push_msg_map_model->get_all_push_msg_map_multiple_child_id_bus_id($json_data->bus_id);
            
            foreach ($push_list as $key => $value) {
                if($value['push_language_name']==$settings_main['set_language']){
                $registatoin_ids[] = $value['push_msg_device_token'];
                }else if ($value['push_language_name']==$settings_main['set_language1']){
                 $registatoin_ids_lang1[] = $value['push_msg_device_token']; 
                }else {
                    // do nothing somthing wrong with either settings or push message map tables
                }
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
                        'child_name' => '',
//                        'click_action' => 'NotificationActivity'
                    ),
                    'data' => array('child_name' => '')
                );
             }
                $this->common_model->send_push_notification($fields);
                               //for second language send push notification
                if (!empty($registatoin_ids_lang1)) {

                //$child_push=array('child_name' => $json_data->at_child_id);
                
                $fields = array(
                    'registration_ids' => $registatoin_ids_lang1,
                    'notification' => array("body" => $json_data->message_lang1,
                        "title" => $json_data->title_lang1,
                        "From" => "Child safety app",
                        "sound" => 'default',
                        'child_name' => '',
//                        'click_action' => 'NotificationActivity'
                    ),
                    'data' => array('child_name' => '')
                );
                $this->common_model->send_push_notification($fields);
                }
                $push_list_temp=$push_list;
                $push_list=array();
                 foreach ($push_list_temp as $key => $value) {
                    $push_list[]= $value['push_msg_child_id'];
                 }
                
                 $push_list = array_unique($push_list);
                
                foreach ($push_list as $key => $value) {
                   
                    $params = array(
                        'n_title' => $json_data->title,
                        'n_msg' => $json_data->message,
                        'n_send_type' => 'push',
                        'n_type' => 'custom',
                        'n_child_id' => $value,
                        'n_status' => 'custom',
                        'n_trip_type' => '',
                        'n_title_lang1' => $json_data->title_lang1,
                        'n_msg_lang1' => $json_data->message_lang1,
                        'n_time_stamp' => date('Y-m-d H:i:s')
                    );

                    $notification_id = $this->Notification_model->add_notification($params);
                }
            
            $output = array('status' => 'success');
        } else {
            $output = array('status' => 'fail', 'error' => '106', 'msg' => 'Data is null');
        }
        echo json_encode($output);
    }

    public function email_attendance_csv() {

        ini_set('memory_limit', '200M');
        $json_data = json_decode($this->input->post('data'));
        $date1 = $json_data->date;
        $email = $json_data->email;

        $date = $date1;
        $date = date("Y-m-d", strtotime($date));

        $att_list = $this->Attendance_model->get_all_attendance_download_pickup($date);
        $att_dropoff = $this->Attendance_model->get_all_attendance_download_dropoff($date);
        $settings = $this->Setting_model->get_all_settings();
        $la_time = new DateTimeZone('UTC');
        foreach ($settings as $key => $value) {
            $la_time = new DateTimeZone($value['timezone']);
        }

        // echo $this->db->last_query(); exit(); 
        if ($att_list == '' || $att_dropoff == '') {
            $output = array('status' => 'NO Attendance');
        } else {

            $bus_list = $this->Bu_model->get_all_bus();
            $trip_list = $this->Trip_model->get_full_trip();
            for ($j = 0; $j < count($att_list); $j++) {
                $att_list[$j] = $this->common_model->Bus_id_to_Bus_name_in_child($att_list[$j], $bus_list);

                $att_list[$j] = $this->common_model->trip_id_to_trip_name_in_child($att_list[$j], $trip_list);

                $flag_is_drop_off = true;
                for ($k = 0; $k < count($att_dropoff); $k++) {

                    if (($att_dropoff[$k]['at_child_id'] == $att_list[$j]['at_child_id']) && ($att_dropoff[$k]['at_trip_id'] == $att_list[$j]['at_trip_id'])) {
                        $att_list[$j]['at_child_drop_off_time'] = $att_dropoff[$k]['at_time_stamp_device'];
                        $att_list[$j]['card_type'] = $att_dropoff[$k]['at_loc_data_type'];
                        $flag_is_drop_off = false;
                    }
                }
                if ($flag_is_drop_off) {
                    $att_list[$j]['at_child_drop_off_time'] = '';
                    $att_list[$j]['card_type'] = '';
                }
            }

            //  print_r($att_list);               exit();
            $result = $att_list;
//            header("Content-type: application/csv");
//            header("Content-Disposition: attachment; filename=\"BusList".".csv\"");
//            header("Pragma: no-cache");
//            header("Expires: 0");
            $time = date('m-d-Y_hia');
            $filename = "report_" . $time . ".csv";
            $filename_xl = "report_" . $time . ".xls";
            $csvname = FCPATH . "uploads/csv/" . $filename;
            $handle = fopen($csvname, 'w');
            fputcsv($handle, array('#', 'NAME', 'NFC', 'STUDENT ID', 'CLASS','SECTION', 'DATE', 'PICKUP BUS', 'PICKUP TIME', 'DROPOFF BUS', 'DROPOFF TIME', 'SCAN TYPE', 'PRESENT/ABSENT', 'TRIP'));
            $i = 1;

            foreach ($result as $data) {
                $datetime = new DateTime($data["at_time_stamp"]);
                $datetime->setTimezone($la_time);
                if (substr($data["at_loc_data_type"], -1) == 's') {
                    $pickup_type = 'C';
                } else {
                    $pickup_type = 'T';
                }
                if (substr($data["card_type"], -1) == 's') {
                    $dropoff_type = 'C';
                } else {
                    $dropoff_type = 'T';
                }
                $type = $pickup_type . ',' . $dropoff_type;
                $pickup_time= date('Y-m-d H:i:s',strtotime('+4 hour',strtotime($data["at_time_stamp"])));
                $dropoff_time= date('Y-m-d H:i:s',strtotime('+4 hour',strtotime($data["at_child_drop_off_time"])));                                     
                fputcsv($handle, array($i, $data["child_name"], $data["child_nfc_id"], $data["child_reg_no"], $data["child_class"] , $data["child_section"], date("j-M", strtotime($data["at_time_stamp"])), $data["child_bus_no_pickup"], date('G:i',  strtotime($pickup_time)), $data["child_bus_no_drop_off"],date('G:i',  strtotime($dropoff_time)), $type, ucfirst($data["at_child_status"]), $data["at_loc_longi"]));
                $i++;
            }
     //       fclose($handle); //close the file
            file_put_contents(FCPATH . "uploads/csv/data.csv", $handle);
//              exit;



            $thisfile = $csvname;
            $file_size = filesize($thisfile);
            $handle = fopen($thisfile, "r");
            $content = fread($handle, $file_size);
            fclose($handle);

            $encoded = chunk_split(base64_encode($content));

// create the email and send it off
            $dateformat = date('d F Y', strtotime($date1));
//            $subject = "Student Report (" . $dateformat . ") - SAFETY";
            
            
            $dateandtime = date('Y-m-d H:i:s');
            $datetime = new DateTime($dateandtime);
            $datetime->setTimezone($la_time);
            $in_time = $datetime->format('Y-m-d H:i:s');
            $datewithtime= date("Y-m-d-H:i:s", strtotime($in_time));
            
            $subject = SCHOOL_SHORT_NAME."-ATTENDANCE-".$datewithtime;
            
            
            
           // $subject = "Attendance Report -". SCHOOL_SHORT_NAME ;
            $from = "online@dunamisworld.com";
            $headers = 'MIME-Version: 1.0' . "\n";
            $headers .= 'From: ' . $from . "\r\n";
            $headers .= "CC: online@dunamisworld.com\r\n";
            $headers .= 'Content-Type: multipart/mixed ;
    
    boundary="----=_NextPart_001_0011_1234ABCD.4321FDAC"' . "\n";

            $message = '

This is a multi-part message in MIME format.

------=_NextPart_001_0011_1234ABCD.4321FDAC
Content-Type: text/plain;
        charset="us-ascii"
Content-Transfer-Encoding: 7bit

Dear Sir/Madam,

Please find attached the detailed report (in CSV format) for Students travelling in the school bus for following date in the selected school. 
You can open this file Microsoft Excel, Google Sheets or any other spreadsheet application. (If you face any issues, please contact us on the details provided below)

Date

' . $dateformat . '


School


' . SCHOOL_SHORT_NAME . '

Regards,

Lokate Student Team
WhatsApp Number: +971-50-7482052 (For a quicker response)
Email ID: lokatestudent@dunamisworld.com


------=_NextPart_001_0011_1234ABCD.4321FDAC
Content-Type: application/octet-stream;  name="';

            $message .= "$thisfile";
            $message .= '"
Content-Transfer-Encoding: base64
Content-Disposition: attachment; filename="';
            $message .= "$filename";
            $message .= '"

';
            $message .= "$encoded";
            $message .= '

------=_NextPart_001_0011_1234ABCD.4321FDAC--

';

// now send the email
            $mail = mail($email, $subject, $message, $headers, "-f$from");
            if ($mail) {
                $output = array('status' => 'Success', 'msg' => 'Email sent successfully');
                // unlink($csvname);
            } else {
                $output = array('status' => 'Failure');
            }
        }
        echo json_encode($output);
    }

    public function forgpt_password() {
        $data = $this->input->post('data');
        $data = stripslashes($data);
        $json_data = json_decode($data);
        $user_name = $json_data->father_email;
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

    
    
    
    public function email_touch_screen_scan_report_csv() {

        ini_set('memory_limit', '200M');
        $json_data = json_decode($this->input->post('data'));
        $date1 = $json_data->date;
        $email = $json_data->email;

        $date= $date1;
        $date = date("Y-m-d", strtotime($date));
        $date_7day=date('Y-m-d', strtotime('-7 days'));
        
        
         $settings = $this->Setting_model->get_all_settings();
        $la_time = new DateTimeZone('UTC');
        foreach ($settings as $key => $value) {
            $la_time = new DateTimeZone($value['timezone']);
        }
        
        
        if($date<$date_7day)
        {
        $att_list = $this->Attendance_model->get_all_copy_attendance_download($date); 
        
        }
        else {
        $att_list = $this->Attendance_model->get_all_attendance_download($date); 
         } 
          // print_r($att_list);               exit();
        // $this->db->last_query(); exit();
     if($att_list=='')
        {
             $output = array('status' => 'NO Attendance'); 
        }
        else
        {
            
             $bus_list=$this->Bu_model->get_all_bus();  
             $trip_list = $this->Trip_model->get_full_trip();
              for ($j = 0; $j < count($att_list); $j++) {
                    $att_list[$j]= $this->common_model->Bus_id_to_Bus_name_in_attendance($att_list[$j],$bus_list);   
              }
            $att_list= $this->common_model->trip_id_to_Trip_name_in_child_list_for_ls_editor_report($att_list,$trip_list);
          
        
            $result = $att_list;
//            header("Content-type: application/csv");
//            header("Content-Disposition: attachment; filename=\"BusList".".csv\"");
//            header("Pragma: no-cache");
//            header("Expires: 0");
            $time = date('m-d-Y_hia');
            $filename = "report_" . $time . ".csv";
            $filename_xl = "report_" . $time . ".xls";
            $csvname = FCPATH . "uploads/csv/" . $filename;
            $handle = fopen($csvname, 'w');
            fputcsv($handle, array('#', 'BUS #', 'TRIP', 'NAME', 'ID', 'SCAN TIME'));
            $i = 1;

            foreach ($result as $data) {
                // $time= date('Y-m-d H:i:s',strtotime('+4 hour',strtotime($data["at_time_stamp"])));
                
                 $datetime = new DateTime($data["at_time_stamp"]);
                $datetime->setTimezone($la_time);
                $in_time = $datetime->format('Y-m-d H:i:s');
                $time = date("H:i:s", strtotime($in_time));
                
                fputcsv($handle, array($i, $data["bus_desc"], $data["child_trip_pickup_title"], $data["child_name"], $data["child_reg_no"] , date("G.i", strtotime($time))));
                $i++;
            }
     //       fclose($handle); //close the file
            file_put_contents(FCPATH . "uploads/csv/data.csv", $handle);
//              exit;



            $thisfile = $csvname;
            $file_size = filesize($thisfile);
            $handle = fopen($thisfile, "r");
            $content = fread($handle, $file_size);
            fclose($handle);

            $encoded = chunk_split(base64_encode($content));

// create the email and send it off
            $dateformat = date('d F Y', strtotime($date1));
//            $subject = "Student Report (" . $dateformat . ") - SAFETY";
                     
            $dateandtime = date('Y-m-d H:i:s');
            $datetime = new DateTime($dateandtime);
            $datetime->setTimezone($la_time);
            $in_time = $datetime->format('Y-m-d H:i:s');
            $datewithtime= date("Y-m-d-H:i:s", strtotime($in_time));
            
            $subject = SCHOOL_SHORT_NAME."-TOUCHSCREEN-".$datewithtime;
            
            
           // $subject = "Touch Screen Scan Report -". SCHOOL_SHORT_NAME ;
            $from = "online@dunamisworld.com";
            $headers = 'MIME-Version: 1.0' . "\n";
            $headers .= 'From: ' . $from . "\r\n";
            $headers .= "CC: online@dunamisworld.com\r\n";
            $headers .= 'Content-Type: multipart/mixed ;
    
    boundary="----=_NextPart_001_0011_1234ABCD.4321FDAC"' . "\n";

            $message = '

This is a multi-part message in MIME format.

------=_NextPart_001_0011_1234ABCD.4321FDAC
Content-Type: text/plain;
        charset="us-ascii"
Content-Transfer-Encoding: 7bit

Dear Sir/Madam,

Please find attached the detailed report (in CSV format) for Students travelling in the school bus for following date in the selected school. 
You can open this file Microsoft Excel, Google Sheets or any other spreadsheet application. (If you face any issues, please contact us on the details provided below)

Date

' . $dateformat . '


School


' . SCHOOL_SHORT_NAME . '

Regards,

Lokate Student Team
WhatsApp Number: +971-50-7482052 (For a quicker response)
Email ID: lokatestudent@dunamisworld.com


------=_NextPart_001_0011_1234ABCD.4321FDAC
Content-Type: application/octet-stream;  name="';

            $message .= "$thisfile";
            $message .= '"
Content-Transfer-Encoding: base64
Content-Disposition: attachment; filename="';
            $message .= "$filename";
            $message .= '"

';
            $message .= "$encoded";
            $message .= '

------=_NextPart_001_0011_1234ABCD.4321FDAC--

';

// now send the email
            $mail = mail($email, $subject, $message, $headers, "-f$from");
            if ($mail) {
                $output = array('status' => 'Success', 'msg' => 'Email sent successfully');
                // unlink($csvname);
            } else {
                $output = array('status' => 'fail');
            }
        }
        echo json_encode($output);
    }
    
    
    
    
    
    
    
    
    
    
     
    public function email_report_count_csv() {

        ini_set('memory_limit', '200M');
        $json_data = json_decode($this->input->post('data'));
            $email = $json_data->email;
            $date1 = $json_data->datefrom;
            $date= $date1;
            $from = date("Y-m-d", strtotime($date));
            
            $date2 = $json_data->dateTo;
            $date= $date2;
            $to = date("Y-m-d", strtotime($date));
            
//            $date1=date_create($from);
//            $date2=date_create($to);
//            $diff=date_diff($date1,$date2);
//            $days= $diff->format("%a");
            $att = $this->Attendance_model->get_count_trips_in_attendance_download($from,$to);
          // echo $this->db->last_query(); exit();
          
        if($att=='')
        {
             $output = array('status' => 'NO Attendance'); 
        }
        else
        {
     
             $result = $att;
            $time = date('m-d-Y_hia');
            $filename = "report_" . $time . ".csv";
            $filename_xl = "report_" . $time . ".xls";
            $csvname = FCPATH . "uploads/csv/" . $filename;
            $handle = fopen($csvname, 'w');
             fputcsv($handle, array('#','Name', 'REG #', 'CLASS','SECTION','Bus','Total no of trips'));
                          $i = 1;
                          foreach ($result as $data) { 
                              
                              fputcsv($handle, array($i, $data["child_name"], $data["child_reg_no"], $data["child_class"],$data["child_section"],$data["bus_desc"],$data["count"]));
                              $i++;
                          }
                          
     //       fclose($handle); //close the file
            file_put_contents(FCPATH . "uploads/csv/data.csv", $handle);
//              exit;



            $thisfile = $csvname;
            $file_size = filesize($thisfile);
            $handle = fopen($thisfile, "r");
            $content = fread($handle, $file_size);
            fclose($handle);

            $encoded = chunk_split(base64_encode($content));

// create the email and send it off
            $dateformat = date('d F Y', strtotime($date1));
//            $subject = "Student Report (" . $dateformat . ") - SAFETY";
            
            $settings = $this->Setting_model->get_all_settings();
            $la_time = new DateTimeZone('UTC');
            foreach ($settings as $key => $value) {
            $la_time = new DateTimeZone($value['timezone']);
            }
            
             $dateandtime = date('Y-m-d H:i:s');
            $datetime = new DateTime($dateandtime);
            $datetime->setTimezone($la_time);
            $in_time = $datetime->format('Y-m-d H:i:s');
            $datewithtime= date("Y-m-d-H:i:s", strtotime($in_time));
            
            $subject = SCHOOL_SHORT_NAME."-TRIPCOUNT-".$datewithtime;
            
            
            //$subject = "Trip Count Report -". SCHOOL_SHORT_NAME ;
            $from = "online@dunamisworld.com";
            $headers = 'MIME-Version: 1.0' . "\n";
            $headers .= 'From: ' . $from . "\r\n";
            $headers .= "CC: online@dunamisworld.com\r\n";
            $headers .= 'Content-Type: multipart/mixed ;
    
    boundary="----=_NextPart_001_0011_1234ABCD.4321FDAC"' . "\n";

            $message = '

This is a multi-part message in MIME format.

------=_NextPart_001_0011_1234ABCD.4321FDAC
Content-Type: text/plain;
        charset="us-ascii"
Content-Transfer-Encoding: 7bit

Dear Sir/Madam,

Please find attached the detailed report (in CSV format) for Students travelling count in the school bus for following date in the selected school. 
You can open this file Microsoft Excel, Google Sheets or any other spreadsheet application. (If you face any issues, please contact us on the details provided below)

Date

' . $dateformat . '


School


' . SCHOOL_SHORT_NAME . '

Regards,

Lokate Student Team
WhatsApp Number: +971-50-7482052 (For a quicker response)
Email ID: lokatestudent@dunamisworld.com


------=_NextPart_001_0011_1234ABCD.4321FDAC
Content-Type: application/octet-stream;  name="';

            $message .= "$thisfile";
            $message .= '"
Content-Transfer-Encoding: base64
Content-Disposition: attachment; filename="';
            $message .= "$filename";
            $message .= '"

';
            $message .= "$encoded";
            $message .= '

------=_NextPart_001_0011_1234ABCD.4321FDAC--

';

// now send the email
            $mail = mail($email, $subject, $message, $headers, "-f$from");
            if ($mail) {
                $output = array('status' => 'Success', 'msg' => 'Email sent successfully');
                // unlink($csvname);
            } else {
                $output = array('status' => 'fail');
            }
        }
        echo json_encode($output);
    }
    
    
     public function add_child() {
    
        $data = $this->input->post('data');
        $data = stripslashes($data);
        $json_data = json_decode($data,true);
        $_POST = $json_data;
        
        $this->load->library('form_validation');
        $this->form_validation->set_rules('child_name', 'Child Name', 'required|max_length[500]');
        $this->form_validation->set_rules('child_gender', 'Child Gender', 'required');
        $this->form_validation->set_rules('child_class', 'Child Class', 'required|max_length[10]');
        $this->form_validation->set_rules('child_section', 'Child Section', 'required|max_length[15]');
        $this->form_validation->set_rules('child_teacher', 'Child Teacher', 'required|max_length[500]');
        $this->form_validation->set_rules('child_father_name', 'Child Father Name', 'required|max_length[500]');
        $this->form_validation->set_rules('child_father_tel', 'Child Father Tel', 'required');
        $this->form_validation->set_rules('child_father_email_id', 'Child Father Email Id', 'required|max_length[255]|valid_email');
        $this->form_validation->set_rules('child_nfc_id', 'Child Nfc Id', 'required');

        if ($this->form_validation->run()) {
            

                  
                       $params = array(
                        'child_name' => $this->input->post('child_name'),
                        'child_gender' => $this->input->post('child_gender'),
                        'child_class' => $this->input->post('child_class'),
                        'child_section' => $this->input->post('child_section'),
                        'child_teacher' => $this->input->post('child_teacher'),
                        'child_bus_no_pickup' => ($this->input->post('child_bus_no_pickup'))?$this->input->post('child_bus_no_pickup'):"0",
                        'child_bus_no_drop_off' => ($this->input->post('child_bus_no_drop_off'))?$this->input->post('child_bus_no_drop_off'):"0",
                        'child_drop_off_order' => $this->input->post('child_drop_off_order'),
                        'child_pickup_order' => $this->input->post('child_pickup_order'),
                        'child_father_name' => $this->input->post('child_father_name'),
                        'child_mother_name' => $this->input->post('child_mother_name'),
                        'child_father_tel' => $this->input->post('child_father_tel'),
                        'child_mother_tel' => $this->input->post('child_mother_tel'),
                        'child_home_tel' => $this->input->post('child_home_tel'),
                        'child_father_email_id' => $this->input->post('child_father_email_id'),
                        'child_mother_email_id' => $this->input->post('child_mother_email_id'),
                        'child_blood_group' => $this->input->post('child_blood_group'),
                        'child_address' => $this->input->post('child_address'),
                        'child_area' => $this->input->post('child_area'),
                        'child_city' => $this->input->post('child_city'),
                        'child_pickup_lati' => $this->input->post('child_pickup_lati'),
                        'child_pickup_longi' => $this->input->post('child_pickup_longi'),
                        'child_drop_off_lati' => $this->input->post('child_drop_off_lati'),
                        'child_drop_off_longi' => $this->input->post('child_drop_off_longi'),
                        'child_nfc_id' => $this->input->post('child_nfc_id'),
                        'child_sms' => $this->input->post('child_sms'),
                        'child_push_notification' => $this->input->post('child_push_notification'),
                        'child_trip_no_pickup' => ($this->input->post('child_trip_no_pickup'))?$this->input->post('child_trip_no_pickup'):"0",
                        'child_trip_no_drop_off' => ($this->input->post('child_trip_no_drop_off'))?$this->input->post('child_trip_no_drop_off'):"0",
                        'child_personal_transport_pickup' => $this->input->post('child_personal_transport_pickup'),
                        'child_personal_transport_drop_off' => $this->input->post('child_personal_transport_drop_off'),
                        'child_pickup_time' => $this->input->post('child_pickup_time'),
                        'child_dropoff_time' => $this->input->post('child_dropoff_time'),
                        'child_handicapped_type' => $this->input->post('child_handicapped_type'),
 			'child_reg_no' => $this->input->post('child_reg_no'),
            );

           $parent_app_user_id_exist = $this->Parent_app_user_model->check_parent_email($this->input->post('child_father_email_id'));
            if ($parent_app_user_id_exist) {
                $parent_app_user_id = $parent_app_user_id_exist;
            } else {
                $user_name = $this->input->post('child_father_email_id');
                $number_of_digits = 4;
                $pin_number = substr(number_format(time() * mt_rand(), 0, '', ''), 0, $number_of_digits);
                $params_parent_app = array(
                    'parent_app_user_name' => $user_name,
                    'parent_app_user_password' => '123',
                    'parent_app_user_status' => '1',
                    'pin_number' => $pin_number,
                );

                $parent_app_user_id = $this->Parent_app_user_model->add_parent_app_user($params_parent_app);
            }
            $child_last_id = $this->Child_model->add_child($params);


            $parent_child_mapping = array(
                'parent_id' => $parent_app_user_id,
                'child_id' => $child_last_id,
            );

            $parent_child_mapping_id = $this->Parent_child_mapping_model->add_parent_child_mapping($parent_child_mapping);

           $output = array('status' => 'success', 'msg' => 'Student details added successfully!');
                // unlink($csvname);
            }else {
                    $output = array('status' => 'fail', 'error' => '190', 'msg' => $this->form_validation->error_array());
                }
             echo json_encode($output);
      }
      
          
    public function upload_photo ($child_id) {

        
        $target_path =  realpath('.')."/". "uploads/std/";
        //echo realpath('.');  
        $output=array();
        if($child_id!=''){
        if (isset($_FILES['data']['name'])) {

        $updated_time = date('Y-m-d-H-i-s');
        $ext = explode(".", $_FILES['data']['name']);
        $real_name = 'std_' . date('Y-m-d-H-i-s') . '_' . uniqid() . '.' . $ext[1];
        $target_path = $target_path . $real_name;

        try {
         // Throws exception incase file is not being moved
         if (!move_uploaded_file($_FILES['data']['tmp_name'], $target_path)) {
             // make error flag true
            $output=array('status'=>'fail', 'message'=>'could not move file');
         }

         
        $params = array(
         'child_photo' => $real_name,
            );
         $this->Child_model->update_child($child_id, $params);
         
         // File successfully uploaded
         $output=array('status'=>'success', 'message'=>'File Uploaded');
        } catch (Exception $e) {
         // Exception occurred. Make error flag true
         $output=array('status'=>'fail', 'message'=>$e->getMessage());
        }
        } else {
        // File parameter is missing
        $output=array('status'=>'fail', 'message'=>'Not received any file');
        }
        }else {
            $output=array('status'=>'fail', 'message'=>'Child id is empty'); 
        }
      echo json_encode($output);
}









public function email_attendance_csv_lsedit() {

        ini_set('memory_limit', '200M');
        $json_data = json_decode($this->input->post('data'));
        $date1 = $json_data->date;
        $email = $json_data->email;

        $date = $date1;
        $date = date("Y-m-d", strtotime($date));

        $att_list = $this->Attendance_model->get_all_attendance_download_pickup_lsedit($date);
      //  echo $this->db->last_query(); exit(); 
        $att_dropoff = $this->Attendance_model->get_all_attendance_download_dropoff_lsedit($date);
        $settings = $this->Setting_model->get_all_settings();
        $la_time = new DateTimeZone('UTC');
        foreach ($settings as $key => $value) {
            $la_time = new DateTimeZone($value['timezone']);
        }

        // echo $this->db->last_query(); exit(); 
        if ($att_list == '' || $att_dropoff == '') {
            $output = array('status' => 'NO Attendance');
        } else {

            $bus_list = $this->Bu_model->get_all_bus();
            $trip_list = $this->Trip_model->get_full_trip();
            for ($j = 0; $j < count($att_list); $j++) {
                $att_list[$j] = $this->common_model->Bus_id_to_Bus_name_in_child($att_list[$j], $bus_list);

                $att_list[$j] = $this->common_model->trip_id_to_trip_name_in_child($att_list[$j], $trip_list);

                $flag_is_drop_off = true;
                for ($k = 0; $k < count($att_dropoff); $k++) {

                    if (($att_dropoff[$k]['at_child_id'] == $att_list[$j]['at_child_id']) && ($att_dropoff[$k]['at_trip_id'] == $att_list[$j]['at_trip_id'])) {
                        $att_list[$j]['at_child_drop_off_time'] = $att_dropoff[$k]['at_time_stamp_device'];
                        $att_list[$j]['card_type'] = $att_dropoff[$k]['at_loc_data_type'];
                        $flag_is_drop_off = false;
                    }
                }
                if ($flag_is_drop_off) {
                    $att_list[$j]['at_child_drop_off_time'] = '';
                    $att_list[$j]['card_type'] = '';
                }
            }

            //  print_r($att_list);               exit();
            $result = $att_list;
//            header("Content-type: application/csv");
//            header("Content-Disposition: attachment; filename=\"BusList".".csv\"");
//            header("Pragma: no-cache");
//            header("Expires: 0");
            $time = date('m-d-Y_hia');
            $filename = "report_" . $time . ".csv";
            $filename_xl = "report_" . $time . ".xls";
            $csvname = FCPATH . "uploads/csv/" . $filename;
            $handle = fopen($csvname, 'w');
            fputcsv($handle, array('#', 'NAME', 'NFC', 'STUDENT ID', 'CLASS','SECTION', 'DATE', 'PICKUP BUS', 'PICKUP TIME', 'DROPOFF BUS', 'DROPOFF TIME', 'SCAN TYPE', 'PRESENT/ABSENT', 'TRIP'));
            $i = 1;

            foreach ($result as $data) {
                $datetime = new DateTime($data["at_time_stamp"]);
                $datetime->setTimezone($la_time);
                if (substr($data["at_loc_data_type"], -1) == 's') {
                    $pickup_type = 'C';
                } else {
                    $pickup_type = 'T';
                }
                if (substr($data["card_type"], -1) == 's') {
                    $dropoff_type = 'C';
                } else {
                    $dropoff_type = 'T';
                }
                $type = $pickup_type . ',' . $dropoff_type;
                $pickup_time= date('Y-m-d H:i:s',strtotime('+4 hour',strtotime($data["at_time_stamp"])));
                $dropoff_time= date('Y-m-d H:i:s',strtotime('+4 hour',strtotime($data["at_child_drop_off_time"])));                                     
                fputcsv($handle, array($i, $data["child_name"], $data["child_nfc_id"], $data["child_reg_no"], $data["child_class"] , $data["child_section"], date("j-M", strtotime($data["at_time_stamp"])), $data["child_bus_no_pickup"], date('G:i',  strtotime($pickup_time)), $data["child_bus_no_drop_off"],date('G:i',  strtotime($dropoff_time)), $type, ucfirst($data["at_child_status"]), $data["at_loc_longi"]));
                $i++;
            }
     //       fclose($handle); //close the file
            file_put_contents(FCPATH . "uploads/csv/data.csv", $handle);
//              exit;



            $thisfile = $csvname;
            $file_size = filesize($thisfile);
            $handle = fopen($thisfile, "r");
            $content = fread($handle, $file_size);
            fclose($handle);

            $encoded = chunk_split(base64_encode($content));

// create the email and send it off
            $dateformat = date('d F Y', strtotime($date1));
//            $subject = "Student Report (" . $dateformat . ") - SAFETY";
            
            
            $dateandtime = date('Y-m-d H:i:s');
            $datetime = new DateTime($dateandtime);
            $datetime->setTimezone($la_time);
            $in_time = $datetime->format('Y-m-d H:i:s');
            $datewithtime= date("Y-m-d-H:i:s", strtotime($in_time));
            
            $subject = SCHOOL_SHORT_NAME."-ATTENDANCE-".$datewithtime;
            
            
            
           // $subject = "Attendance Report -". SCHOOL_SHORT_NAME ;
            $from = "online@dunamisworld.com";
            $headers = 'MIME-Version: 1.0' . "\n";
            $headers .= 'From: ' . $from . "\r\n";
            $headers .= "CC: online@dunamisworld.com\r\n";
            $headers .= 'Content-Type: multipart/mixed ;
    
    boundary="----=_NextPart_001_0011_1234ABCD.4321FDAC"' . "\n";

            $message = '

This is a multi-part message in MIME format.

------=_NextPart_001_0011_1234ABCD.4321FDAC
Content-Type: text/plain;
        charset="us-ascii"
Content-Transfer-Encoding: 7bit

Dear Sir/Madam,

Please find attached the detailed report (in CSV format) for Students travelling in the school bus for following date in the selected school. 
You can open this file Microsoft Excel, Google Sheets or any other spreadsheet application. (If you face any issues, please contact us on the details provided below)

Date

' . $dateformat . '


School


' . SCHOOL_SHORT_NAME . '

Regards,

Lokate Student Team
WhatsApp Number: +971-50-7482052 (For a quicker response)
Email ID: lokatestudent@dunamisworld.com


------=_NextPart_001_0011_1234ABCD.4321FDAC
Content-Type: application/octet-stream;  name="';

            $message .= "$thisfile";
            $message .= '"
Content-Transfer-Encoding: base64
Content-Disposition: attachment; filename="';
            $message .= "$filename";
            $message .= '"

';
            $message .= "$encoded";
            $message .= '

------=_NextPart_001_0011_1234ABCD.4321FDAC--

';

// now send the email
            $mail = mail($email, $subject, $message, $headers, "-f$from");
            if ($mail) {
                $output = array('status' => 'Success', 'msg' => 'Email sent successfully');
                // unlink($csvname);
            } else {
                $output = array('status' => 'Failure');
            }
        }
        echo json_encode($output);
    }



    
 }
?>
