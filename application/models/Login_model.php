<?php
class Login_model extends CI_Model {
    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function validate_admin($username, $password) {
        $this->db->where('username', $username);
        $this->db->where('password', $password);
        $this->db->where('role', 'admin');
        $query = $this->db->get('users');

        if ($query && $query->num_rows() == 1) {
            return $query->row();
        } else {
            return false;
        }
    }

    function validate_proprietaire($tel) {
        $this->db->where('phone', $tel);
        $this->db->where('role', 'proprietaire');
        $query = $this->db->get('users');

        if ($query && $query->num_rows() == 1) {
            return $query->row();
        } else {
            return false;
        }
    }

    function validate_client($email) {
        $this->db->where('email', $email);
        $this->db->where('role', 'client');
        $query = $this->db->get('users');

        if ($query && $query->num_rows() == 1) {
            return $query->row();
        } else {
            return false;
        }
    }
}

?>
