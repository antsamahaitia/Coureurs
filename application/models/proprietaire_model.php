<?php
class Proprietaire_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function get_properties($owner_id) {
        $this->db->select('b.*, tb.nom as type_nom, GROUP_CONCAT(pb.chemin) as image_paths, 
                           COALESCE(MAX(ld.date_fin), CURDATE()) as date_disponibilite')
                 ->from('Bien b')
                 ->join('typeBien tb', 'b.idTypeBien = tb.idTypeBien')
                 ->join('photoBien pb', 'b.idBien = pb.idBien', 'left')
                 ->join('locations l', 'b.idBien = l.bien_id', 'left')
                 ->join('locations_details ld', 'l.id = ld.location_id', 'left')
                 ->where('b.idProprietaire', $owner_id)
                 ->group_by('b.idBien');
        
        $query = $this->db->get();
        
        if (!$query) {
            echo $this->db->error()['message'];
            return FALSE;
        }
        
        return $query->result_array();
    }
    

    public function get_revenue($start_date, $end_date, $owner_id) {
        $this->db->query("SET @start_date = ?", array($start_date));
        $this->db->query("SET @end_date = ?", array($end_date));
    
        $this->db->select("
            months.month,
            COALESCE(SUM(
                CASE
                    WHEN ld.rang = 1 THEN ld.loyer*2  -- Commission égale au loyer complet le premier mois
                    ELSE ld.loyer*ld.commission/100  -- Commission normale les mois suivants
                END
            ), 0) AS total_commission,
            COALESCE(SUM(
                CASE
                    WHEN ld.rang = 1 THEN ld.loyer  -- Loyer complet enregistré pour le premier mois
                    ELSE ld.loyer - (ld.loyer*ld.commission/100)  -- Loyer réduit de la commission pour les mois suivants
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
        ->where('b.idProprietaire', $owner_id)
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
}
?>
