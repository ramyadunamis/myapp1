<?php
/**
 * Description of Form
 *
 * @author anoop
 */
class Form_list  extends CI_Model {
    
    public function __construct()
        {
                parent::__construct();
        }
        public function add_form_data($data){
           // Inserting in Table(checking_form) of Database(qttool_db)
            $this->db->insert('checking_form', $data); 
        }
        public function edit_form_data($param) {
            
        }
        public function get_form_data($id='') {
            
        }
        public function delete_form_data($param) {
            
        }
}
