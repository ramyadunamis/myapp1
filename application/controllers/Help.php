<?php
/* 
 * Generated by CRUDigniter v2.3 Beta 
 * www.crudigniter.com
 */
 
class Help extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        
    } 
     
     /*
     * contact
     */
 public function index()
  {
  $this->load->view("help/help.html");
    }
   public function index_lang1()
  {
  $this->load->view("help/help_arabic_lang1.html");
    }   
}
