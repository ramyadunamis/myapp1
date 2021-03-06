<?php
/* 
 * Generated by CRUDigniter v2.3 Beta 
 * www.crudigniter.com
 */
 
class Parent_app_user_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get parent_app_user by parent_app_user_id
     */
    function get_parent_app_user($parent_app_user_id)
    {
        return $this->db->get_where('Parent_App_User',array('parent_app_user_id'=>$parent_app_user_id))->row_array();
    }
    
    
     public function count()
       {
         $query = $this->db->query("SELECT COUNT( * ) as count_val FROM (SELECT parent_app_user_name FROM  `Parent_App_User` WHERE  `parent_app_user_status` =1 group by `parent_app_user_name`) AS t")->row_array();
            return $query['count_val'];
//          $this->db->where('parent_app_user_status',1);
//           $this->db->from('Parent_App_User');
//          return $this->db->count_all_results();
       } 
          public function signedup_count()
       {
               $query = $this->db->query("SELECT COUNT( * ) as count_val FROM (SELECT parent_app_user_name FROM  `Parent_App_User` WHERE  `parent_app_user_status` =0 group by `parent_app_user_name`) AS t")->row_array();
                return $query['count_val'];
  
  
//          $this->db->where('parent_app_user_status',0);
//           $this->db->from('Parent_App_User');
//          return $this->db->count_all_results();
       } 
       
    public function count_parents() {
        $this->db->from('Parent_App_User');
        return $this->db->count_all_results();
    }
       
       
    /*
     * Get all parent_app_user
     */
    function get_all_parent_app_user($limit=null,$offset=NULL)
    {
        return $this->db->query("SELECT * FROM Parent_App_User AS s JOIN Child AS c ON s.parent_app_user_name = c.child_father_email_id where s.`parent_app_user_status`=1 GROUP BY  `parent_app_user_name` LIMIT $offset,$limit ")->result_array();
       
        
//      $this->db->where('parent_app_user_status',1);
//      $this->db->limit($limit, $offset);
//      return $this->db->get('Parent_App_User')->result_array();
    }
      function get_all_parent_app_user_signedup($limit=null,$offset=NULL)
    {
          return $this->db->query("SELECT * FROM Parent_App_User AS s JOIN Child AS c ON s.parent_app_user_name = c.child_father_email_id where s.`parent_app_user_status`=0 GROUP BY  `parent_app_user_name` LIMIT $offset,$limit")->result_array();
          
//         $this->db->where('parent_app_user_status',0);
//         $this->db->limit($limit, $offset);
//        return $this->db->get('Parent_App_User')->result_array();
    }
    /*
     * function to add new parent_app_user
     */
    function add_parent_app_user($params)
    {
        $this->db->insert('Parent_App_User',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update parent_app_user
     */
    function update_parent_app_user($parent_app_user_id,$params)
    {
        $this->db->where('parent_app_user_id',$parent_app_user_id);
        $response = $this->db->update('Parent_App_User',$params);
        if($response)
        {
            return "parent_app_user updated successfully";
        }
        else
        {
            return "Error occuring while updating parent_app_user";
        }
    }
    
    /*
     * function to delete parent_app_user
     */
    function delete_parent_app_user($parent_app_user_id)
    {
        $response = $this->db->delete('Parent_App_User',array('parent_app_user_id'=>$parent_app_user_id));
        if($response)
        {
            return "parent_app_user deleted successfully";
        }
        else
        {
            return "Error occuring while deleting parent_app_user";
        }
    }
    
            /*
     * Get parent_app_user by parent_app_user_name and parent_app_user_password 
     */
    function get_parent_app_user_by_username_pass($parent_app_user_name,$parent_app_user_password)
    {
        return $this->db->get_where('Parent_App_User',array('parent_app_user_name'=>$parent_app_user_name,'parent_app_user_password'=>$parent_app_user_password,'parent_app_user_status'=>'0'))->row_array();
    }
    
    
        /*
     * Get parent_app_user by parent_app_user_id
     */
    function check_parent_email($email)
    {
        $response = $this->db->get_where('Parent_App_User',array('parent_app_user_name'=>$email))->row_array();
        if($response)
        {
            return $response['parent_app_user_id'];
        }
        else
        {
            return "";
        }
    }
    
        function is_user_name($parent_app_user_name,$parent_app_user_password)
    {
        return $this->db->get_where('Parent_App_User',array('parent_app_user_name'=>$parent_app_user_name,'parent_app_user_password'=>$parent_app_user_password,'parent_app_user_status'=>'1'))->row_array();
    }
    
    
      function is_user_name_present($parent_app_user_name)
     {
          return $this->db->get_where('Parent_App_User',array('parent_app_user_name'=>$parent_app_user_name))->row_array();
     }
    
     
     
        function is_user_name_present_active($parent_app_user_name)
     {
          return $this->db->get_where('Parent_App_User',array('parent_app_user_name'=>$parent_app_user_name))->row_array();
     }
    

    
          function is_user_name_present_active_pass($parent_app_user_name,$parent_app_user_password)
    {
        return $this->db->get_where('Parent_App_User',array('parent_app_user_name'=>$parent_app_user_name,'parent_app_user_password'=>$parent_app_user_password,'parent_app_user_status'=>'0'))->row_array();
    }
     
    
    
         function is_pin_number($parent_app_user_name,$parent_app_user_password,$pin_number)
    {
        return $this->db->get_where('Parent_App_User',array('parent_app_user_name'=>$parent_app_user_name,'parent_app_user_password'=>$parent_app_user_password,'pin_number'=>$pin_number))->row_array();
        
    }   
       function change_status($id,$params)
    {
        $this->db->where('parent_app_user_id',$id);
        $response = $this->db->update('Parent_App_User',$params);
     }  
    function update_password($id,$params)
    {
        $this->db->where('parent_app_user_id',$id);
        return $this->db->update('Parent_App_User',$params);
     } 
     
        function forgot_password($username)
    {
        return $this->db->get_where('Parent_App_User',array('parent_app_user_name'=>$username))->row_array();
    }
    
          function truncate_Parent_app_user() {
        $response = $this->db->truncate('Parent_App_User');
        if ($response) {
            return "Parent App User deleted successfully";
        } else {
            return "Error occuring while deleting Parent App User";
        }
    }
    
       
         /*
     * function to status trip
     */
    function status_parent($parent_id,$status)
    {  
        $this->db->set('parent_app_user_status', $status, FALSE);
       $this->db->where('parent_app_user_id',$parent_id);
       $response = $this->db->update('Parent_App_User');
        if($response)
        {
            return "Parent Status updated successfully";
        }
        else
        {
            return "Error occuring while updating Parent Status";
        }
    }
    
     function search($email,$value)
    {
          return $this->db->query("SELECT pf.parent_app_user_id,pf.parent_app_user_name, pf.parent_app_user_password,pf.parent_app_user_status, f.child_father_name,
 f.child_father_tel,f.child_father_email_id FROM Parent_App_User AS pf 
 left JOIN Parent_child_mapping AS p ON pf.parent_app_user_id = p. parent_id
  left JOIN Child AS f ON p.child_id = f.child_id where pf.parent_app_user_name LIKE '%$email%' and pf.parent_app_user_status='$value' group by pf.parent_app_user_id")->result_array();
          
          
          
//          return $this->db->query("SELECT * FROM Parent_App_User AS s JOIN Child AS c ON s.parent_app_user_name ="
//                  . "c.child_father_email_id where s.`parent_app_user_name`='$email' and s.`parent_app_user_status`='$value'")->result_array();
          
//         $this->db->where('parent_app_user_status',0);
//         $this->db->limit($limit, $offset);
//        return $this->db->get('Parent_App_User')->result_array();
    }
    
     
         function is_usename_and_password($parent_app_user_name,$parent_app_user_password)
    {
        return $this->db->get_where('Parent_App_User',array('parent_app_user_name'=>$parent_app_user_name,'parent_app_user_password'=>$parent_app_user_password))->row_array();
        
    } 
    
    function update_password_using_usename($username,$params)
    {
        $this->db->where('parent_app_user_name',$username);
        return $this->db->update('Parent_App_User',$params);
     } 
    function get_signedup_or_not($child_id) {
           $child= $this->db->query("SELECT * FROM Parent_child_mapping,Parent_App_User WHERE  Parent_child_mapping.parent_id =Parent_App_User.	parent_app_user_id AND Parent_child_mapping.child_id='$child_id'")->row_array();
           return $child['parent_app_user_status'];
    } 
}
