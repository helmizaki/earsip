<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class List_minutasi extends CI_Model {
    
    public function get_list_minutasi($value) {
        $this->db2 = $this->load->database('dbsipp', TRUE);
                
        $query = $this->db2->query("SELECT a.`perkara_id`,a.`nomor_perkara`, a.`tanggal_putusan`, a.`tanggal_minutasi` 
FROM sipp.`v_perkara` AS a LEFT JOIN earsip.`validasi_minutasi` AS b ON a.`perkara_id` = b.`perkara_id` WHERE a.`tanggal_putusan` = '".$value."' AND b.`perkara_id` IS NULL ");        
        return $query->result();
        

    }


    public function compare_table_rows($tanggal_minutasi) {
        $this->db2 = $this->load->database('dbsipp', TRUE);
         // Query SQL untuk menghitung jumlah baris pada tabel berdasarkan tanggal_minutasi
        $query = $this->db->query("SELECT COUNT(*) as total_rows FROM earsip.`validasi_minutasi` as a WHERE a.`tanggal_minutasi` = '".$tanggal_minutasi."'");
        $query2 = $this->db2->query("SELECT COUNT(*) as total_rows FROM sipp.`v_perkara` as a WHERE a.`tanggal_minutasi` = '".$tanggal_minutasi."'");
        $result = $query->row();
        $totala = $result->total_rows;
        $hasil = $query2->row();
        $totalb = $hasil->total_rows;

        // Membandingkan jumlah baris dan menentukan status
        if ($totala == $totalb) {
            $comparison_status = 'matched';
        } else {
            $comparison_status = 'unmatched';
        }

        return $comparison_status;
    }






   

}