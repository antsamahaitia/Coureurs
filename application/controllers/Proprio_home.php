<?php
class Proprio_home extends CI_Controller
{

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('proprietaire_model');
        date_default_timezone_set('UTC');
    }
    

    public function index() {
        $this->load->view('proprietaire_view');
    }

    public function biens() {
        $data['properties'] = $this->proprietaire_model->get_properties($this->session->userdata('id'));
        $this->load->view('proprio_biens', $data);
    }


    public function chiffreaffaires() {
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
        $owner = $this->session->userdata('id');
        $data['revenue_data'] = $this->proprietaire_model->get_revenue($start_date, $end_date,$owner);
        
        $data['total_rent'] = array_sum(array_column($data['revenue_data'], 'total_rent'));
        $data['total_commission'] = array_sum(array_column($data['revenue_data'], 'total_commission'));
        
        $this->load->view('proprio_chiffreaffaires', $data);
    }
    
    
    

}
?>






