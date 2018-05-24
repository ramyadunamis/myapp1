<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of common_model
 *
 * @author dunamis
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class common_model extends CI_Model {

    //put your code here

    public function __construct() {
        parent::__construct();
    }

    function do_upload($config, $field_name="") {

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload($field_name)) {
            $status = array('status' => 'false', 'error' => $this->upload->display_errors());
        } else {
           $config='';
           $field_name='';
            $status = array('status' => 'true', 'error' => '');
        }

        return $status;
    }

    function image_resize($config) {

        $this->load->library('image_lib', $config);

        if (!$this->image_lib->resize()) {
            $status = array('status' => 'false', 'error' => $this->image_lib->display_errors());
            print_r($status);
            exit;
        } else {

            $status = array('status' => 'true', 'error' => '');
        }

        return $status;
    }

    function send_push_notification($fields) {
        // API access key from Google API's Console currently generated from ios@dunamisworld.com browser key

        defined('GOOGLE_API_KEY') or define('GOOGLE_API_KEY', 'AIzaSyBKdASz1pYU-fImbJgvIUOrkj4V_T0kuo8');
         
        $url = 'https://fcm.googleapis.com/fcm/send';


        // print_r($fields); 
        $headers = array(
            'Authorization: key=' . GOOGLE_API_KEY,
            'Content-Type: application/json'
        );

        //echo json_encode($fields); exit();
        // Open connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Execute post
        $result = curl_exec($ch);
        //echo $result; 

        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        // Close connection
        curl_close($ch);
    }
    function send_push_notification_eth($fields) {
        // API access key from Google API's Console currently generated from ios@dunamisworld.com browser key

        defined('GOOGLE_API_KEY_ETH') or define('GOOGLE_API_KEY_ETH', 'AAAAwwE9Eh4:APA91bHoByakHAmH-wX-nD8Kk9sOrTUNvFk6t6xjG67a6fX5k6VTSzrxQrFfUJk1PHU0uaqCvFVukiXB3F9pt_D63jgjU9XorNqs-IOfNZ8ruW7EumRl6onqxdBGAjpbL7zR0lEaWBRG');

        $url = 'https://fcm.googleapis.com/fcm/send';


        // print_r($fields); 
        $headers = array(
            'Authorization: key=' . GOOGLE_API_KEY_ETH,
            'Content-Type: application/json'
        );

        //echo json_encode($fields); exit();
        // Open connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Execute post
        $result = curl_exec($ch);
       // echo $result; 

        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        // Close connection
        curl_close($ch);
    }

 
    public function get_push_message_and_title($at_trip_type, $at_pickup_or_drop_off, $at_child_status, $child_name) {

        $first_name = explode(' ', $child_name)[0];

        $restult = array('message' => '', 'title' => '');



        if ($at_child_status == 'present') {



            if ($at_trip_type == 'pickup') {



                if ($at_pickup_or_drop_off == 'pickup') {



                    $restult['title'] =  $first_name." ".'Picked up';

                    $restult['message'] = $child_name . ' has entered the bus from HOME bus stop';
                } else if ($at_pickup_or_drop_off == 'drop off') {



                    $restult['title'] =  $first_name." ".'Dropped off';

                    $restult['message'] = $child_name .' has been dropped at SCHOOL';
                } else {
                    
                }
            } else if ($at_trip_type == 'drop off') {





                if ($at_pickup_or_drop_off == 'pickup') {



                    $restult['title'] = $first_name." ".'Picked up';

                    $restult['message'] = $child_name . ' has entered the bus from SCHOOL';
                } else if ($at_pickup_or_drop_off == 'drop off') {



                    $restult['title'] = $first_name." ".'Dropped off';

                    $restult['message'] = $child_name . ' has been dropped at HOME bus stop';
                } else {
                    
                }
            } else {
                
            }
        } else if ($at_child_status == 'absent') {

            if ($at_trip_type == 'pickup') {



                $restult['title'] = $first_name." ".'Not at Stop';

                $restult['message'] = $child_name . ' was not at stop while picking from home bus stop';
            } else if ($at_trip_type == 'drop off') {



                $restult['title'] = $first_name." ".'Not at Stop';

                $restult['message'] = $child_name . ' was not at stop while picking from SCHOOL';
            } else {
                
            }
        } else {
            
        }



        return $restult;
    }
    public function get_push_message_and_title_multi_lang($at_trip_type, $at_pickup_or_drop_off, $at_child_status, $child_name,$localization_lang,$localization_lang1) {

        $first_name = explode(' ', $child_name)[0];

        $restult = array('message' => '', 'title' => '');



        if ($at_child_status == 'present') {



            if ($at_trip_type == 'pickup') {



                if ($at_pickup_or_drop_off == 'pickup') {

                    if(!empty($localization_lang)){
                    $restult['title'] =   str_replace("{x}",$first_name,$localization_lang['title_pickup_home']);
                    $restult['message'] =  str_replace("{x}",$first_name,$localization_lang['msg_pickup_home']);
                    }else {
                    $restult['title'] =    $first_name." ".'Picked up';
                    $restult['message'] =  $child_name . ' has entered the bus from HOME bus stop';
                    }
                    if(!empty($localization_lang1)){
                    $restult['title_lang1'] =   str_replace("{x}",$first_name,$localization_lang1['title_pickup_home']);
                    $restult['message_lang1'] =  str_replace("{x}",$first_name,$localization_lang1['msg_pickup_home']);
                    
                    }else {
                    $restult['title_lang1'] =   "";
                    $restult['message_lang1'] =   ""; 
                    }
                } else if ($at_pickup_or_drop_off == 'drop off') {

                    if(!empty($localization_lang)){
                    $restult['title'] =   str_replace("{x}",$first_name,$localization_lang['title_dropoff_school']);
                    $restult['message'] =  str_replace("{x}",$first_name,$localization_lang['msg_dropoff_school']);
                    }else {
                    $restult['title'] =  $first_name." ".'Dropped off';
                    $restult['message'] = $child_name .' has been dropped at SCHOOL';
                    }
                    if(!empty($localization_lang1)){
                    $restult['title_lang1'] =   str_replace("{x}",$first_name,$localization_lang1['title_dropoff_school']);
                    $restult['message_lang1'] =  str_replace("{x}",$first_name,$localization_lang1['msg_dropoff_school']);
                    
                    }else {
                      $restult['title_lang1'] =   "";
                    $restult['message_lang1'] =   ""; 
                    }

                } else {
                    
                }
            } else if ($at_trip_type == 'drop off') {

                if ($at_pickup_or_drop_off == 'pickup') {

                    if(!empty($localization_lang)){
                    $restult['title'] =   str_replace("{x}",$first_name,$localization_lang['title_pickup_school']);
                    $restult['message'] =  str_replace("{x}",$first_name,$localization_lang['msg_pickup_school']);
                    }else {
                    $restult['title'] = $first_name." ".'Picked up';
                    $restult['message'] = $child_name . ' has entered the bus from SCHOOL';
                    }
                    if(!empty($localization_lang1)){
                    $restult['title_lang1'] =   str_replace("{x}",$first_name,$localization_lang1['title_pickup_school']);
                    $restult['message_lang1'] =  str_replace("{x}",$first_name,$localization_lang1['msg_pickup_school']);
                    
                    }else {
                      $restult['title_lang1'] =   "";
                    $restult['message_lang1'] =   ""; 
                    }
                    
                } else if ($at_pickup_or_drop_off == 'drop off') {




                    
                     if(!empty($localization_lang)){
                    $restult['title'] =   str_replace("{x}",$first_name,$localization_lang['title_dropoff_home']);
                    $restult['message'] =  str_replace("{x}",$first_name,$localization_lang['msg_dropoff_home']);
                    }else {
                    $restult['title'] = $first_name." ".'Dropped off';
                    $restult['message'] = $child_name . ' has been dropped at HOME bus stop';
                    }
                    if(!empty($localization_lang1)){
                    $restult['title_lang1'] =   str_replace("{x}",$first_name,$localization_lang1['title_dropoff_home']);
                    $restult['message_lang1'] =  str_replace("{x}",$first_name,$localization_lang1['msg_dropoff_home']);
                    
                    }else {
                      $restult['title_lang1'] =   "";
                    $restult['message_lang1'] =   ""; 
                    }
                } else {
                    
                }
            } else {
                
            }
        } else if ($at_child_status == 'absent') {

            if ($at_trip_type == 'pickup') {

                     if(!empty($localization_lang)){
                    $restult['title'] =   str_replace("{x}",$first_name,$localization_lang['title_pickup_absent']);
                    $restult['message'] =  str_replace("{x}",$first_name,$localization_lang['msg_pickup_absent']);
                    }else {
                    $restult['title'] = $first_name." ".'Not at Stop';
                    $restult['message'] = $child_name . ' was not at stop while picking from home bus stop';
                    }
                    if(!empty($localization_lang1)){
                    $restult['title_lang1'] =   str_replace("{x}",$first_name,$localization_lang1['title_pickup_absent']);
                    $restult['message_lang1'] =  str_replace("{x}",$first_name,$localization_lang1['msg_pickup_absent']);
                    
                    }else {
                      $restult['title_lang1'] =   "";
                    $restult['message_lang1'] =   ""; 
                    }
                
                
            } else if ($at_trip_type == 'drop off') {
                
                 if(!empty($localization_lang)){
                    $restult['title'] =   str_replace("{x}",$first_name,$localization_lang['title_dropoff_absent']);
                    $restult['message'] =  str_replace("{x}",$first_name,$localization_lang['msg_dropoff_absent']);
                    }else {
                    $restult['title'] = $first_name." ".'Not at Stop';
                    $restult['message'] = $child_name . ' was not at stop while picking from SCHOOL';
                    }
                    if(!empty($localization_lang1)){
                    $restult['title_lang1'] =   str_replace("{x}",$first_name,$localization_lang1['title_dropoff_absent']);
                    $restult['message_lang1'] =  str_replace("{x}",$first_name,$localization_lang1['msg_dropoff_absent']);
                    
                    }else {
                      $restult['title_lang1'] =   "";
                    $restult['message_lang1'] =   ""; 
                    }
                
            } else {
                
            }
        } else {
            
        }



        return $restult;
    }
    
    public function get_push_message_and_title_multi_lang_for_OT_students( $at_pickup_or_drop_off, $child_name,$localization_lang,$localization_lang1) {  
                   $first_name = explode(' ', $child_name)[0];

        $restult = array('message' => '', 'title' => '');  
        if($at_pickup_or_drop_off=='in'){
            if(!empty($localization_lang)){
           // $restult['title'] =   str_replace("{x}",$first_name,$localization_lang['title_pickup_home']);
            //$restult['message'] =  str_replace("{x}",$first_name,$localization_lang['msg_pickup_home']);
                 $restult['title'] =    $first_name." ".'Entered';
            $restult['message'] =  $child_name . ' has entered school premises';
            }else {
            $restult['title'] =    $first_name." ".'entered';
            $restult['message'] =  $child_name . ' has entered school premises';
            }
            if(!empty($localization_lang1)){
            $restult['title_lang1'] =   str_replace("{x}",$first_name,$localization_lang1['title_pickup_home']);
            $restult['message_lang1'] =  str_replace("{x}",$first_name,$localization_lang1['msg_pickup_home']);

            }else {
            $restult['title_lang1'] =   "";
            $restult['message_lang1'] =   ""; 
            }
        }else if($at_pickup_or_drop_off=='out'){
        
             if(!empty($localization_lang)){
           // $restult['title'] =   str_replace("{x}",$first_name,$localization_lang['title_pickup_home']);
            //$restult['message'] =  str_replace("{x}",$first_name,$localization_lang['msg_pickup_home']);
                 $restult['title'] =    $first_name." ".'Exited';
            $restult['message'] =  $child_name . ' has exited school premises';
            }else {
            $restult['title'] =    $first_name." ".'Entered';
            $restult['message'] =  $child_name . ' has exited school premises';
            }
            if(!empty($localization_lang1)){
            $restult['title_lang1'] =   str_replace("{x}",$first_name,$localization_lang1['title_pickup_home']);
            $restult['message_lang1'] =  str_replace("{x}",$first_name,$localization_lang1['msg_pickup_home']);

            }else {
            $restult['title_lang1'] =   "";
            $restult['message_lang1'] =   ""; 
            }
            
            
        }else {
            
        }
             return $restult;
                    
    }
    
    
    public function Bus_id_to_Bus_name_in_child_list($children,$bus_list) {
         foreach ($children as $keyd => $std) {
                        foreach ($bus_list as $key1 => $bus_all) {
                            if($bus_all['bus_id']==$std['child_bus_no_pickup']){
                                
                             $children[$keyd]['child_bus_no_pickup']=$bus_all['bus_desc'];
                             $children[$keyd]['child_bus_no_pickup']=$bus_all['bus_desc'];
                              $children[$keyd]['driver_phone_pickup']=$bus_all['driver_phone'];
                              $children[$keyd]['driver_name_pickup']=$bus_all['driver_name'];
                              $children[$keyd]['assistant_phone_pickup']=$bus_all['assistant_phone'];
                              $children[$keyd]['driver_assistant_pickup']=$bus_all['driver_assistant'];
                            }
                            if($bus_all['bus_id']==$std['child_bus_no_drop_off']){  
                              $children[$keyd]['child_bus_no_drop_off']=$bus_all['bus_desc'];
                              $children[$keyd]['driver_phone_drop_off']=$bus_all['driver_phone'];
                              $children[$keyd]['driver_name_drop_off']=$bus_all['driver_name'];
                              $children[$keyd]['assistant_phone_drop_off']=$bus_all['assistant_phone'];
                              $children[$keyd]['driver_assistant_drop_off']=$bus_all['driver_assistant'];
                            }
                           
                        }
                        
                    }
                    return $children;
    }
    public function Bus_id_to_Bus_name_in_child($child,$bus_list) {
        
    

                        foreach ($bus_list as $key1 => $bus_all) {
                         //   echo ">>".$bus_all['bus_id'] .'--'. $child['child_bus_no_pickup'];
                            if($bus_all['bus_id']==$child['child_bus_no_pickup']){
                              $child['child_bus_no_pickup']=$bus_all['bus_desc'];
                              $child['driver_phone_pickup']=$bus_all['driver_phone'];
                              $child['driver_name_pickup']=$bus_all['driver_name'];
                              $child['assistant_phone_pickup']=$bus_all['assistant_phone'];
                              $child['driver_assistant_pickup']=$bus_all['driver_assistant'];
                              break;
                              }
                           
                           
                        }
                        
                        foreach ($bus_list as $key1 => $bus_all) {
                        
                         if($bus_all['bus_id']==$child['child_bus_no_drop_off']){
                              $child['child_bus_no_drop_off']=$bus_all['bus_desc'];
                              $child['driver_phone_drop_off']=$bus_all['driver_phone'];
                              $child['driver_name_drop_off']=$bus_all['driver_name'];
                              $child['assistant_phone_drop_off']=$bus_all['assistant_phone'];
                              $child['driver_assistant_drop_off']=$bus_all['driver_assistant'];
                              break; 
                            }
                        }
                        

                    return $child;
    }
    
    
       public function trip_id_to_Trip_name_in_child_list($children,$trip_list) {
         foreach ($children as $keyd => $std) {
                        foreach ($trip_list as $key1 => $trip_all) {
                            if($trip_all['trip_id']==$std['child_trip_no_pickup']){
                                
                             $children[$keyd]['child_trip_no_pickup']=$trip_all['trip_no'];
                             $children[$keyd]['child_trip_pickup_title']=$trip_all['trip_title'];
    
                            }
                            if($trip_all['trip_id']==$std['child_trip_no_drop_off']){
                                $children[$keyd]['child_trip_no_drop_off']=$trip_all['trip_no'];    
                                $children[$keyd]['child_trip_drop_off_title']=$trip_all['trip_title'];    
                            }
                           
                        }
                        
                    }
                    return $children;
    } 
    
    
       public function trip_id_to_Trip_name_in_child_list_for_ls_editor_report($children,$trip_list) {
         foreach ($children as $keyd => $std) {
                        foreach ($trip_list as $key1 => $trip_all) {
                            if($trip_all['trip_id']==$std['at_trip_id']){
                                
                             $children[$keyd]['child_trip_no_pickup']=$trip_all['trip_no'];
                             $children[$keyd]['child_trip_pickup_title']=$trip_all['trip_title'];
    
                            }
                           
                        }
                        
                    }
                    return $children;
    } 
    
        public function Bus_id_to_Bus_name_in_attendance($att,$bus_list) {
        
    

                        foreach ($bus_list as $key1 => $bus_all) {
                         //   echo ">>".$bus_all['bus_id'] .'--'. $child['child_bus_no_pickup'];
                            if($bus_all['bus_id']==$att['at_bus_no']){
                              $att['bus_desc']=$bus_all['bus_desc'];
                              $att['driver_phone']=$bus_all['driver_phone'];
                              $att['driver_name']=$bus_all['driver_name'];
                              $att['assistant_phone']=$bus_all['assistant_phone'];
                              $att['driver_assistant']=$bus_all['driver_assistant'];
                              break;
                              }
                           
                           
                        }
                        
                        foreach ($bus_list as $key1 => $bus_all) {
                        
                         if($bus_all['bus_id']==$att['at_bus_no']){
                              $att['bus_desc']=$bus_all['bus_desc'];
                              $att['driver_phone']=$bus_all['driver_phone'];
                              $att['driver_name']=$bus_all['driver_name'];
                              $att['assistant_phone']=$bus_all['assistant_phone'];
                              $att['driver_assistant']=$bus_all['driver_assistant'];
                              break; 
                            }
                        }
                        

                    return $att;
    }
    
    
    
       public function trip_id_to_trip_name_in_child($attendance,$trip_list) {
         foreach ($trip_list as $key1 => $trip_all) {
                         //   echo ">>".$trip_all['trip_id'] .'--'. $child['child_trip_no_pickup'];
                            if($trip_all['trip_id']==$attendance['at_trip_id']){
                              $attendance['at_loc_longi']=$trip_all['trip_title'];
                              break;
                              }
                       }
                   return $attendance;
    }
    
    
    
    
    
    
    public function get_server_parent_app() {
        $output =  $this->parent_app_version();
        $servers= $this->get_server();
        $output['server_list']= $servers;    
        $output['status']= 'success';           
         return $output;
    }
    function get_production_server_parent_app() {
        $output =  $this->parent_app_version_production();
        $servers= $this->get_production_server();
        $servers_links= $this->get_production_server_links();
        $servers_names= $this->get_production_server_short_name();
        $output['server_list']= $servers;    
        $output['server_list_short_name']= $servers_names;    
        $output['server_list_links']= $servers_links;    
        $output['status']= 'success';           
         return $output;
    }
    
    public function get_server_supervisor_app() {
        $output =  $this->supervisor_app_version();
        $servers= $this->get_server();
        $output['server_list']= $servers;    
        $output['status']= 'success';           
         return $output;
    }
    function get_production_server_supervisor_app() {
        $output =  $this->supervisor_app_version_production();
        $servers= $this->get_production_server();
        $servers_links= $this->get_production_server_links();
        $servers_names= $this->get_production_server_short_name();
        $output['server_list']= $servers;  
        $output['server_list_short_name']= $servers_names;    
        $output['server_list_links']= $servers_links;  
        $output['status']= 'success';           
         return $output;
    }
    // for testing 
    public function get_server() {
        $servers=array (
        'AIS - Abu Dhabi'=>"http://host.ls-dunamis.com/~aisauh/",
        'AIS - MBZ'=>"http://host.ls-dunamis.com/~ais/",
        'Dunamis Academy'=>"http://host.ls-dunamis.com/~safety/",
        'Dunes Int\'l School'=>"http://host.ls-dunamis.com/~dunesauh/",
        'GIIS - Abu Dhabi'=>"http://host.ls-dunamis.com/~giis/", 
        'MES Qatar T'=>"http://host.ls-dunamis.com/~mesqatar/",
        'Ryan Masdar'=>"http://host.ls-dunamis.com/~ryanmasdar/",
    //    'Ryan Private School'=>"http://host.ls-dunamis.com/~ryanps/",
        'TRD Center 1'=>"http://host.ls-dunamis.com/~trac/",
        'TRD Center 2'=>"http://host.ls-dunamis.com/~jaziri/",
        'Birla Public School '=>"http://host.ls-dunamis.com/~bpsqatar/",
        'Shantiniketan Doha'=>"http://host.ls-dunamis.com/~sisqatar/",
        'Bhavans Doha'=>"http://host.ls-dunamis.com/~bhavansqatar/",
        "Olive Int'l School"=>"http://host.ls-dunamis.com/~oliveqatar/",
        "Noble Int'l School"=>"http://host.ls-dunamis.com/~nobleqatar/"
                
             );
          return $servers;
    }
    
    //for live 
    public function  get_production_server_links() {
         $servers=array (
//        "http://host.ls-dunamis.com/~aisauh/",
        "http://host.ls-dunamis.com/~ais/",
        "http://host.ls-dunamis.com/~safety/",
        "http://host.ls-dunamis.com/~dunesauh/",
        "http://host.ls-dunamis.com/~giis/", 
//        "http://host.ls-dunamis.com/~mesqatar/",
        "http://host.ls-dunamis.com/~ryanmasdar/",
     //   "http://host.ls-dunamis.com/~ryanps/",
//        "http://host.ls-dunamis.com/~trac/",
        "http://host.ls-dunamis.com/~jaziri/",
        "http://host.ls-dunamis.com/~bpsqatar/",
//        "http://host.ls-dunamis.com/~sisqatar/",
        "http://host.ls-dunamis.com/~bhavansqatar/",
        "http://host.ls-dunamis.com/~oliveqatar/",
        "http://host.ls-dunamis.com/~nobleqatar/"        
             );
          return $servers;
    }
    //for live 
    public function get_production_server_short_name() {
         $servers=array (
//        'AIS - Abu Dhabi',
        'AIS - MBZ',
        'Dunamis Academy',
        'Dunes Int\'l School',
        'GIIS - Abu Dhabi', 
//        'MES Qatar T',
        'Ryan Masdar',
      //  'Ryan Private School',
//        'TRD Center 1',
        'TRD Center 2',
        'Birla Public School',
//        'Shantiniketan Doha',
        'Bhavans Doha',
        "Olive Int'l School",
        "Noble Int'l School"
                
             );
          return $servers;
    }
    public function get_production_server() {
         $servers=array (
//        'AIS - Abu Dhabi'=>"http://host.ls-dunamis.com/~aisauh/",
        'AIS - MBZ'=>"http://host.ls-dunamis.com/~ais/",
        'Dunamis Academy'=>"http://host.ls-dunamis.com/~safety/",
        'Dunes Int\'l School'=>"http://host.ls-dunamis.com/~dunesauh/",
        'GIIS - Abu Dhabi'=>"http://host.ls-dunamis.com/~giis/", 
//        'MES Qatar T'=>"http://host.ls-dunamis.com/~mesqatar/",
        'Ryan Masdar'=>"http://host.ls-dunamis.com/~ryanmasdar/",
    //    'Ryan Private School'=>"http://host.ls-dunamis.com/~ryanps/",
//        'TRD Center 1'=>"http://host.ls-dunamis.com/~trac/",
        'TRD Center 2'=>"http://host.ls-dunamis.com/~jaziri/",
        'Birla Public School '=>"http://host.ls-dunamis.com/~bpsqatar/",
//        'Shantiniketan Doha'=>"http://host.ls-dunamis.com/~sisqatar/",
        'Bhavans Doha'=>"http://host.ls-dunamis.com/~bhavansqatar/",
        "Olive Int'l School"=>"http://host.ls-dunamis.com/~oliveqatar/",
        "Noble Int'l School"=>"http://host.ls-dunamis.com/~nobleqatar/"
                
             );
          return $servers;
    }
