<?php
/* 
 * Generated by CRUDigniter v2.3 Beta 
 * www.crudigniter.com
 */
 
class Report extends CI_Controller
{
 function __construct()
    {
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
        $this->load->model('School_attendance_model');
           $this->load->model('User_model');
           if (!$this->User_model->auth_session()) {
            redirect('Login');
        }
        
    } 

    /*
     * Listing of notification
     */
    function index()
    {
         $data['page_title'] = 'Report';
         $data['bus'] = $this->Bu_model->get_all_bus();
        // $data['trip_num']  = $this->Trip_model->get_trip_with_bus_id_index('1');
         $this->load->view('report/index',$data);
    }

 function search()
    {  
     $data['page_title'] = 'Report';
     $data['bus'] = $this->Bu_model->get_all_bus();
//     
//    $tracking_time_stamp=date("Y/m/d");
    $date=$this->input->get('date');
    $time_stamp= date('Y-m-d', strtotime($date));
           
   
    $tracking_bus_id_all=$this->input->get('bus');
    $radio=$this->input->get('radio');
    if($tracking_bus_id_all)
    {
        $radio='';
    }
     $this->load->view('report/report_header'); 
    if($tracking_bus_id_all=='All')
     {
       
       $all_bus = $this->Bu_model->get_all_bus();
         for($m=0;$m<count($all_bus);$m++)
         {
            $tracking_bus_id=$all_bus[$m]['bus_id'];
            $all_trip = $this->Trip_model->get_trip_with_bus_id_index($all_bus[$m]['bus_id']);
           //  echo $this->db->last_query();exit();
            foreach ($all_trip as $key => $value) {
                 // $all_trip[$key]['trip_bus_id']=$all_bus[$m];
               //  print_r($all_trip);
        $tracking_trip_id=$all_trip[$key]['trip_id'];
       $data['bus_name']= $this->Bu_model->get_bu($tracking_bus_id);
       $data['trip']= $this->Trip_model->get_trip($tracking_trip_id);
       
        $date=date('Y-m-d', strtotime('-7 days'));
        $datetime=$date.'60;60:60';
       if($time_stamp<$datetime)
       {
          $table_name='Copy_tracking';
       }
    else {
         $table_name='Tracking';       
        }
        
        
       $data['time']= $this->Tracking_model->get_tracking_details_for_report($time_stamp,$tracking_trip_id,$tracking_bus_id,$table_name);
//           echo $this->db->last_query();exit();
         if($time_stamp<$datetime)
       {
          $table_name1='copy_attendance';
       }
    else {
         $table_name1='Attendance';       
        }
       $data1 = $this->Child_model->bus_child_details_pickup_report_pickup($tracking_trip_id,$time_stamp,$table_name1); 
        $data2 = $this->Child_model->bus_child_details_pickup_report_dropoff($tracking_trip_id,$time_stamp,$table_name1);  
     //   echo $this->db->last_query();exit();
       for($j=0;$j<count($data1);$j++)
        {
         $child_id_pick=$data1[$j]['child_id'];
            $data1[$j]['at_time_stamp']=$data1[$j]['at_time_stamp_device'];
          
         for($k=0;$k<count($data2);$k++)
        {
              $child_id_drop=$data2[$k]['child_id'];
              $child_id_time=$data2[$k]['at_time_stamp_device'];
        
   
        if($child_id_pick==$child_id_drop)
        {
          $data1[$j]['at_time_stamp_device']=$child_id_time;
        }
         }
     }
       $data['child_present'] = $data1;
       
       
        $data['child_not_on_the_bus']  = $this->Child_model->bus_child_details_absent_report($tracking_trip_id,$time_stamp,$table_name1); 
     
       // print_r($data);
       $this->load->view('report/report_view',$data); 
        }
   }
 }
 else if($radio) 
     {
       $radio=$this->input->get('radio');
       $start=explode("-",$radio);
      // $m=$radio;
     //print_r($start);
      
         for($m=$start[0];$m<=$start[1];$m++)
         {
        //  echo $m;
             $bus_details = $this->Bu_model->get_bus_name($m);
             // echo $this->db->last_query();exit();
            $tracking_bus_id=$bus_details['bus_id'];
            $all_trip = $this->Trip_model->get_trip_with_bus_id_index($tracking_bus_id);
            
            foreach ($all_trip as $key => $value) {
                 // $all_trip[$key]['trip_bus_id']=$all_bus[$m];
               //  print_r($all_trip);
        $tracking_trip_id=$all_trip[$key]['trip_id'];
       $data['bus_name']= $this->Bu_model->get_bu($tracking_bus_id);
       $data['trip']= $this->Trip_model->get_trip($tracking_trip_id);
//        echo $this->db->last_query();exit();
        $date=date('Y-m-d', strtotime('-7 days'));
        $datetime=$date.'60;60:60';
       if($time_stamp<$datetime)
       {
          $table_name='Copy_tracking';
       }
    else {
         $table_name='Tracking';       
        } 
       $data['time']= $this->Tracking_model->get_tracking_details_for_report($time_stamp,$tracking_trip_id,$tracking_bus_id,$table_name);
  //  echo $this->db->last_query();exit();   
        if($time_stamp<$datetime)
       {
          $table_name1='copy_attendance';
       }
    else {
         $table_name1='Attendance';       
        }
       $data1 = $this->Child_model->bus_child_details_pickup_report_pickup($tracking_trip_id,$time_stamp,$table_name1); 
        $data2 = $this->Child_model->bus_child_details_pickup_report_dropoff($tracking_trip_id,$time_stamp,$table_name1);  
     //   echo $this->db->last_query();exit();
       for($j=0;$j<count($data1);$j++)
        {
         $child_id_pick=$data1[$j]['child_id'];
            $data1[$j]['at_time_stamp']=$data1[$j]['at_time_stamp_device'];
          
         for($k=0;$k<count($data2);$k++)
        {
              $child_id_drop=$data2[$k]['child_id'];
              $child_id_time=$data2[$k]['at_time_stamp_device'];
        
   
        if($child_id_pick==$child_id_drop)
        {
          $data1[$j]['at_time_stamp_device']=$child_id_time;
        }
         }
     }
       $data['child_present'] = $data1;
       
      
        $data['child_not_on_the_bus']  = $this->Child_model->bus_child_details_absent_report($tracking_trip_id,$time_stamp,$table_name1); 
      //echo $this->db->last_query();exit();  
       // print_r($data);
       $this->load->view('report/report_view',$data); 
        }
  }
 }
    
 else {
        $tracking_bus_id=$this->input->get('bus');
        $tracking_trip_id= $this->input->get('trip');
      //.........................................................................
       $data['bus_name']= $this->Bu_model->get_bu($tracking_bus_id);
       $data['trip']= $this->Trip_model->get_trip($tracking_trip_id);
       
               $date=date('Y-m-d', strtotime('-7 days'));
        $datetime=$date.'60;60:60';
       if($time_stamp<$datetime)
       {
          $table_name='Copy_tracking';
       }
    else {
         $table_name='Tracking';       
        }
        
       $data['time']= $this->Tracking_model->get_tracking_details_for_report($time_stamp,$tracking_trip_id,$tracking_bus_id,$table_name);
      //       echo $this->db->last_query();exit();
       if($time_stamp<$datetime)
       {
          $table_name1='copy_attendance';
       }
    else {
         $table_name1='Attendance';       
        }
       $data1 = $this->Child_model->bus_child_details_pickup_report_pickup($tracking_trip_id,$time_stamp,$table_name1); 
      //  echo $this->db->last_query();exit();
        $data2 = $this->Child_model->bus_child_details_pickup_report_dropoff($tracking_trip_id,$time_stamp,$table_name1);  
      
       for($j=0;$j<count($data1);$j++)
        {
         $child_id_pick=$data1[$j]['child_id'];
            $data1[$j]['at_time_stamp']=$data1[$j]['at_time_stamp_device'];
          
         for($k=0;$k<count($data2);$k++)
        {
              $child_id_drop=$data2[$k]['child_id'];
              $child_id_time=$data2[$k]['at_time_stamp_device'];
        
   
        if($child_id_pick==$child_id_drop)
        {
          $data1[$j]['at_time_stamp_device']=$child_id_time;
        }
         }
     }
       $data['child_present'] = $data1;
       
       
        $data['child_not_on_the_bus']  = $this->Child_model->bus_child_details_absent_report($tracking_trip_id,$time_stamp,$table_name1); 
      //  echo $this->db->last_query();exit();
        
        
//       print_r($data);
//      exit(); 
//        $data['child_present']
  //     echo $this->db->last_query();exit();
        
      //  $child_bus_not_present = $this->Child_model->bus_child_details_not_present_report($tracking_trip_id,$pickup_or_drop_off,$time_stamp);
        
        //  echo $this->db->last_query();exit();
   
     //   $child_bus_absent = $this->Child_model->bus_child_details_absent_report($tracking_trip_id,$pickup_or_drop_off,$time_stamp);
        
        
        
     
       $this->load->view('report/report_view',$data); 
 }
    }
  public function save_download()
  { 
  $this->load->helper(array('My_Pdf'));   //  Load helper
 $data = file_get_contents(site_url('report/report_view')); // Pass the url of html report
 create_pdf($data); //Create pdf
 }
  
public function pdf() {
     ini_set('memory_limit', '100M');
      $data['page_title'] = 'Report';
     $data['bus'] = $this->Bu_model->get_all_bus();
 
//    $tracking_time_stamp=date("Y/m/d");
    $date=$this->input->get('date');
    $time_stamp= date('Y-m-d', strtotime($date));
    $tracking_bus_id_all=$this->input->get('bus');
     if($tracking_bus_id_all=='All')
     {
         $this->load->view('report/report_pdf_header.php'); 
       $all_bus = $this->Bu_model->get_all_bus();
         for($m=0;$m<count($all_bus);$m++)
         {
            $tracking_bus_id=$all_bus[$m]['bus_id'];
            $all_trip = $this->Trip_model->get_trip_with_bus_id_index($all_bus[$m]['bus_id']);
           //  echo $this->db->last_query();exit();
            foreach ($all_trip as $key => $value) {
                 // $all_trip[$key]['trip_bus_id']=$all_bus[$m];
               //  print_r($all_trip);
        $tracking_trip_id=$all_trip[$key]['trip_id'];
       $data['bus_name']= $this->Bu_model->get_bu($tracking_bus_id);
       $data['trip']= $this->Trip_model->get_trip($tracking_trip_id);
       
                      $date=date('Y-m-d', strtotime('-7 days'));
        $datetime=$date.'60;60:60';
       if($time_stamp<$datetime)
       {
          $table_name='Copy_tracking';
       }
    else {
         $table_name='Tracking';       
        }
        
       
       $data['time']= $this->Tracking_model->get_tracking_details_for_report($time_stamp,$tracking_trip_id,$tracking_bus_id,$table_name);
      //       echo $this->db->last_query();exit();
        if($time_stamp<$datetime)
       {
          $table_name1='copy_attendance';
       }
    else {
         $table_name1='Attendance';       
        }
       $data1 = $this->Child_model->bus_child_details_pickup_report_pickup($tracking_trip_id,$time_stamp,$table_name1); 
         $data2 = $this->Child_model->bus_child_details_pickup_report_dropoff($tracking_trip_id,$time_stamp,$table_name1); 
       for($j=0;$j<count($data1);$j++)
        {
         $child_id_pick=$data1[$j]['child_id'];
      
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
       $data['child_present'] = $data1;
       
       
        $data['child_not_on_the_bus']  = $this->Child_model->bus_child_details_absent_report($tracking_trip_id,$time_stamp,$table_name1); 
     
     
     $html.=  $this->load->view('report/report_view_pdf',$data,true);        
   
        }
     
   }
   
    $this->load->helper('dompdf');   
     pdf_create($html);     
 }
 
 
  else if($this->input->get('radio') && $tracking_bus_id_all=='') 
     {
       $this->load->view('report/report_pdf_header.php'); 
     // echo 'here radio';
       $radio=$this->input->get('radio');
      // $m=$radio;
       $start=explode("-",$radio);
    //  print_r($start);
                $html='';       
         for($m=$start[0];$m<=$start[1];$m++)
         {
        //  echo $m;
             $bus_details = $this->Bu_model->get_bus_id($m);
             // echo $this->db->last_query();exit();
            $tracking_bus_id=$bus_details['bus_id'];
            $all_trip = $this->Trip_model->get_trip_with_bus_id_index($tracking_bus_id);

            foreach ($all_trip as $key => $value) {
                 // $all_trip[$key]['trip_bus_id']=$all_bus[$m];
               //  print_r($all_trip);
        $tracking_trip_id=$all_trip[$key]['trip_id'];
       $data['bus_name']= $this->Bu_model->get_bu($tracking_bus_id);
       $data['trip']= $this->Trip_model->get_trip($tracking_trip_id);
       
                      $date=date('Y-m-d', strtotime('-7 days'));
        $datetime=$date.'60;60:60';
       if($time_stamp<$datetime)
       {
          $table_name='Copy_tracking';
       }
    else {
         $table_name='Tracking';       
        }
        
       
       $data['time']= $this->Tracking_model->get_tracking_details_for_report($time_stamp,$tracking_trip_id,$tracking_bus_id,$table_name);
        // echo $this->db->last_query();exit();
             if($time_stamp<$datetime)
       {
          $table_name1='copy_attendance';
       }
    else {
         $table_name1='Attendance';       
        }
       $data1 = $this->Child_model->bus_child_details_pickup_report_pickup($tracking_trip_id,$time_stamp,$table_name1); 
        $data2 = $this->Child_model->bus_child_details_pickup_report_dropoff($tracking_trip_id,$time_stamp,$table_name1); 
       for($j=0;$j<count($data1);$j++)
        {
         $child_id_pick=$data1[$j]['child_id'];
       
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
       $data['child_present'] = $data1;
       
       
        $data['child_not_on_the_bus']  = $this->Child_model->bus_child_details_absent_report($tracking_trip_id,$time_stamp,$table_name1); 
     
        $html.=  $this->load->view('report/report_view_pdf',$data,true);      
        }
   }
   // print_r($html);
    $this->load->helper('dompdf');   
     pdf_create($html);   
 }

 else {
     
       $tracking_bus_id=$this->input->get('bus');
       $tracking_trip_id= $this->input->get('trip');
     //.........................................................................
       $data['bus_name']= $this->Bu_model->get_bu($tracking_bus_id);
       $data['trip']= $this->Trip_model->get_trip($tracking_trip_id);
       
                      $date=date('Y-m-d', strtotime('-7 days'));
        $datetime=$date.'60;60:60';
       if($time_stamp<$datetime)
       {
          $table_name='Copy_tracking';
       }
    else {
         $table_name='Tracking';       
        }
        
       
       $data['time']= $this->Tracking_model->get_tracking_details_for_report($time_stamp,$tracking_trip_id,$tracking_bus_id,$table_name);
//       echo $this->db->last_query();exit();
                if($time_stamp<$datetime)
       {
          $table_name1='copy_attendance';
       }
    else {
         $table_name1='Attendance';       
        }
       $data1 = $this->Child_model->bus_child_details_pickup_report_pickup($tracking_trip_id,$time_stamp,$table_name1); 
        $data2 = $this->Child_model->bus_child_details_pickup_report_dropoff($tracking_trip_id,$time_stamp,$table_name1); 
       for($j=0;$j<count($data1);$j++)
        {
         $child_id_pick=$data1[$j]['child_id'];
       
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
       $data['child_present'] = $data1;
       
       
        $data['child_not_on_the_bus']  = $this->Child_model->bus_child_details_absent_report($tracking_trip_id,$time_stamp,$table_name1); 
  
     
     $html=  $this->load->view('report/report_view_pdf',$data,true);     
    $this->load->helper('dompdf');   
     pdf_create($html);
 }
 }
    function report_pdf_header()
    {
         $data['page_title'] = 'Report';
        
         $this->load->view('report/report_pdf_header',$data);
    }
     function report_csv()
    {
         $data['page_title'] = 'Report';
         $this->load->view('report/report_csv',$data);
    }
    
       function search_csv()
    {
         ini_set('memory_limit', '200M');
         $data_page['page_title'] = 'Report';
         $date1=$this->input->get('date');
            $date= $date1;
            $date = date("Y-m-d", strtotime($date));

               $date= $date1;
            $date = date("Y-m-d", strtotime($date));
            $date_7day=date('Y-m-d', strtotime('-7 days'));
       if($date<$date_7day)
       {
            $att_list = $this->Attendance_model->get_all_copy_attendance_download_pickup($date); 
         $att_dropoff = $this->Attendance_model->get_all_copy_attendance_download_dropoff($date); 
       }
 else {
        $att_list = $this->Attendance_model->get_all_attendance_download_pickup($date); 
         $att_dropoff = $this->Attendance_model->get_all_attendance_download_dropoff($date);     
       } 

                 
  // echo $this->db->last_query(); exit(); 
        if($att_list=='' || $att_dropoff=='')
        {
             $output = array('status' => 'NO Attendance'); 
        }
        else
        {
             $bus_list=$this->Bu_model->get_all_bus();  
             $trip_list = $this->Trip_model->get_full_trip();
             for ($j = 0; $j < count($att_list); $j++) {
                        $att_list[$j]= $this->common_model->Bus_id_to_Bus_name_in_child($att_list[$j],$bus_list);     
                 
                         $att_list[$j]= $this->common_model->trip_id_to_trip_name_in_child($att_list[$j],$trip_list);
                        $flag_is_drop_off=true;
                        for ($k = 0; $k < count($att_dropoff); $k++) {
                       
                             if(($att_dropoff[$k]['at_child_id']==$att_list[$j]['at_child_id']) && ($att_dropoff[$k]['at_trip_id']==$att_list[$j]['at_trip_id'])  )
                             {
                                $att_list[$j]['at_child_drop_off_time']=$att_dropoff[$k]['at_time_stamp'];
                                $att_list[$j]['card_type']=$att_dropoff[$k]['at_loc_data_type'];
                                $flag_is_drop_off=false;
                             }
                         }
                         if($flag_is_drop_off){
                            $att_list[$j]['at_child_drop_off_time']='';  
                            $att_list[$j]['card_type']='';  
                         }
                       }
     
        
             $result = $att_list;
            header("Content-type: application/csv");
            header("Content-Disposition: attachment; filename=\"BusList".".csv\"");
            header("Pragma: no-cache");
            header("Expires: 0");
            $handle = fopen('php://output', 'w'); 
             fputcsv($handle, array('#','Name', 'NFC', 'REG #', 'CLASS & SECTION', 'DATE', 'BUS', 'PICK-UP','BUS', 'DROP-OFF','CARD-TYPE','Present/ Absent','Trip'));
                          $i = 1;
                          foreach ($result as $data) { 
                              $pickup_time= date('Y-m-d H:i:s',strtotime('+4 hour',strtotime($data["at_time_stamp"])));
                               $dropoff_time= date('Y-m-d H:i:s',strtotime('+4 hour',strtotime($data["at_child_drop_off_time"])));
                              if(substr($data["at_loc_data_type"], -1)=='s'){ $pickup_type= 'C';} else { $pickup_type= 'T'; }
                               if(substr($data["card_type"], -1)=='s'){ $dropoff_type= 'C';} else { $dropoff_type= 'T'; }
                               $type=$pickup_type.','.$dropoff_type;
                              fputcsv($handle, array($i, $data["child_name"], $data["child_nfc_id"], $data["child_reg_no"], $data["child_class"].'-'.$data["child_section"], date("j-M", strtotime($data["at_time_stamp"])),$data["child_bus_no_pickup"], date('G.s',  strtotime($pickup_time)), $data["child_bus_no_drop_off"],date('G.s',  strtotime($dropoff_time)),$type,ucfirst($data["at_child_status"]), $data["at_loc_longi"]));
                              $i++;
                          }
             fclose($handle);
                          exit;
        }
         $this->load->view('report/report_csv',$data_page);
    }
    
    
         function report_count_csv()
    {
         $data['page_title'] = 'Report';
          $data['msg']='';
         $this->load->view('report/report_count_csv',$data);
    }
    
    
      function search_count_csv()
    {
         ini_set('memory_limit', '200M');
         $data_page['page_title'] = 'Report';
        
            $date1=$this->input->get('datefrom');
            $date= $date1;
            $from = date("Y-m-d", strtotime($date));
            
            $date2=$this->input->get('dateTo');
            $date= $date2;
            $to = date("Y-m-d", strtotime($date));
            
            $date1=date_create($from);
            $date2=date_create($to);
            $diff=date_diff($date1,$date2);
            $days= $diff->format("%a");
            if($days>30)
            {
                $data_page['msg']='Please choose date difference below 30 days';
                 $this->load->view('report/report_count_csv',$data_page);
            }
           else {
                $data_page['msg']='';
            $att = $this->Attendance_model->get_count_trips_in_attendance_download($from,$to);
          // echo $this->db->last_query(); exit();
          
        if($att=='')
        {
             $output = array('status' => 'NO Attendance'); 
        }
        else
        {
     
             $result = $att;
            header("Content-type: application/csv");
            header("Content-Disposition: attachment; filename=\"BusList".".csv\"");
            header("Pragma: no-cache");
            header("Expires: 0");
            $handle = fopen('php://output', 'w'); 
             fputcsv($handle, array('#','Name', 'REG #', 'CLASS & SECTION','Bus','Total no of trips'));
                          $i = 1;
                          foreach ($result as $data) { 
                              
                              fputcsv($handle, array($i, $data["child_name"], $data["child_reg_no"], $data["child_class"].'-'.$data["child_section"],$data["bus_desc"],$data["count"]));
                              $i++;
                          }
             fclose($handle);
                          exit;
        }
         $this->load->view('report/report_count_csv',$data_page);
 }
    }
    
         function touch_screen_scan_report()
    {
         $data['page_title'] = 'Report';
          $data['msg']='';
         $this->load->view('report/touch_screen_scan_report',$data);
    }
    
     public function search_touch_screen_scan_report() {
     
         $data_page['page_title'] = 'Report';
         $date=$this->input->get('date');
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
      //     print_r($att_list);               exit();
    //   echo $this->db->last_query(); exit();
     
                $bus_list=$this->Bu_model->get_all_bus();  
                $trip_list = $this->Trip_model->get_full_trip();
                 for ($j = 0; $j < count($att_list); $j++) {
                       $att_list[$j]= $this->common_model->Bus_id_to_Bus_name_in_attendance($att_list[$j],$bus_list);   
                 }
                $att_list= $this->common_model->trip_id_to_Trip_name_in_child_list($att_list,$trip_list);
          
         // print_r($att_list);               exit();
            $result = $att_list;
            header("Content-type: application/csv");
            header("Content-Disposition: attachment; filename=\"TouchList".".csv\"");
            header("Pragma: no-cache");
            header("Expires: 0");
            $handle = fopen('php://output', 'w'); 
            $i = 1;
            fputcsv($handle, array('#', 'BUS #', 'TRIP', 'NAME', 'ID', 'SCAN TIME'));
            foreach ($result as $data) {
                $datetime = new DateTime($data["at_time_stamp"]);
                $datetime->setTimezone($la_time);
                $in_time = $datetime->format('Y-m-d H:i:s');
                $time = date("H:i:s", strtotime($in_time));
                
                fputcsv($handle, array($i, $data["bus_desc"], $data["child_trip_pickup_title"], $data["child_name"], $data["child_reg_no"] , date("G.s", strtotime($time))));
                $i++;
           }
             fclose($handle);
            exit;
        
         $this->load->view('report/touch_screen_scan_report',$data_page);
     }
     
     function absent_list_report()
    {
         $data['page_title'] = 'Report';
          $data['msg']='';
         $this->load->view('report/absent_list_report',$data);
    }
    
     public function search_absent_report() {
     
         $data_page['page_title'] = 'Report';
         $date=$this->input->get('date');
         $date = date("Y-m-d", strtotime($date));
         $date_7day=date('Y-m-d', strtotime('-7 days'));
         
        
         $settings = $this->Setting_model->get_all_settings();
        $la_time = new DateTimeZone('UTC');
        foreach ($settings as $key => $value) {
            $la_time = new DateTimeZone($value['timezone']);
        }
        
        
       $att_list = $this->School_attendance_model->get_all_school_attendance_download_manual($date);
      //     print_r($att_list);               exit();
     //   echo $this->db->last_query(); exit();
            $result = $att_list;
            header("Content-type: application/csv");
            header("Content-Disposition: attachment; filename=\"AbsentList".".csv\"");
            header("Pragma: no-cache");
            header("Expires: 0");
            $handle = fopen('php://output', 'w'); 
            $i = 1;
  fputcsv($handle, array('#', 'CLASS & SECTION', 'NAME', 'ID', 'TIME', 'DEVICE ID'));
          foreach ($result as $data) {
               //  $time= date('Y-m-d H:i:s',strtotime('+4 hour',strtotime($data["at_time_stamp"])));
                 
                    $datetime = new DateTime($data["at_time_stamp"]);
                $datetime->setTimezone($la_time);
                $in_time = $datetime->format('Y-m-d H:i:s');
                $time = date("H:i:s", strtotime($in_time));
                fputcsv($handle, array($i, $data["child_class"].'-'.$data["child_section"], $data["child_name"], $data["child_reg_no"], date("G.s", strtotime($time)) , $data["device_name"]));
                $i++;
            }
             fclose($handle);
            exit;
        
         $this->load->view('report/absent_list_report',$data_page);
     }
}