<?php

class Json_lsattendance extends CI_Controller {

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
        $this->load->model('common_model');
        $this->load->model('Finish_trip_detail_model');
        $this->load->model('Logo_image_model');
        $this->load->model('Lsedit_app_user_model');
        $this->load->model('Setting_model');
        $this->load->model('Device_app_user_model');
        $this->load->model('Attendance_device_model');
        $this->load->model('School_attendance_model');
        $this->load->model('Notification_model');
        $this->load->model('Push_msg_map_model');


        header('Content-Type: application/json');
    }

    // authentication from app
    public function auth_attendance_device() {
        //{ 	"user_name": "d", 	"passwod": "1"}
        $data = $this->input->post('data');
        $data = stripslashes($data);
        $json_data = json_decode($data);
        if ($json_data->user_name != '' && $json_data->passwod != '') {
            $result = $this->Device_app_user_model->get_device_app_user_by_username_pass($json_data->user_name, $json_data->passwod);

            if (!empty($result)) {
                $device = $this->Attendance_device_model->get_attendance_device($result['device_app_user_device_id']);
                $device_detail['device_name'] = $device['device_name'];
                $device_detail['device_desc'] = $device['device_desc'];
                $device_detail['device_keeper'] = $device['device_keeper'];
                $device_detail['device_keeper_phone'] = $device['device_keeper_phone'];
                $device_detail['device_id'] = $result['device_app_user_device_id'];
                $device_detail['device_type'] = $device['device_type'];
                $device_detail['device_user_type'] = $result['device_user_type'];
                $output = array('status' => 'success');
                $output['device_detail'] = $device_detail;
            } else {
                $output = array('status' => 'fail', 'error' => '102', 'msg' => 'Invalid Username or Password !');
            }
        } else {
            $output = array('status' => 'fail', 'error' => '101', 'msg' => 'User name or Password empty !');
        }
        $settings = $this->Setting_model->get_all_settings();
        foreach ($settings as $key => $value) {
            $output ['card_scan_type'] = $value['card_scan_type'];
            $output ['child_list_updated_timestamp'] = $value['child_list_updated_timestamp'];
        }
        echo json_encode($output);
    }

