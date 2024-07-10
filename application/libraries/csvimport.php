<?php
defined('BASEPATH') or exit('No direct script access allowed');

class csvimport
{
    protected $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->database();
        date_default_timezone_set('UTC');
    }

    public function import_data_typebiens($file_path_typebiens)
    {
        if (!file_exists($file_path_typebiens)) {
            return false;
        }

        $file_content = file_get_contents($file_path_typebiens);

        if (empty($file_content)) {
            return false;
        }

        $csv_lines = explode(PHP_EOL, $file_content);

        for ($i = 1; $i < count($csv_lines); $i++) {
            $line = $csv_lines[$i];

            if (!empty($line)) {
                $csv_values = str_getcsv($line);

                // Remplacer la virgule par un point et convertir en float
                $commission = str_replace('%', '', $csv_values[1]);
                $commission = str_replace(',', '.', $commission);

                $type_data = array(
                    'nom' => $csv_values[0],
                    'commission' => $commission
                );

                $this->CI->db->insert('typeBien', $type_data);
            }
        }
        return true;
    }

    private function convert_date_format($date_str) {
        // Supposons que le format initial soit 'DD/MM/YYYY' et que nous voulons 'YYYY-MM-DD'
        $date = DateTime::createFromFormat('d/m/Y', $date_str);
        return $date ? $date->format('Y-m-d') : null;
    }

    public function convert_datetime_format($date_string){
        if (!empty($date_string)) {
            $datetime = DateTime::createFromFormat('d/m/Y H:i:s', $date_string);
            if ($datetime !== false) {
                return $datetime->format('Y-m-d H:i:s');
            }
        }
        return null;
    }

    public function get_or_insert_type($type) {
        $query = $this->CI->db->get_where('typeBien', ['nom' => $type]);
        if ($query->num_rows() > 0) {
            return $query->row()->idTypeBien;
        } else {
            $this->CI->db->insert('typeBien', ['nom' => $type, 'commission' => 10]); // Ajustez la commission si nécessaire
            return $this->CI->db->insert_id();
        }
    }

    public function get_or_insert_owner($proprietaire) {
        $query = $this->CI->db->get_where('users', ['username' => $proprietaire,'phone' => $proprietaire, 'role' => 'proprietaire']);
        if ($query->num_rows() > 0) {
            return $query->row()->id;
        } else {
            $this->CI->db->insert('users', ['username' => $proprietaire, 'password' => $proprietaire,'phone' => $proprietaire, 'role' => 'proprietaire']);
            return $this->CI->db->insert_id();
        }
    }

    public function get_or_insert_ref($reference) {
        $query = $this->CI->db->get_where('Bien', ['reference' => $reference]);
        if ($query->num_rows() > 0) {
            return $query->row()->idBien;
        }
    }

    public function get_or_insert_customer($proprietaire) {
        $query = $this->CI->db->get_where('users', ['username' => $proprietaire, 'email' => $proprietaire,'role' => 'client']);
        if ($query->num_rows() > 0) {
            return $query->row()->id;
        } else {
            $this->CI->db->insert('users', ['username' => $proprietaire, 'password' => $proprietaire, 'email' => $proprietaire,'role' => 'client']);
            return $this->CI->db->insert_id();
        }
    }

    public function import_data_biens($file_path_devis)
    {
        if (!file_exists($file_path_devis)) {
            return false;
        }

        $file_content = file_get_contents($file_path_devis);

        if (empty($file_content)) {
            return false;
        }

        $csv_lines = explode(PHP_EOL, $file_content);

        for ($i = 1; $i < count($csv_lines); $i++) {
            $line = $csv_lines[$i];

            if (!empty($line)) {
                $csv_values = str_getcsv($line);

                $idTypeBien = $this->get_or_insert_type($csv_values[3]);
                $idProprietaire = $this->get_or_insert_owner($csv_values[6]);

                $devis_data = array(
                    'reference' => $csv_values[0],
                    'idTypeBien' => $idTypeBien,
                    'nom' => $csv_values[1],
                    'region' => $csv_values[4],
                    'loyerparmois' => $csv_values[5],
                    'idProprietaire' => $idProprietaire
                );

                $this->CI->db->insert('Bien', $devis_data);
            }
        }
        return true;
    }

    public function import_data_locs($file_path_detail_travaux)
    {
        if (!file_exists($file_path_detail_travaux)) {
            return false;
        }

        $file_content = file_get_contents($file_path_detail_travaux);

        if (empty($file_content)) {
            return false;
        }

        $csv_lines = explode(PHP_EOL, $file_content);

        for ($i = 1; $i < count($csv_lines); $i++) {
            $line = $csv_lines[$i];

            if (!empty($line)) {
                $csv_values = str_getcsv($line);

                $idBien = $this->get_or_insert_ref($csv_values[0]);
                $idClient = $this->get_or_insert_customer($csv_values[3]);

                $loc_data = array(
                    'bien_id' => $idBien,
                    'client_id' => $idClient,
                    'duree_mois' => $csv_values[2],
                    'date_debut' => $this->convert_date_format($csv_values[1])
                );

                $this->CI->db->insert('locations', $loc_data);
            }
        }
        return true;
    }
}


