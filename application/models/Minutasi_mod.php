<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Minutasi_mod extends CI_Model {

     public function minutasi_list() {
        $this->db2 = $this->load->database('dbsipp', TRUE);
        
        $result = $this->db2->query("SELECT a.`nomor_perkara`,a.`tanggal_putusan`,a.`tanggal_minutasi` FROM v_perkara AS a 
        WHERE a.`tanggal_putusan` IS NOT NULL AND a.`tanggal_putusan` > '2021-12-31' ORDER BY a.`tanggal_putusan` DESC");        

        
        if ($result) {
            // Mengambil hasil query dalam bentuk array
            $data = $result->result_array();
            
            return $data;
        } else {
            return null;
        }

    }

    public function get_data() {
        $this->db2 = $this->load->database('dbsipp', TRUE);
        
        $query = $this->db2->query("SELECT a.`tanggal_putusan`, a.`tanggal_minutasi` FROM v_perkara AS a GROUP BY a.`tanggal_putusan` ORDER BY a.`tanggal_putusan`");

        return $query->result();

        

    }
   

}