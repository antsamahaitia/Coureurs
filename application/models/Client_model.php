<?php
class Client_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
        date_default_timezone_set('UTC');
    }

    public function get_rent($client_id, $start_date, $end_date) {
        $first_of_current_month = date('Y-m-01');
        
        $query = $this->db->query("
            SELECT 
                b.nom AS property_name,
                DATE_FORMAT(ld.date_debut, '%Y-%m-01') AS datepaiement,
                CASE
                    WHEN ld.rang = 1 THEN ld.loyer * 2
                    ELSE ld.loyer
                END AS montant,
                CASE
                    WHEN DATE_FORMAT(ld.date_debut, '%Y-%m-01') <= '$first_of_current_month' THEN 'paid'
                    ELSE 'unpaid'
                END AS status
            FROM 
                locations_details ld
            JOIN
                locations l ON ld.location_id = l.id
            JOIN
                Bien b ON ld.bien_id = b.idBien
            WHERE 
                l.client_id = $client_id
                AND ld.date_debut BETWEEN '$start_date' AND '$end_date'
            ORDER BY ld.date_debut
        ");
        
        if (!$query) {
            $error = $this->db->error();
            log_message('error', 'Erreur de requête : ' . print_r($error, true));
            return [];
        }
        
        return $query->result_array();
    }
}
?>