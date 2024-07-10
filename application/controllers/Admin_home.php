<?php
class Admin_home extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('Admin_model');
        $this->load->library('form_validation');
        date_default_timezone_set('UTC');

        if(!$this->session->userdata('username')) {
            redirect('login');
        }
    }

    public function index() {
        $this->load->view('admin_view');
    }
       public function location() {
        $data['locations'] = $this->Admin_model->get_all_locations();
        $data['biens'] = $this->Admin_model->get_available_properties();
        $data['clients'] = $this->Admin_model->get_clients();
        
        $this->load->view('admin_locations', $data);
    }
   
   

    public function manage_properties() {
        $data['proprietes'] = $this->Admin_model->get_all_properties();
        $data['types_biens'] = $this->Admin_model->get_property_types();
        $data['proprietaires'] = $this->Admin_model->get_owners();
        
        $this->load->view('admin_proprietes', $data);
    }

    public function ajouter_propriete() {
        if ($this->input->post()) {
            $data = array(
                'reference' => $this->input->post('reference'),
                'idTypeBien' => $this->input->post('idTypeBien'),
                'nom' => $this->input->post('nom'),
                'region' => $this->input->post('region'),
                'loyerparmois' => $this->input->post('loyerparmois'),
                'idProprietaire' => $this->input->post('idProprietaire')
            );

            if ($this->Admin_model->add_property($data)) {
                redirect('admin_view');
            } else {
                // Gérer l'erreur
                echo "Erreur lors de l'ajout de la propriété";
            }
        } else {
            redirect('admin_view');
        }
    }
// gains et chiffre affaire
    public function filter_revenue() {
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
        $data['revenue_data'] = $this->Admin_model->get_revenue($start_date, $end_date);
        
        $data['total_rent'] = array_sum(array_column($data['revenue_data'], 'total_rent'));
        $data['total_commission'] = array_sum(array_column($data['revenue_data'], 'total_commission'));
        
        $this->load->view('admin_chiffre_affaire', $data);
    }

// ajouter location
public function ajouter_location() {
    if ($this->input->post()) {
        $bien_id = $this->input->post('bien_id');
        $client_id = $this->input->post('client_id');
        $duree_mois = $this->input->post('duree_mois');
        $date_debut = $this->input->post('date_debut');
        
        // Check if the selected date is available
        if ($this->Admin_model->is_date_available($bien_id, $date_debut)) {
            $data = array(
                'bien_id' => $bien_id,
                'client_id' => $client_id,
                'duree_mois' => $duree_mois,
                'date_debut' => $date_debut
            );

            if ($this->Admin_model->add_location($data)) {
                $this->load->view('admin_view');
            } else {
                echo "Erreur lors de l'ajout de la location";
            }
        } else {
            echo "Erreur: La date sélectionnée n'est pas disponible. Veuillez sélectionner une autre date.";
        }
    } else {
        $this->load->view('admin_view');
    }
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
    

    public function get_availability_date($bien_id) {
        $date_disponibilite = $this->Admin_model->get_availability_date($bien_id);
        echo json_encode(['date_disponibilite' => date('d-m-Y', strtotime($date_disponibilite))]);
    }
    
    public function ajouter_details()
    {
        // Retrieve all locations without details
        $locations = $this->Admin_model->get_locations_sans_details();
    
        foreach ($locations as $location) {
            // Retrieve property information
            $bien = $this->Admin_model->get_by_id($location['bien_id']);
    
            // Calculate the end date for the rental
            $date_debut_obj = new DateTime($location['date_debut']);
            $date_fin_obj = clone $date_debut_obj;
            $date_fin_obj->modify('+' . $location['duree_mois'] . ' months')->modify('last day of previous month');
    
            // For each month of the rental
            for ($rang = 1; $rang <= $location['duree_mois']; $rang++) {
                // Calculate the start date for this month
                $date_debut = date('Y-m-d', strtotime($location['date_debut'] . ' + ' . ($rang - 1) . ' months'));
                // The end date remains the same for all entries
                $date_fin = $date_fin_obj->format('Y-m-d');
    
                // Insert into the locations_details table
                $this->Admin_model->inserer_details([
                    'bien_id' => $location['bien_id'],
                    'location_id' => $location['id'],
                    'loyer' => $bien['loyerparmois'],
                    'commission' => $bien['commission'], // Insert the commission directly
                    'date_debut' => $date_debut,
                    'date_fin' => $date_fin,
                    'rang' => $rang,
                    'duree' => $location['duree_mois'] // Total duration in months for all entries
                ]);
            }
        }
    
        $this->load->view('admin_view'); // Redirect to the list of locations
    }
    

}
?>
