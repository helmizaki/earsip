<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class List_minutasi extends CI_Model {
    
    public function get_list_minutasi($value) {
        $this->db2 = $this->load->database('dbsipp', TRUE);
                
        $query = $this->db2->query("SELECT a.`perkara_id`,a.`nomor_perkara`, a.`tanggal_putusan`, a.`tanggal_minutasi` FROM v_perkara AS a WHERE a.`tanggal_putusan` = '".$value."' ");        
        return $query->result();
        

    }

   

}