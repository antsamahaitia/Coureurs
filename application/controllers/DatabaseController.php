<?php
class DatabaseController extends CI_Controller {

    public function reset_database() {
        // Vérifiez si l'utilisateur est un administrateur
        if ($this->session->userdata('role') != 'admin') {
            show_error('Vous devez être un administrateur pour effectuer cette action.');
            return;
        }

        // Chargez le modèle
        $this->load->model('User_model');

        // Réinitialisez la base de données
        $this->User_model->reset_database();

        // Redirigez vers la page d'accueil ou une page de succès
        redirect('/Admin_home');
    }
}
?>
