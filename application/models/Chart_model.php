<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Description of Chart_model
 *
 * @author dunamis
 */
class Chart_model extends CI_Model {
    
    public function __construct()
        {
                parent::__construct();
        }
        public function preocess_data($data) {
            $return_data='';
            $i=0;
            foreach ($data as $key=>$val)   {
                ++$i;
               if(count($data)!=$i) 
               $return_data.= $val.',';
               else
                $return_data.= $val.',';
            }
            return $return_data;
        }
        public function index_data($data) {
              $i=0;
              $return_data='';
            foreach ($data as $key=>$val)   {
                ++$i;
               if(count($data)!=$i) 
               $return_data.= '"'.$i.'",';
               else
                $return_data.= '"'.$i.'"';
            }
            return $return_data; 
        }
        public function preocess_data_Doughnut_or_pie($number) {
            $return_data=$number.','.(100-$number);          
            return $return_data;
        }
        
}


