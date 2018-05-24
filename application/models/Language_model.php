<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class Language_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get language by lang_id
     */
    function get_language($lang_id)
    {
        return $this->db->get_where('Languages',array('lang_id'=>$lang_id))->row_array();
    }
        
    /*
     * Get all languages
     */
    function get_all_languages()
    {
        $this->db->order_by('lang_id', 'asc');
        return $this->db->get('Languages')->result_array();
    }
        
    /*
     * function to add new language
     */
    function add_language($params)
    {
        $this->db->insert('Languages',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update language
     */
    function update_language($lang_id,$params)
    {
        $this->db->where('lang_id',$lang_id);
        return $this->db->update('Languages',$params);
    }
    
    /*
     * function to delete language
     */
    function delete_language($lang_id)
    {
        return $this->db->delete('Languages',array('lang_id'=>$lang_id));
    }
    
      function get_country()
    {
        $this->db->order_by('id_countries', 'ASC');
        return $this->db->get('Countries')->result_array();
    }
       
     function get_language_details($lang_name)
    {
        return $this->db->get_where('Languages',array('lang_name'=>$lang_name))->row_array();
    }
}
