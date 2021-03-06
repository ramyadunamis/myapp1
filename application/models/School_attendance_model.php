<?php

/*
 * Generated by CRUDigniter v2.3 Beta 
 * www.crudigniter.com
 */

class School_attendance_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /*
     * function to add new attendance
     */

    function add_attendance($params) {
        $this->db->insert('School_attendance', $params);
        return $this->db->insert_id();
    }

    function get_all_school_attendance($date,$table_name, $limit = null, $offset = NULL) {

        $this->db->select("e.*,edu.*");
        $this->db->from("$table_name e");
        $this->db->join("Child edu", "edu.child_id = e.at_child_id", 'left');
        $where = "DATE(e.at_time_stamp_device) = '$date'";
        $this->db->where($where);
        $this->db->group_by('edu.child_id');
        $this->db->order_by('e.at_id', 'desc');
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        return $query->result_array();
    }

    function count_school_attendance($date,$table_name) {
        $where = "DATE(at_time_stamp_device) = '$date'";
        $this->db->where($where);
        $this->db->group_by('at_child_id');
        $this->db->order_by('at_id', 'desc');
        $this->db->from($table_name);
        return $this->db->count_all_results();
    }

    
    function get_all_school_attendance_download_report($date,$table_name,$class='',$section='',$at_in_or_out='') {
        $this->db->select("e.*,edu.*");
        $this->db->from("$table_name e");
        $this->db->join("Child edu", "edu.child_id = e.at_child_id", 'left');
        $where = "DATE(e.at_time_stamp_device) = '$date'";
        $this->db->where($where);
        if($class!=''&& $section!=''){
             $this->db->where('edu.child_class',$class);
             $this->db->where('edu.child_section',$section);
            
        }
         if($at_in_or_out!=''){
               $this->db->where('e.at_in_or_out',$at_in_or_out);
         }
        $this->db->group_by('edu.child_id');
        $this->db->order_by('e.at_id', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    function get_all_school_attendance_download($date,$class='',$section='',$at_in_or_out='') {
        $this->db->select("e.*,edu.*");
        $this->db->from("School_attendance e");
        $this->db->join("Child edu", "edu.child_id = e.at_child_id", 'left');
        $where = "DATE(e.at_time_stamp_device) = '$date'";
        $this->db->where($where);
        if($class!=''&& $section!=''){
             $this->db->where('edu.child_class',$class);
             $this->db->where('edu.child_section',$section);
            
        }
         if($at_in_or_out!=''){
               $this->db->where('e.at_in_or_out',$at_in_or_out);
         }
        $this->db->group_by('edu.child_id');
        $this->db->order_by('e.at_id', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }
        public function is_dupplicate_entry($at_child_id,$at_in_or_out,$at_time_stamp_device)
       {
  $result=  $this->db->query("SELECT COUNT( * ) AS  `numrows` 
FROM  `School_attendance` 
WHERE  `at_child_id` =  '$at_child_id'
AND  `at_in_or_out` =  '$at_in_or_out'
AND DATE( at_time_stamp_device ) = DATE('$at_time_stamp_device')")->row_array();
          return $result['numrows'];
       }
       
       
       
           function get_all_school_attendance_download_in($date,$table_name) {
        $this->db->select("e.*,edu.*,`dv`.*");
        $this->db->from("$table_name e");
        $this->db->join("Child edu", "edu.child_id = e.at_child_id", 'left');
        $this->db->join("`Attendance_device`  dv", "`dv`.`device_id` = `e`.`at_device_id`", 'left');
        $where = "DATE(e.at_time_stamp_device) = '$date'  and `at_in_or_out`='in'";
        $this->db->where($where);
        $this->db->group_by('e.at_child_id');
        $this->db->order_by('edu.child_name', 'asc');
        $query = $this->db->get();
        return $query->result_array();
    }
    
          function get_all_school_attendance_download_out($date,$table_name) {
       $this->db->select("e.*,edu.*,`dv`.*");
        $this->db->from("$table_name e");
        $this->db->join("Child edu", "edu.child_id = e.at_child_id", 'left');
        $this->db->join("`Attendance_device`  dv", "`dv`.`device_id` = `e`.`at_device_id`", 'left');
        $where = "DATE(e.at_time_stamp_device) = '$date'  and `at_in_or_out`='out'";
        $this->db->where($where);
        $this->db->group_by('e.at_child_id');
         $this->db->order_by('edu.child_name', 'asc');
        $query = $this->db->get();
        return $query->result_array();
    }
       //new change 09-05-2018
      public function get_all_school_absent_list_report($date,$table_name,$class='',$section='')
       {
        $sub_qry="";
         if ($class!='' && $section!=''){
              $sub_qry=" and child_section='$section' and child_class ='$class'";
         }
          $result=  $this->db->query("SELECT * FROM Child WHERE Child.child_id NOT IN (SELECT $table_name.at_child_id FROM $table_name WHERE date($table_name.at_time_stamp_device) ='$date' ) $sub_qry")->result_array();
          return $result;
       }
          //new change 09-05-2018
       
    public function get_all_school_absent_list($date,$class='',$section='')
       {
        $sub_qry="";
         if ($class!='' && $section!=''){
              $sub_qry=" and child_section='$section' and child_class ='$class'";
         }
          $result=  $this->db->query("SELECT * FROM Child WHERE Child.child_id NOT IN (SELECT School_attendance.at_child_id FROM School_attendance WHERE date(School_attendance.at_time_stamp_device) ='$date' ) $sub_qry")->result_array();
          return $result;
       }
       
    public function count_students($class='',$section='') {
        $this->db->from('Child');
        if($class!='')
        $this->db->where("child_class", $class);
         if($section!='')
        $this->db->where("child_section", $section);
        $this->db->where("child_status ", "0");
         
        return $this->db->count_all_results();
    }

    
    function get_all_child() {
         $this->db->select('child_id');
         $this->db->select('child_name');
         $this->db->select('child_class');
         $this->db->select('child_section');
         $this->db->select('child_nfc_id');
         $this->db->select('child_reg_no');
         $this->db->select('child_father_name');
         $this->db->from('Child');
          $this->db->where("child_status", '0');
         return $this->db->get()->result_array();
    }
    
    
     public function entry_log_list($child_ids,$date)
       {
           $ids = join("','",$child_ids);  
          $result=  $this->db->query("SELECT * FROM `School_attendance` WHERE date(at_time_stamp_device)='$date' and `at_child_id` IN ('$ids') and at_in_or_out='in'")->result_array();
          return $result;
       }
         
       public function exit_log_list($child_ids,$date)
       {
           $ids = join("','",$child_ids);  
          $result=  $this->db->query("SELECT * FROM `School_attendance` WHERE date(at_time_stamp_device)='$date' and `at_child_id` IN ('$ids') and at_in_or_out='out'")->result_array();
          return $result;
       }
       
        public function get_one_month_school_attendance_in($year,$month,$child_id)
       {
          $sub_query='';
          if($month!='' && $year!=''){
               $sub_query="and YEAR(`at_time_stamp_device`)='$year'";
              $sub_query .="and MONTH(`at_time_stamp_device`)='$month'";
             
          }
 
          $result=  $this->db->query("SELECT * FROM School_attendance where `at_child_id`='$child_id'  $sub_query and `at_in_or_out`='in'")->result_array();
          return $result;
       }
         public function get_one_month_school_attendance_out($year,$month,$child_id)
       {
          $sub_query='';
          if($month!='' && $year!=''){
              $sub_query="and YEAR(`at_time_stamp_device`)='$year'";
              $sub_query .="and MONTH(`at_time_stamp_device`)='$month'";
             
          }
          $result=  $this->db->query("SELECT * FROM School_attendance where `at_child_id`='$child_id'  $sub_query and `at_in_or_out`='out'")->result_array();
          return $result;
       }
       
          public function get_date_school_attendance_in($date,$child_id)
       {
          $result=  $this->db->query("SELECT * FROM School_attendance where `at_child_id`='$child_id' and date(`at_time_stamp_device`)='$date' and `at_in_or_out`='in'")->result_array();
          return $result;
       }
         public function get_date_school_attendance_out($date,$child_id)
       {
          $result=  $this->db->query("SELECT * FROM School_attendance where `at_child_id`='$child_id' and date(`at_time_stamp_device`)='$date'  and `at_in_or_out`='out'")->result_array();
          return $result;
       }
       function get_all_classes() {

          
        return  $this->db->query("SELECT DISTINCT `child_class` FROM `Child` ORDER BY CONVERT(SUBSTRING_INDEX(child_class,'-',-1),UNSIGNED INTEGER)")->result_array();
           
          
       } 
       function get_all_sections($class) {
         
          $this->db->distinct('child_section');
          $this->db->select('child_section');
          $this->db->order_by('child_section');
          $this->db->where('child_class', $class); 
          return $this->db->get('Child')->result_array();

       } 
       
        function get_all_school_attendance_download_manual($date,$table_name) {
        $this->db->select("e.*,edu.*,`dv`.*");
        $this->db->from("$table_name e");
        $this->db->join("Child edu", "edu.child_id = e.at_child_id", 'left');
        $this->db->join("`Attendance_device`  dv", "`dv`.`device_id` = `e`.`at_device_id`", 'left');
        $where = "DATE(e.at_time_stamp_device) = '$date' and substr(e.at_loc_data_type, -1)='c'";
        $this->db->where($where);
        $this->db->order_by('edu.child_name', 'asc');
        $query = $this->db->get();
        return $query->result_array();
    }
      function get_morning_halfday_leave($date,$child_ids) {
               
        $this->db->select('*');
        $this->db->where_in('at_child_id',$child_ids);
        $this->db->where('at_trip_type','pickup');
        $this->db->where('at_pickup_or_drop_off','pickup');
        $this->db->where('at_child_status','absent');
        $this->db->where('date(at_time_stamp_device)',$date);     
        return $this->db->get('Attendance')->result_array();
        
    }
      function get_morning_attendance_in_class_buss($date,$child_ids) {
               
        $this->db->select('*');
        $this->db->where_in('at_child_id',$child_ids);
        $this->db->where('at_trip_type','pickup');
        $this->db->where('at_pickup_or_drop_off','pickup');
        $this->db->where('at_child_status','present');
        $this->db->where('date(at_time_stamp_device)',$date);     
        return $this->db->get('Attendance')->result_array();
        
    }
    
     function get_bus_attendance_status($date) {
         
        $dateattendance=date('Y-m-d', strtotime('-8 days'));
        $datetimeattendance=$dateattendance.'60;60:60';
        if($date<$datetimeattendance)
        {
          $table_name_attendance='copy_attendance';
        }
        else 
        {
         $table_name_attendance='Attendance';       
        }
        //echo $table_name_attendance;
        return  $this->db->query("SELECT at_bus_no,at_trip_type,at_child_id,at_child_status FROM $table_name_attendance WHERE `at_trip_type`='pickup' and date(`at_time_stamp_device`)=date('$date') and  at_pickup_or_drop_off='pickup'")->result_array();
        
    }
}
