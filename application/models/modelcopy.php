<?php
class Acoppiiii extends CI_Model {
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function get_revenue($start_date, $end_date) {
        $this->db->select("
            DATE_FORMAT(locations.date_debut, '%Y-%m') AS month,
            SUM(
                CASE
                    WHEN DATEDIFF(LAST_DAY(locations.date_debut), locations.date_debut) >= 0
                    THEN b.loyerparmois
                    ELSE 0
                END +
                CASE
                    WHEN DATEDIFF(LEAST(DATE_ADD(locations.date_debut, INTERVAL locations.duree_mois MONTH), '$end_date'), DATE_ADD(locations.date_debut, INTERVAL 1 MONTH)) > 0
                    THEN b.loyerparmois * (locations.duree_mois - 1)
                    ELSE 0
                END
            ) AS total_rent,
            SUM(
                CASE
                    WHEN DATEDIFF(LEAST(DATE_ADD(locations.date_debut, INTERVAL locations.duree_mois MONTH), '$end_date'), DATE_ADD(locations.date_debut, INTERVAL 1 MONTH)) > 0
                    THEN b.loyerparmois + (b.loyerparmois * (locations.duree_mois - 1) * (tb.commission / 100))
                    ELSE 0
                END
            ) AS total_commission
        ")
        ->from('locations')
        ->join('Bien b', 'locations.bien_id = b.idBien')
        ->join('typeBien tb', 'b.idTypeBien = tb.idTypeBien', 'left')
        ->where('locations.date_debut <=', $end_date)
        ->where('DATE_ADD(locations.date_debut, INTERVAL locations.duree_mois MONTH) >=', $start_date)
        ->group_by('month');
        
        $query = $this->db->get();
        
        if ($query === FALSE) {
            $error = $this->db->error();
            log_message('error', 'Database error: ' . $error['message']);
            return array();
        }
        
        return $query->result_array();
    }
}


<?php
class Admin_model1 extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_revenue($start_date, $end_date) {
        $this->db->select("DATE_FORMAT(locations.date_debut, '%Y-%m') AS month, 
                           SUM(b.loyerparmois * TIMESTAMPDIFF(MONTH, locations.date_debut, LEAST(locations.date_debut + INTERVAL locations.duree_mois MONTH, '$end_date') + INTERVAL 1 MONTH)) AS total_rent,
                           SUM(b.loyerparmois * TIMESTAMPDIFF(MONTH, locations.date_debut, LEAST(locations.date_debut + INTERVAL locations.duree_mois MONTH, '$end_date') + INTERVAL 1 MONTH) * (tb.commission / 100)) AS total_commission")
                 ->from('locations')
                 ->join('Bien b', 'locations.bien_id = b.idBien')
                 ->join('typeBien tb', 'b.idTypeBien = tb.idTypeBien', 'left')
                 ->where('locations.date_debut >=', $start_date)
                 ->where('locations.date_debut <=', $end_date)
                 ->group_by('month');

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

//proprio miala anle loyer premier mois
public function get_revenue($start_date, $end_date, $owner_id) {
    $this->db->query("SET @start_date = ?", array($start_date));
    $this->db->query("SET @end_date = ?", array($end_date));
    
    $this->db->select("
        months.month,
        COALESCE(SUM(
            CASE
                WHEN months.month >= DATE_FORMAT(locations.date_debut, '%Y-%m')
                AND months.month < DATE_FORMAT(DATE_ADD(locations.date_debut, INTERVAL locations.duree_mois MONTH), '%Y-%m')
                THEN
                    CASE
                        WHEN months.month = DATE_FORMAT(locations.date_debut, '%Y-%m')
                        THEN b.loyerparmois  -- Commission égale au loyer complet le premier mois
                        ELSE b.loyerparmois * (tb.commission / 100)  -- Commission normale les mois suivants
                    END
                ELSE 0
            END
        ), 0) AS total_commission,
        COALESCE(SUM(
            CASE
                WHEN months.month >= DATE_FORMAT(locations.date_debut, '%Y-%m')
                AND months.month < DATE_FORMAT(DATE_ADD(locations.date_debut, INTERVAL locations.duree_mois MONTH), '%Y-%m')
                THEN
                    CASE
                        WHEN months.month = DATE_FORMAT(locations.date_debut, '%Y-%m')
                        THEN 0  -- Pas de loyer pour le propriétaire le premier mois
                        ELSE b.loyerparmois * (1 - tb.commission / 100)  -- Loyer réduit les mois suivants
                    END
                ELSE 0
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
    ->join('locations', 'months.month < DATE_ADD(locations.date_debut, INTERVAL locations.duree_mois MONTH)
                          AND months.month >= DATE_FORMAT(locations.date_debut, \'%Y-%m\')', 'left')
    ->join('Bien b', 'locations.bien_id = b.idBien', 'left')
    ->join('typeBien tb', 'b.idTypeBien = tb.idTypeBien', 'left')
    ->where('locations.date_debut <=', $end_date)
    ->where('DATE_ADD(locations.date_debut, INTERVAL locations.duree_mois MONTH) >', $start_date)
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