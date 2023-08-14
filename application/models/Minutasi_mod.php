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

     public function insertSelected($item, $user_id) {
        $data = [
            'perkara_id' => $item['perkara_id'],
            'nomor_perkara' => $item['nomor_perkara'],
            'tanggal_putusan' => $item['tanggal_putusan'],
            'tanggal_minutasi' => $item['tanggal_minutasi'],
            'user_id' => $user_id,
            'status'=>'1',
            'tanggal_validasi' =>  date('Y-m-d H:i:s')

           
        ];

        // Using INSERT IGNORE to avoid duplicates
        $this->db->query("INSERT IGNORE INTO validasi_minutasi (perkara_id, nomor_perkara, tanggal_putusan, tanggal_minutasi, validasi_oleh, status, tanggal_validasi) VALUES (?, ?, ?, ?,?,?,?)", array($data['perkara_id'], $data['nomor_perkara'], $data['tanggal_putusan'], $data['tanggal_minutasi'],$data['user_id'],$data['status'],$data['tanggal_validasi']));
    }

    public function checkExistingData($item_id)
    {
         $query = $this->db->get_where('validasi_minutasi', ['perkara_id' => $item_id]);
         return $query->row();
    }
   

}