<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Import extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('csvimport');
    }

    public function index()
    {
        $this->load->view('import_view');
    }

    public function import_typebiens()
    {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'csv';
        $config['file_name'] = 'typebiens.csv';
        $config['overwrite'] = true;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('csv_file')) {
            $file_path = './uploads/typebiens.csv';
            $result = $this->csvimport->import_data_typebiens($file_path);

            if ($result) {
                echo "Importation des types de biens réussie.";
            } else {
                echo "Échec de l'importation des types de biens.";
            }
        } else {
            echo $this->upload->display_errors();
        }
    }

    public function import_biens()
    {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'csv';
        $config['file_name'] = 'biens.csv';
        $config['overwrite'] = true;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('csv_file')) {
            $file_path = './uploads/biens.csv';
            $result = $this->csvimport->import_data_biens($file_path);

            if ($result) {
                echo "Importation des biens réussie.";
            } else {
                echo "Échec de l'importation des biens.";
            }
        } else {
            echo $this->upload->display_errors();
        }
    }

    public function import_locations()
    {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'csv';
        $config['file_name'] = 'locations.csv';
        $config['overwrite'] = true;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('csv_file')) {
            $file_path = './uploads/locations.csv';
            $result = $this->csvimport->import_data_locs($file_path);

            if ($result) {
                echo "Importation des locations réussie.";
            } else {
                echo "Échec de l'importation des locations.";
            }
        } else {
            echo $this->upload->display_errors();
        }
    }
}


