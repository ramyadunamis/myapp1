<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class Attendance_device_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get attendance_device by device_id
     */
    function get_attendance_device($device_id)
    {
        return $this->db->get_where('Attendance_device',array('device_id'=>$device_id))->row_array();
    }
    function get_attendance_device_by_bus_id($bus_id)
    {
        return $this->db->query("SELECT `device_id` FROM `Attendance_device` WHERE `device_desc`=(SELECT bus_desc FROM Bus WHERE bus_id='$bus_id')")->row_array();
    }
    
       /*
     * Get attendance_device by device_id
     */
    function get_attendance_device_all()
    {
        return $this->db->get('Attendance_device')->result_array();
    }
    /*
     * Get all attendance_device count
     */
    function get_all_attendance_device_count()
    {
        $this->db->from('Attendance_device');
        return $this->db->count_all_results();
    }
        
    /*
     * Get all attendance_device
     */
    function get_all_attendance_device($limit = null, $offset = NULL)
    {
        $this->db->order_by('device_id', 'desc');
         $this->db->limit($limit, $offset);
        return $this->db->get('Attendance_device')->result_array();
    }
        
    /*
     * function to add new attendance_device
     */
    function add_attendance_device($params)
    {
        $this->db->insert('Attendance_device',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update attendance_device
     */
    function update_attendance_device($device_id,$params)
    {
        $this->db->where('device_id',$device_id);
        return $this->db->update('Attendance_device',$params);
    }
    
    /*
     * function to delete attendance_device
     */
    function delete_attendance_device($device_id)
    {
        return $this->db->delete('Attendance_device',array('device_id'=>$device_id));
    }
}