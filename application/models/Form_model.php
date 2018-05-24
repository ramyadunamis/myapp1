<?php
/**
 * Description of Form
 *
 * @author anoop
 */
class Form_model  extends CI_Model {
    
    public function __construct()
        {
                parent::__construct();
        }
        public function add_form_data($data){
            // Inserting in Table(checking_form) of Database(qttool_db)
            //print_r($data);
           // $retrun_data=FALSE;
            $data['BDPercentage']=  $this->Basic_Demographics_Percentage($data);
            $data['CSPercentage']=$this->Client_Specific_Percentage($data);
            $data['RInformation']=$this->Rejection_Information($data);
            $data['total_score']=$this->Total_score($data);
            $data['ErrorsCount']=$this->ErrorsCount($data);
            $data['ErrorPercentage']=$this->ErrorPercentage($data);
            //$data['QSPercentage']='';
            
            $this->db->insert('checking_form', $data);  
            return $this->db->insert_id();
        }
      
        public function delete_form_data($param) {
            
        }
        // Function to remove all null form array
        protected function remove_null_from_data($data_array) {
            return array_filter($data_array,"strlen");
            
        }
        //find Basic_Demographics_Percentage
       
        protected function Basic_Demographics_Percentage($data) {
            
            $data_array[]=$data['respondent_difference'];
            $data_array[]=$data['age_difference'];
            $data_array[]=$data['vationality_difference'];
            $data_array[]=$data['gender_difference'];
            $data_array[]=$data['city_difference'];
            $data_array[]=$data['loI_difference'];          
            $data_array=  $this->remove_null_from_data($data_array);
            return round(((array_sum($data_array)/count($data_array))*100));
                    
        }
        //find Basic_Demographics_count diffence
        public function count_Basic_Demographics_Diffrence($data) {
             $data_array[]=$data['respondent_difference'];
            $data_array[]=$data['age_difference'];
            $data_array[]=$data['vationality_difference'];
            $data_array[]=$data['gender_difference'];
            $data_array[]=$data['city_difference'];
            $data_array[]=$data['loI_difference'];          
            $data_array=  $this->remove_null_from_data($data_array);
            return count($data_array);
        }
        //find Client_Specific_Percentage
        protected function Client_Specific_Percentage($data) {
            
            $data_array[]=$data['q1_difference'];
            $data_array[]=$data['q2_difference'];
            $data_array[]=$data['q3_difference'];
            $data_array=  $this->remove_null_from_data($data_array);
            return round(((array_sum($data_array)/count($data_array))*100));
        }
        public function count_Client_Specific_Difference($data) {
            
            $data_array[]=$data['q1_difference'];
            $data_array[]=$data['q2_difference'];
            $data_array[]=$data['q3_difference'];
            $data_array=  $this->remove_null_from_data($data_array);
            return count($data_array);
        }
        // find REJECTION INFORMATION
        
        protected function Rejection_Information($data) {
            $data_array[]=$data['q1_status'];
            $data_array[]=$data['q2_status'];
            $data_array[]=$data['q3_status'];
            $data_array[]=$data['q4_status'];
            $data_array[]=$data['q5_status'];
            $data_array[]=$data['q6_status'];
            $data_array[]=$data['q7_status'];
            $data_array[]=$data['q8_status'];
            $data_array[]=$data['q9_status'];
            //$data_array=  $this->remove_null_from_data($data_array);
            $result=1;
            foreach ($data_array as $key => $value) {
                if($value)
              $result  *=$value;
                else
                   $result  =0;  
            }
            return $result;
        }
        // Find Total score     
        protected function Total_score($data) {
            return round((($data['BDPercentage']+$data['CSPercentage'])/2)*$data['RInformation']);
        }
        // Remove all 1 value from array
        protected function remove_zero_from_data($data_array) {
            return array_filter($data_array);
            
        }        
        // Find ErrorsCount
        protected function ErrorsCount($data) {
            $data_array[]=$data['respondent_difference'];
            $data_array[]=$data['age_difference'];
            $data_array[]=$data['vationality_difference'];
            $data_array[]=$data['gender_difference'];
            $data_array[]=$data['city_difference'];
            $data_array[]=$data['loI_difference']; 
            $data_array[]=$data['q1_difference'];
            $data_array[]=$data['q2_difference'];
            $data_array[]=$data['q3_difference'];
            $count_all=  count($data_array);
            $data_array=  $this->remove_null_from_data($data_array);           
            $data_array=  $this->remove_zero_from_data($data_array);
            $count_ones=count($data_array);
            return $count_all-$count_ones;
            
        }
        // Find ErrorPercentage
        
        protected function ErrorPercentage($data) {
            
            return round((($data['ErrorsCount']/9)*100));
        }
        
          public function list_form_data() {
             $query = $this->db->get('checking_form');  
         return $query;  
        }
         public function get_form_data($id='') {
             if($id=='')
            $id =  $this->uri->segment(3);
            $this->db->where('id',$id);
            $query = $this->db->get('checking_form');
            return $query; 
        }
        
        public function edit_form_data($data,$id)
         {
            $data['BDPercentage']=  $this->Basic_Demographics_Percentage($data);
            $data['CSPercentage']=$this->Client_Specific_Percentage($data);
            $data['RInformation']=$this->Rejection_Information($data);
            $data['total_score']=$this->Total_score($data);
            $data['ErrorsCount']=$this->ErrorsCount($data);
            $data['ErrorPercentage']=$this->ErrorPercentage($data);   
         $this->db->where('id', $id);
         $query = $this->db->update('checking_form', $data);
        }
}
