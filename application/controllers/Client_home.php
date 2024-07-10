<?php
class Client_home extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Client_model');
        date_default_timezone_set('UTC');
    }

    public function index() {
        $this->load->view('client_view');
    }
    
    public function loyer() {
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');

        if (empty($start_date) || empty($end_date)) {
            $start_date = date('Y-01-01');
            $end_date = date('Y-12-31');
        } else {
            $start_date = date('Y-m-d', strtotime($start_date));
            $end_date = date('Y-m-d', strtotime($end_date));
        }

        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['rent_data'] = $this->Client_model->get_rent($this->session->userdata('id'), $start_date, $end_date);
        $this->load->view('client_loyer', $data);
    }
}
?>