// Mark attendance batch

    public function mark_attendance_batch() {

        //{ "at_child_id":"1", "at_trip_id":"1", "at_time_stamp_device":"", "at_loc_lati":"1.23333", "at_loc_longi":"1.888", "at_loc_data_type":"gprs", "at_device_id":"1", "at_trip_type":"pickup","at_pickup_or_drop_off":"pickup","at_child_status":"present",,"child_nfc":"","child_change_bus":"No"}

        if ($this->input->post('data')) {
            $data = $this->input->post('data');
            $data = stripslashes($data);
            $json_data = json_decode($data);
           // $myfile = fopen("text_log.txt", "a+") ;
           // $txt = date('l jS \of F Y h:i:s A').print_r($data,true);
          //  fwrite($myfile, $txt);
          //  print_r($json_data);
            $settings_main = $this->Setting_model->get_current_settings();
            $set_ot_push=$settings_main['set_OT_push'];
            $localization_lang=$this->common_model->get_localization($settings_main['set_language']);
            if($settings_main['set_language1']){
            $localization_lang1=$this->common_model->get_localization($settings_main['set_language1']); 
            }else {
                $localization_lang1="";
            }
            foreach ($json_data as $key => $value) {
                if ($value->child_forgot_card == 'Yes') {
                    $value->at_child_id = $this->Child_model->get_child_id_using_school_register_number($value->child_reg_no);
                }               
                $check_list=$this->School_attendance_model->is_dupplicate_entry($value->at_child_id,$value->at_in_or_out,$value->at_time_stamp_device);
                if($check_list==0 && $value->at_child_id!=''){
                
                $params = array(
                    'at_child_id' => $value->at_child_id,
                    'at_time_stamp_device' => $value->at_time_stamp_device,
                    'at_loc_lati' => $value->at_loc_lati,
                    'at_loc_longi' => $value->at_loc_longi,
                    'at_loc_data_type' => $value->at_loc_data_type,
                    'at_device_id' => $value->at_device_id,
                    'at_in_or_out' => $value->at_in_or_out,
                    'at_child_status' => $value->at_child_status,
                );
                $attendance_id = $this->School_attendance_model->add_attendance($params);  
                
                /* push msg */
                
                
                    $child = $this->Child_model->get_child($value->at_child_id);
                    // for OT only 
                  //  if($child['child_push_notification']=='Yes' && ($child['child_bus_no_pickup']==0 || $child['child_bus_no_drop_off']==0) && $set_ot_push=='Yes'){ 
                       // for everyone
                         if($child['child_push_notification']=='Yes' && $set_ot_push=='Yes'){  
                        
                    $formated_data = $this->common_model->get_push_message_and_title_multi_lang_for_OT_students($value->at_in_or_out,$child['child_name'],$localization_lang,$localization_lang1);

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
                        'n_type' => $value->at_in_or_out,
                        'n_child_id' => $value->at_child_id,
                        'n_status' => $value->at_child_status,
                        'n_trip_type' => '',
                        'n_time_stamp' => $value->at_time_stamp_device,
                        'n_longi' => $value->at_loc_longi,
                        'n_lati' => $value->at_loc_lati
                    );

                    $notification_id = $this->Notification_model->add_notification($params);
                    
                    $device_date_format = date_create_from_format('Y-m-d H:i:s', $value->at_time_stamp_device);
                    $device_date= date_format($device_date_format, 'Y-m-d');
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
                
                
                
                
                
                
                
                
               }
                
            }//end of forach loop

            $output = array('status' => 'success');
            $settings = $this->Setting_model->get_all_settings();
            foreach ($settings as $key => $value) {
                $output ['card_scan_type'] = $value['card_scan_type'];
                $output ['child_list_updated_timestamp'] = $value['child_list_updated_timestamp'];
            }
        } else {
            $output = array('status' => 'fail', 'error' => '106', 'msg' => 'Data is null');
        }
        echo json_encode($output);
    }

    public function student_list() {
        $output = array('status' => 'success');
      //  $output['student_list'] = $this->Child_model->get_all_child();
        $output['student_list'] = $this->School_attendance_model->get_all_child();
      //  echo $this->db->last_query();        exit();
        echo json_encode($output);
    }
    public function class_list() {
        $output = array('status' => 'success');
        $output['class_list'] = $this->School_attendance_model->get_all_classes();
        echo json_encode($output);
    }
    public function section_list() {
        $json_data = json_decode($this->input->post('data'));
        $class =  $json_data->class;     
        $output = array('status' => 'success');
        $output['section_list'] = $this->School_attendance_model->get_all_sections($class);
        echo json_encode($output);
    }
    public function school_attendance_log() {
        $json_data = json_decode($this->input->post('data'));
        $date =  $json_data->date;      
        $class =  $json_data->class;      
        $section =  $json_data->section;      
        $output = array('status' => 'success');
        $output['logs_entry'] = $this->School_attendance_model->get_all_school_attendance_download($date,$class,$section,'in');
        $output['logs_exit'] = $this->School_attendance_model->get_all_school_attendance_download($date,$class,$section,'out');
        $output['total_students'] = $this->School_attendance_model->count_students($class,$section);
        //echo $this->db->last_query();
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
          $child_ids = array_column($child_list, 'child_id');
          //print_r($first_names);exit();
          $date=date("Y-m-d");
          $entry_log= $this->School_attendance_model->entry_log_list($child_ids,$date);
           $exit_log= $this->School_attendance_model->exit_log_list($child_ids,$date);
//          echo $this->db->last_query();
//          exit();
             $output['child_details']=$child_list;    
              $output['entry_log']=$entry_log;  
              $output['exit_log']=$exit_log;  
       } else {
           $output = array('status' => 'fail','error'=>'112','msg'=>$search_key1 . ' not found in the school database. Pls try again.');  
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

            $output = array('status' => 'success');
            $output['child_details'] = $child;
            $output['notification_list'] = $notfications;
        } else {
            $output = array('status' => 'fail', 'error' => '112', 'msg' => 'child id is null !');
        }

        echo json_encode($output);
    }
    
    
      public function school_attendance_one_month_log() {
        $json_data = json_decode($this->input->post('data'));
        $year =  $json_data->year;      
        $month =  $json_data->month;     
        $child_id =  $json_data->child_id;  
        $output = array('status' => 'success');
        $output['logs_entry'] = $this->School_attendance_model->get_one_month_school_attendance_in($year,$month,$child_id);
        $output['logs_exit'] = $this->School_attendance_model->get_one_month_school_attendance_out($year,$month,$child_id);
        //echo $this->db->last_query();
        echo json_encode($output);
    }
     public function school_attendance_date_log() {
        $json_data = json_decode($this->input->post('data'));
        $date =  $json_data->date;    
        $date=date("Y-m-d", strtotime($date) );
        $child_id =  $json_data->child_id;  
        $output = array('status' => 'success');
        $output['logs_entry'] = $this->School_attendance_model->get_date_school_attendance_in($date,$child_id);
        $output['logs_exit'] = $this->School_attendance_model->get_date_school_attendance_out($date,$child_id);
        //echo $this->db->last_query();
        echo json_encode($output);
    }
    
    
        public function school_absent_list() {
        $json_data = json_decode($this->input->post('data'));
        $date = date("Y-m-d", strtotime($json_data->date));
        $class=$json_data->class;
        $section =$json_data->section;
        $output = array('status' => 'success');
        $att_absent = $this->School_attendance_model->get_all_school_absent_list($date,$class,$section);
        $output['absent_list']=$att_absent;
        $child_ids=array();
        foreach ($att_absent as $key => $value) {
           $child_ids[]= $value['child_id'];
        }
        $att_absent_buss=array();
        if(!empty($child_ids))
        $att_absent_buss = $this->School_attendance_model->get_morning_attendance_in_class_buss($date,$child_ids);
        $output['present_list_bus']=$att_absent_buss;
        echo json_encode($output);       
        }
    
     public function school_attendance_summary() {
          $json_data = json_decode($this->input->post('data'));
          $date = date("Y-m-d", strtotime($json_data->date));
          $output = array('status' => 'success');
          $output['total_students'] = $this->School_attendance_model->count_students();
          $output['today_attendacne'] = $this->School_attendance_model->count_school_attendance($date);
          $output['school_year'] = "2017 - 2018";
        //echo $this->db->last_query();
        echo json_encode($output);
     }

    public function attendance_pdf() {

        ini_set('memory_limit', '20M');
        $json_data = json_decode($this->input->post('data'));
        $date1 = $json_data->date;

        $date = $date1;
        $date = date("Y-m-d", strtotime($date));

        if (file_exists("/home/safety/public_html/uploads/pdf/" . $date . ".pdf")) {
            $output = array('status' => 'success');
            $output ['download_path'] = base_url() . "uploads/pdf/" . $date . ".pdf";
        } else {
            $data['attendance'] = $this->School_attendance_model->get_all_school_attendance_download($date);
            //echo $this->db->last_query(); exit();
            if ($data['attendance'] == '') {
                $output = array('status' => 'NO Attendance');
            } else {
                $html = $this->load->view('school_attendance/email_school_attendence', $data, true);
                $this->load->helper('dompdf');
                pdf_save_in_server_for_json($html, $date);
                $output = array('status' => 'success');
                $output ['download_path'] = base_url() . "uploads/pdf/" . $date . ".pdf";
            }

            //  pdf_create($html);    
        }
        echo json_encode($output);
    }

    public function email_school_attendance_csv() {

        ini_set('memory_limit', '40M');
        $json_data = json_decode($this->input->post('data'));
        $date1 = $json_data->date;
        $email = $json_data->email;
        $date = $date1;
        $date = date("Y-m-d", strtotime($date));
        $settings = $this->Setting_model->get_all_settings();
        $la_time = new DateTimeZone('UTC');
        foreach ($settings as $key => $value) {
            $la_time = new DateTimeZone($value['timezone']);
        }
//new change 09-05-2018
         $datecheck=date('Y-m-d', strtotime('-2 days'));
        $datetime=$datecheck.'60;60:60';
        if($date<$datetime)
        {
          $table_name='Copy_school_attendance';
        }
        else 
        {
         $table_name='School_attendance';       
        }
        
        // $att_list = $this->School_attendance_model->get_all_school_attendance_download($date);

        $att_in = $this->School_attendance_model->get_all_school_attendance_download_in($date,$table_name);
        $att_out = $this->School_attendance_model->get_all_school_attendance_download_out($date,$table_name);
        //new change 09-05-2018
        
        $bus_list= $this->Bu_model->get_all_bus();
        //echo $this->db->last_query(); exit();

        if ($att_in == '' || $att_out == '') {
            $output = array('status' => 'NO Attendance');
        } else {

            for ($j = 0; $j < count($att_in); $j++) {
                $flag = true;
                for ($k = 0; $k < count($att_out); $k++) {

                    if (($att_out[$k]['at_child_id'] == $att_in[$j]['at_child_id'])) {
                        $att_in[$j]['at_child_out_time'] = $att_out[$k]['at_time_stamp'];
                        $att_in[$j]['out_device_name'] = $att_out[$k]['device_name'];
                        $flag = false;
                    }
                }
                if ($flag) {
                    $att_in[$j]['at_child_out_time'] = '';
                    $att_in[$j]['out_device_name'] =  '';
                }
                
            }
           $att_status_data = $this->School_attendance_model->get_bus_attendance_status($date);

            for ($m = 0; $m < count($att_in); $m++) {
              $flag=false;
                for ($y=0;$y<count($att_status_data);$y++){

                  if($att_status_data[$y]['at_child_status']=='present' && $att_status_data[$y]['at_child_id']==$att_in[$m]['at_child_id']){
                     // $att_in[$m]['bus_attendance_status'] ='present';
                      for ($p=0;$p<count($bus_list);$p++){
                          if($att_status_data[$y]['at_bus_no']==$bus_list[$p]['bus_id']) {
                               $att_in[$m]['bus_attendance_status'] ='Bus#'.$bus_list[$p]['bus_desc'];
                          }
                       }
                      
                      $flag=true;
                  }
                  else if($att_status_data[$y]['at_child_status']=='absent'&& $att_status_data[$y]['at_child_id']==$att_in[$m]['at_child_id']) {
                      $att_in[$m]['bus_attendance_status'] ='Not at stop';
                       $flag=true;
                  }else {
                      
                  }
                }
                if($flag==false){                    
                     $att_in[$m]['bus_attendance_status'] ='';
                }
            }

            $time = date('m-d-Y_hia');
            $filename = "report_" . $time . ".csv";
            $filename_xl = "report_" . $time . ".xls";
            $csvname = FCPATH . "uploads/csv/" . $filename;
            $handle = fopen($csvname, 'w');
            fputcsv($handle, array('#', 'NAME', 'REG #', 'CLASS','SECTION', 'IN-TIME', 'OUT-TIME', 'IN-DEVICE NAME', 'OUT-DEVICE NAME', 'PRIMARY TELEPHONE', 'PRIMARY EMAIL ID', 'BUS ATTENDANCE'));
            $i = 1;
            foreach ($att_in as $data) {
                if ($data["at_child_out_time"] != '') {
                    //  $out_time = date('Y-m-d H:i:s', strtotime('+4 hour', strtotime($data["at_child_out_time"])));
                    $datetime = new DateTime($data["at_child_out_time"]);
                    $datetime->setTimezone($la_time);
                    $out_time = $datetime->format('Y-m-d H:i:s');
                    $out_time = date("H:i:s", strtotime($out_time));
                } else {
                    $out_time = '';
                }
                // $in_time = date('Y-m-d H:i:s', strtotime('+4 hour', strtotime($data["at_time_stamp"])));
                $datetime = new DateTime($data["at_time_stamp"]);
                $datetime->setTimezone($la_time);
                $in_time = $datetime->format('Y-m-d H:i:s');
                $in_time = date("H:i:s", strtotime($in_time));
                fputcsv($handle, array($i, $data["child_name"], $data["child_reg_no"], $data["child_class"] , $data["child_section"], date("H:i:s", strtotime($in_time)), $out_time, $data["device_name"], $data["out_device_name"], $data["child_father_tel"], $data["child_father_email_id"], $data["bus_attendance_status"]));
                $i++;
            }
            //fclose($handle); //close the file
            file_put_contents(FCPATH . "uploads/csv/data.csv", $handle);
            $thisfile = $csvname;
            $file_size = filesize($thisfile);
            $handle = fopen($thisfile, "r");
            $content = fread($handle, $file_size);
            fclose($handle);
            $encoded = chunk_split(base64_encode($content));
            $dateformat = date('d F Y', strtotime($date1));

// create the email and send it off
            $dateandtime = date('Y-m-d H:i:s');
            $datetime = new DateTime($dateandtime);
            $datetime->setTimezone($la_time);
            $in_time = $datetime->format('Y-m-d H:i:s');
            $datewithtime= date("Y-m-d-H:i:s", strtotime($in_time));
            
            $subject = SCHOOL_SHORT_NAME."-PRESENT-".$datewithtime;
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

Please find attached to this e-mail the detailed report (in CSV format) for following date in the selected school.
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
                $output = array('status' => 'Success', 'msg' => 'Email successfully sent !');
                // unlink($csvname);
            } else {
                $output = array('status' => 'fail');
            }
        }
        echo json_encode($output);
    }

    public function email_school_absent_csv() {

        ini_set('memory_limit', '40M');
        $json_data = json_decode($this->input->post('data'));
        $date1 = $json_data->date;
        $email = $json_data->email;
        $date = $date1;
        $date = date("Y-m-d", strtotime($date));

         $settings = $this->Setting_model->get_all_settings();
        $la_time = new DateTimeZone('UTC');
        foreach ($settings as $key => $value) {
            $la_time = new DateTimeZone($value['timezone']);
        }
        
        
        //new change 09-05-2018
         $datecheck=date('Y-m-d', strtotime('-2 days'));
        $datetime=$datecheck.'60;60:60';
        if($date<$datetime)
        {
          $table_name='Copy_school_attendance';
        }
        else 
        {
         $table_name='School_attendance';       
        }
        
        $att_absent = $this->School_attendance_model->get_all_school_absent_list_report($date,$table_name);
          //new change 09-05-2018
        
        $att_status_data = $this->School_attendance_model->get_bus_attendance_status($date);    
        $bus_list= $this->Bu_model->get_all_bus();
             for ($m = 0; $m < count($att_absent); $m++) {
              $flag=false;
                for ($y=0;$y<count($att_status_data);$y++){

                  if($att_status_data[$y]['at_child_status']=='present' && $att_status_data[$y]['at_child_id']==$att_absent[$m]['child_id']){
                      //$att_absent[$m]['bus_attendance_status'] ='present';
                      for ($p=0;$p<count($bus_list);$p++){
                          if($att_status_data[$y]['at_bus_no']==$bus_list[$p]['bus_id']) {
                               $att_in[$m]['bus_attendance_status'] ='Bus#'.$bus_list[$p]['bus_desc'];
                          }
                       }
                      $flag=true;
                  }
                  else if($att_status_data[$y]['at_child_status']=='absent'&& $att_status_data[$y]['at_child_id']==$att_absent[$m]['child_id']) {
                      $att_absent[$m]['bus_attendance_status'] ='Not at stop';
                       $flag=true;
                  }else {
                      
                  }
                }
                if($flag==false){                    
                     $att_absent[$m]['bus_attendance_status'] ='';
                }
            }
                 
        $time = date('m-d-Y_hia');
        $filename = "report_" . $time . ".csv";
        $filename_xl = "report_" . $time . ".xls";
        $csvname = FCPATH . "uploads/csv/" . $filename;
        $handle = fopen($csvname, 'w');
        fputcsv($handle, array('#', 'NAME', 'REG #', 'CLASS','SECTION', 'FATHER NUMBER','MOTHER NUMBER', 'PRIMARY EMAIL ID', 'BUS ATTENDANCE'));
        $i = 1;
        foreach ($att_absent as $data) {

            fputcsv($handle, array($i, $data["child_name"], $data["child_reg_no"], $data["child_class"] , $data["child_section"], $data["child_father_tel"],$data["child_mother_tel"],$data["child_father_email_id"],$data["bus_attendance_status"]));
            $i++;
        }
        //fclose($handle); //close the file
        file_put_contents(FCPATH . "uploads/csv/data.csv", $handle);
        $thisfile = $csvname;
        $file_size = filesize($thisfile);
        $handle = fopen($thisfile, "r");
        $content = fread($handle, $file_size);
        fclose($handle);
        $encoded = chunk_split(base64_encode($content));
        $dateformat = date('d F Y', strtotime($date1));
// create the email and send it off
//        $subject = "File you requested from Dunamis";
        
        
            $dateandtime = date('Y-m-d H:i:s');
            $datetime = new DateTime($dateandtime);
            $datetime->setTimezone($la_time);
            $in_time = $datetime->format('Y-m-d H:i:s');
            $datewithtime= date("Y-m-d-H:i:s", strtotime($in_time));
            
            $subject = SCHOOL_SHORT_NAME."-ABSENT-".$datewithtime;
        
        //$subject = "Student Report Absent(".$dateformat.") - ".SCHOOL_SHORT_NAME;
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

Please find attached to this e-mail the detailed report (in CSV format) for following date in the selected school.
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
                $output = array('status' => 'Success', 'msg' => 'Email successfully sent !');
                // unlink($csvname);
            } else {
                $output = array('status' => 'fail');
            }       
        echo json_encode($output);
    }
  
     
    public function email_touch_screen_scan_report_school_attendance_csv() {

        ini_set('memory_limit', '200M');
        $json_data = json_decode($this->input->post('data'));
        $date1 = $json_data->date;
        $email = $json_data->email;

        $date= $date1;
        $date = date("Y-m-d", strtotime($date));
       // $date_7day=date('Y-m-d', strtotime('-7 days'));
        
        $settings = $this->Setting_model->get_all_settings();
        $la_time = new DateTimeZone('UTC');
        foreach ($settings as $key => $value) {
            $la_time = new DateTimeZone($value['timezone']);
        }

        
         //new change 09-05-2018
         $datecheck=date('Y-m-d', strtotime('-2 days'));
        $datetime=$datecheck.'60;60:60';
        if($date<$datetime)
        {
          $table_name='Copy_school_attendance';
        }
        else 
        {
         $table_name='School_attendance';       
        }
        
        
       $att_list = $this->School_attendance_model->get_all_school_attendance_download_manual($date,$table_name);
       //new change 09-05-2018
      //   echo $this->db->last_query(); exit();
     if($att_list=='')
        {
             $output = array('status' => 'NO Attendance'); 
        }
        else
        {

            $result = $att_list;
      //     print_r($result);            exit();
//            header("Content-type: application/csv");
//            header("Content-Disposition: attachment; filename=\"BusList".".csv\"");
//            header("Pragma: no-cache");
//            header("Expires: 0");
            $time = date('m-d-Y_hia');
            $filename = "report_" . $time . ".csv";
            $filename_xl = "report_" . $time . ".xls";
            $csvname = FCPATH . "uploads/csv/" . $filename;
            $handle = fopen($csvname, 'w');
            fputcsv($handle, array('#', 'CLASS','SECTION', 'NAME', 'ID', 'TIME', 'DEVICE ID'));
            $i = 1;

            foreach ($result as $data) {
               //  $time= date('Y-m-d H:i:s',strtotime('+4 hour',strtotime($data["at_time_stamp"])));
                 
                    $datetime = new DateTime($data["at_time_stamp"]);
                $datetime->setTimezone($la_time);
                $in_time = $datetime->format('Y-m-d H:i:s');
                $time = date("H:i:s", strtotime($in_time));
                fputcsv($handle, array($i, $data["child_class"],$data["child_section"], $data["child_name"], $data["child_reg_no"], date("G.s", strtotime($time)) , $data["device_name"]));
                $i++;
            }
            file_put_contents(FCPATH . "uploads/csv/data.csv", $handle);
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
            
            $subject = SCHOOL_SHORT_NAME."-FORGOTCARD-".$datewithtime;
            
            
             //$subject = "Student Report ForgotCard(" . $dateformat . ") - ".SCHOOL_SHORT_NAME;
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

Please find attached to this e-mail the detailed report (in CSV format) for following date in the selected school.
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
                $output = array('status' => 'Success', 'msg' => 'Email sent successfull');
                // unlink($csvname);
            } else {
                $output = array('status' => 'Failure');
            }
        }
        echo json_encode($output);
    }
    
    
}

?>