//    public function get_production_server() {
//         $servers=array (
//           'Global Indian Int\'l School'=>"http://host.beam2uae.com/~giis/",  
//          // 'ADIS'=>'http://host.beam2uae.com/~safetyapp/',
//          // 'Hafilat'=>'http://host.beam2uae.com/~safetyhal/',
//           'Dunamis Academy'=>"http://host.beam2uae.com/~safety/",
//           'The Royal Academy Ajman'=>"http://host.beam2uae.com/~trac/",
//           'Jaziri Transport'=>"http://host.beam2uae.com/~jaziri/",
//           'Abu Dhabi International School'=>"http://host.beam2uae.com/~ais/",
//           'Ryan Masdar'=>"http://host.beam2uae.com/~ryanmasdar/",
//           'Ryan Private School'=>"http://host.beam2uae.com/~ryanps/"
//                
//             );
//          return $servers;
//    }
    
    public function parent_app_version() {
         $output['ios_version']= "1.0.6";  
         $output['android_version']= "1.0.29";  
         $output['ios_force_update']= "0";
         $output['android_force_update']= "0";
         return $output;
    }
    public function parent_app_version_production() {
         $output['ios_version']= "1.0.6";  
         $output['android_version']= "1.0.29";  
         $output['ios_force_update']= "0";
         $output['android_force_update']= "0";
         return $output;
    }
    public function supervisor_app_version() {
         $output['ios_version']= "1.0";  
         $output['android_version']= "1.0.2";  
         $output['ios_force_update']= "0";
         $output['android_force_update']= "0";
         return $output;
    }
    public function supervisor_app_version_production() {
         $output['ios_version']= "1.0.2";  
         $output['android_version']= "1.0.2";  
         $output['ios_force_update']= "0";
         $output['android_force_update']= "0";
         return $output;
    }
    
    function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR']; 
    }
    return $ip;
}
    // for the table localization

      /*
     * Get localization by language_name
     */
    function get_localization($language_name)
    {
        return $this->db->get_where('localization',array('language_name'=>$language_name))->row_array();
    }
}

?>