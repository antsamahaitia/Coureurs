<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ResetDatabase extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Charger le modèle si nécessaire
         $this->load->model('User_Model');
    }

    public function reset_database() {
        // Obtenez la liste de toutes les tables
        $tables = $this->db->list_tables();

        foreach ($tables as $table) {
            // Si la table est 'users', supprimez uniquement les utilisateurs qui ne sont pas des administrateurs
            if ($table == 'users') {
                $this->db->where('role !=', 'admin');
                $this->db->delete($table);
            } else {
                // Pour toutes les autres tables, videz le contenu de la table
                $this->db->truncate($table);
            }
        }

        // Afficher un message de succès ou de redirection
        echo "La base de données a été réinitialisée avec succès !";
    }

}
