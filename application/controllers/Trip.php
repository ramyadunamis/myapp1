<?php

/*
 * Generated by CRUDigniter v2.3 Beta 
 * www.crudigniter.com
 */

class Trip extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Trip_model');
        $this->load->model('User_model');
        $this->load->model('Bu_model');
        $this->load->model('Setting_model');
        if (!$this->User_model->auth_session()) {
            redirect('Login');
        }
    }

    /*
     * Listing of trip
     */

    function index() {

        $data['page_title'] = 'Trip';
        $data['trip'] = $this->Trip_model->get_all_trip();
        // echo $this->db->last_query(); 
        $this->load->view('trip/index', $data);
    }

    /*
     * Adding a new trip
     */

    function add() {
        $data['page_title'] = 'Trip Adding';
        $data['bus'] = $this->Bu_model->get_all_bus();
        $this->load->library('form_validation');
        if ($this->input->post('submit') == 'Cancel') {
            redirect('trip/index');
        }

        $this->form_validation->set_rules('trip_title', 'Trip Title', 'required');
        $this->form_validation->set_rules('trip_no', 'Trip No', 'required');
        $this->form_validation->set_rules('bus', 'Bus name', 'required');
        $this->form_validation->set_rules('type', 'Type', 'required');
        //$this->form_validation->set_rules('time','Time','required');
        $this->form_validation->set_rules('is_stayback', 'Stay back', 'required');
        $this->form_validation->set_rules('trip_desc', 'Trip Description', 'required');
        $this->form_validation->set_rules('push_noti', 'Push Notification', 'required');

        if ($this->form_validation->run()) {

            $time = $this->input->post('time');
            if (!empty($time)) {
                foreach ($time as $check) {
                    $insert1[] = '{' . $check . '}';
                }
                $insert = implode("", $insert1);
            } else {
                $insert = "";
            }



            $params = array(
                'trip_title' => $this->input->post('trip_title'),
                'trip_no' => $this->input->post('trip_no'),
                'trip_desc' => $this->input->post('trip_desc'),
                'trip_bus_id' => $this->input->post('bus'),
                'trip_type' => $this->input->post('type'),
                'time' => $insert,
                'is_stayback' => $this->input->post('is_stayback'),
                'push_notification' => $this->input->post('push_noti'),
            );


            $trip_id = $this->Trip_model->add_trip($params);
            redirect('trip/index');
        } else {
            $this->load->view('trip/add', $data);
        }
    }

    /*
     * Editing a trip
     */

    function edit($trip_id) {
        $data['page_title'] = 'Trip Editing';
        // check if the trip exists before trying to edit it
        $trip = $this->Trip_model->get_trip($trip_id);
        $data['bus'] = $this->Bu_model->get_all_bus();
        if (isset($trip['trip_id'])) {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('trip_title', 'Trip Title', 'required');
            $this->form_validation->set_rules('trip_no', 'Trip No', 'required');
            $this->form_validation->set_rules('bus', 'Bus name', 'required');
            $this->form_validation->set_rules('type', 'Type', 'required');
            //$this->form_validation->set_rules('time','Time','required');
            $this->form_validation->set_rules('is_stayback', 'Stay back', 'required');
            $this->form_validation->set_rules('trip_desc', 'Trip Description', 'required');
             $this->form_validation->set_rules('push_noti', 'Push Notification', 'required');

            if ($this->form_validation->run()) {

                $time = $this->input->post('time');
                if (!empty($time)) {
                    foreach ($time as $check) {
                        $insert1[] = '{' . $check . '}';
                    }
                    $insert = implode("", $insert1);
                } else {
                    $insert = "";
                }

                $params = array(
                    'trip_title' => $this->input->post('trip_title'),
                    'trip_no' => $this->input->post('trip_no'),
                    'trip_desc' => $this->input->post('trip_desc'),
                    'trip_bus_id' => $this->input->post('bus'),
                    'trip_type' => $this->input->post('type'),
                    'time' => $insert,
                    'is_stayback' => $this->input->post('is_stayback'),
                    'push_notification' => $this->input->post('push_noti'),
                );

                $this->Trip_model->update_trip($trip_id, $params);
                // echo $this->db->last_query(); exit();
                redirect('trip/index');
            } else {
                $data['trip'] = $this->Trip_model->get_trip($trip_id);

                $this->load->view('trip/edit', $data);
            }
        } else
            show_error('The trip you are trying to edit does not exist.');
    }

    /*
     * Deleting trip
     */

    function remove($trip_id) {
        $data['page_title'] = 'Trip Deleting';
        $trip = $this->Trip_model->get_trip($trip_id);

        // check if the trip exists before trying to delete it
        if (isset($trip['trip_id'])) {
            $this->Trip_model->delete_trip($trip_id);
            redirect('trip/index');
        } else
            show_error('The trip you are trying to delete does not exist.');
    }

    function change_status() {
        $trip_id = $this->uri->segment(3);
        $trip_status = $this->uri->segment(4);
        if ($trip_status == 0) {
            $status = 1;
        } else {
            $status = 0;
        }
        // echo $status;
        // check if the child exists before trying to update it
        if ($trip_id) {
            $this->Trip_model->status_trip($trip_id, $status);
            redirect('trip/index');
        } else
            show_error('The child you are trying to delete does not exist.');
    }

    /*
     * Adding csv
     */

    function add_csv() {
        $data['page_title'] = 'Trip Adding';
        if (isset($_POST['submit'])) {
            if ($_FILES['csv']['tmp_name'] == '') {
                $this->session->set_flashdata('error', 'Please select CSV file');
                redirect('trip/add_csv', $data);
            }
            if (($handle = fopen($_FILES['csv']['tmp_name'], "r")) !== FALSE) {
                fgetcsv($handle);
                $settings = $this->Setting_model->get_all_settings();
                $is_truncate = 'No';
                foreach ($settings as $key => $value) {
                    $is_truncate = $value['truncate'];
                }
                if ($is_truncate == 'Yes') {
                    $truncate = $this->Trip_model->truncate_trip();
                }



                while (($data1 = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $num = count($data1);
                    for ($c = 0; $c < $num; $c++) {
                        $data[$c] = $data1[$c];
                    }
//       print_r($data);
                    $bus_id_pickup = $this->Bu_model->get_bus_id(trim($data['3']));
//       echo $this->db->last_query();
//       exit();
                    $params = array(
                        'trip_title' => trim($data['0']),
                        'trip_no' => trim($data['1']),
                        'trip_desc' => trim($data['2']),
                        'trip_bus_id' => $bus_id_pickup['bus_id'],
                        'trip_type' => trim($data['4']),
                        'time' => trim($data['5']),
                        'is_stayback' => trim($data['6']),
                    );
                    $child_last_id = $this->Trip_model->add_trip($params);
                }
                fclose($handle);
                redirect('trip/index', $data);
            }
        }
        $this->load->view('trip/add_csv', $data);
    }

}
