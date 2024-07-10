<?php
class Admin_model extends CI_Model {
    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_revenue($start_date, $end_date) {
        $this->db->query("SET @start_date = ?", array($start_date));
        $this->db->query("SET @end_date = ?", array($end_date));
    
        // Generate the months range dynamically
        $this->db->select("
            months.month,
            COALESCE(SUM(
                CASE
                    WHEN ld.rang = 1 THEN ld.loyer*2 -- Commission égale au loyer complet le premier mois
                    ELSE ld.loyer*ld.commission/100  -- Commission normale les mois suivants
                END
            ), 0) AS total_commission,
            COALESCE(SUM(
                CASE
                    WHEN ld.rang = 1 THEN ld.loyer
                    
                    
                    
                    *-- Loyer complet enregistré pour le premier mois
                    ELSE ld.loyer  -- Loyer réduit de la commission pour les mois suivants
                END
            ), 0) AS total_rent
        ")
        ->from("(
            SELECT DATE_FORMAT(date_range, '%Y-%m') AS month
            FROM (
                SELECT @start_date + INTERVAL (a.a + (10 * b.a) + (100 * c.a)) MONTH AS date_range
                FROM (SELECT 0 as a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) a
                CROSS JOIN (SELECT 0 as a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) b
                CROSS JOIN (SELECT 0 as a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) c
            ) months_range
            WHERE date_range <= @end_date
        ) months")
        ->join('locations_details ld', 'months.month = DATE_FORMAT(ld.date_debut, \'%Y-%m\')', 'left')
        ->join('Bien b', 'ld.bien_id = b.idBien', 'left')
        ->where('ld.date_debut >=', $start_date)
        ->where('ld.date_debut <=', $end_date)
        ->group_by('months.month')
        ->order_by('months.month');
    
        $query = $this->db->get();
    
        if ($query === FALSE) {
            $error = $this->db->error();
            log_message('error', 'Database error: ' . $error['message']);
            return array();
        }
    
        return $query->result_array();
    }
    
    // 
    public function get_all_properties() {
        $query = $this->db->get('Bien');
        return $query->result_array();
    }

    public function add_property($data) {
        return $this->db->insert('Bien', $data);
    }

    public function get_property_types() {
        $query = $this->db->get('typeBien');
        return $query->result_array();
    }

    public function get_owners() {
        $this->db->where('role', 'proprietaire');
        $query = $this->db->get('users');
        return $query->result_array();
    }

    // location rajout
    public function add_location($data) {
        return $this->db->insert('locations', $data);
    }

    public function get_all_locations() {
        $this->db->select('locations.*, Bien.nom as bien_nom, users.username as client_nom');
        $this->db->from('locations');
        $this->db->join('Bien', 'Bien.idBien = locations.bien_id');
        $this->db->join('users', 'users.id = locations.client_id');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_available_properties() {
        $this->db->select('Bien.*, typeBien.nom as type_nom');
        $this->db->from('Bien');
        $this->db->join('typeBien', 'typeBien.idTypeBien = Bien.idTypeBien');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_clients() {
        $this->db->where('role', 'client');
        $query = $this->db->get('users');
        return $query->result_array();
    }

    public function locations() {
        $data['locations'] = $this->Admin_model->get_all_locations();
        $data['biens'] = $this->Admin_model->get_available_properties();
        $data['clients'] = $this->Admin_model->get_clients();
        
        $this->load->view('admin_locations', $data);
    }
    
    public function is_date_available($bien_id, $date_debut) {
        $this->db->select('1')
                 ->from('locations')
                 ->where('bien_id', $bien_id)
                 ->where('date_debut <=', $date_debut)
                 ->where('DATE_ADD(date_debut, INTERVAL duree_mois MONTH) >', $date_debut);
        
        $query = $this->db->get();
        return $query->num_rows() === 0;
    }
// rajout dans details locations
public function inserer_details($data)
{
    $this->db->insert('locations_details', $data);
}

public function get_locations_sans_details()
{
    // Building the query
    $this->db->select('l.*')
             ->from('locations l')
             ->where('NOT EXISTS (SELECT 1 FROM locations_details ld WHERE ld.location_id = l.id)', NULL, FALSE);
             
    // Executing the query
    $query = $this->db->get();
    
    // Check if the query executed successfully
    if (!$query) {
        // Log the error message
        $error = $this->db->error();
        log_message('error', 'Query error: ' . $error['message']);
        
        // Return an empty array or handle the error as needed
        return [];
    }
    
    // Return the result set as an array
    return $query->result_array();
}


public function get_by_id($id)
{
    $query = $this->db->select('b.*, tb.commission')
                      ->from('Bien b')
                      ->join('typeBien tb', 'b.idTypeBien = tb.idTypeBien')
                      ->where('b.idBien', $id)
                      ->get();
    return $query->row_array();
}
}

