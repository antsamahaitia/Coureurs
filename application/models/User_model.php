<?php
class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
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
                $this->db->query("TRUNCATE TABLE $table");
            }
        }
    }
}
?>
