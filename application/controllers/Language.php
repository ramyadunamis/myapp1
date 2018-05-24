<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class Language extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Language_model');
    } 

    /*
     * Listing of languages
     */
    function index()
    {
         $data['page_title'] = 'Language';
        $data['languages'] = $this->Language_model->get_all_languages();
       // echo $this->db->last_query();
       $this->load->view('language/index',$data);
    }

    /*
     * Adding a new language
     */
    function add()
    {   
          $data['page_title'] = 'Language';
          
            $data['country'] = $this->Language_model->get_country();
            //echo $this->db->last_query(); exit();
        $this->load->library('form_validation');

		$this->form_validation->set_rules('lang_country','Country','required');
		$this->form_validation->set_rules('lang_name','Language name in English','required');
		
		if($this->form_validation->run())     
        {   
            $params = array(
				'lang_name' => $this->input->post('lang_name'),
				'lang_native' => $this->input->post('lang_native'),
				'lang_country' => $this->input->post('lang_country'),
				'lang_align_type' => $this->input->post('lang_align_type'),
                                'lang_code' => $this->input->post('lang_code'),
            );
            
            $language_id = $this->Language_model->add_language($params);
            redirect('language/index');
        }
        else
        {            
            $this->load->view('language/add',$data);
        }
    }  

    /*
     * Editing a language
     */
    function edit($lang_id)
    {   
         $data['page_title'] = 'Language';
        // check if the language exists before trying to edit it
        $data['language'] = $this->Language_model->get_language($lang_id);
         $data['country'] = $this->Language_model->get_country();
        
        if(isset($data['language']['lang_id']))
        {
            $this->load->library('form_validation');

			$this->form_validation->set_rules('lang_country','Country','required');
		$this->form_validation->set_rules('lang_name','Language name in English','required');
		
			if($this->form_validation->run())     
            {   
                $params = array(
					'lang_name' => $this->input->post('lang_name'),
					'lang_native' => $this->input->post('lang_native'),
					'lang_country' => $this->input->post('lang_country'),
					'status' => $this->input->post('status'),
					'delete' => $this->input->post('delete'),
					'lang_align_type' => $this->input->post('lang_align_type'),
                                        'lang_code' => $this->input->post('lang_code'),
                );

                $this->Language_model->update_language($lang_id,$params);            
                redirect('language/index');
            }
            else
            {
                 $this->load->view('language/edit',$data);
            }
        }
        else
            show_error('The language you are trying to edit does not exist.');
    } 

    /*
     * Deleting language
     */
    function remove($lang_id)
    {
        $language = $this->Language_model->get_language($lang_id);

        // check if the language exists before trying to delete it
        if(isset($language['lang_id']))
        {
            $this->Language_model->delete_language($lang_id);
            redirect('language/index');
        }
        else
            show_error('The language you are trying to delete does not exist.');
    }
    
}