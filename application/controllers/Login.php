<?php
class Login extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
    }

    public function index() {
        $this->load->view('login_view');
    }

    public function process() {
        $this->load->model('Login_model');
        $profil = $this->input->post('profil');
        $user = false;

        if ($profil == 'admin') {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $user = $this->Login_model->validate_admin($username, $password);
        } elseif ($profil == 'proprietaire') {
            $tel = $this->input->post('tel');
            $user = $this->Login_model->validate_proprietaire($tel);
        } elseif ($profil == 'client') {
            $email = $this->input->post('email');
            $user = $this->Login_model->validate_client($email);
        }

        if ($user) {
            $this->session->set_userdata('username', $user->username);
            $this->session->set_userdata('role', $user->role);
            $this->session->set_userdata('id', $user->id);

            if ($user->role == 'admin') {
                $this->load->view('admin_view');
            } elseif ($user->role == 'proprietaire') {
                $this->load->view('proprietaire_view');
            } else {
                $this->load->view('client_view');
            }
        } else {
            $this->index();
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('Login/index');
    }
}

?>
