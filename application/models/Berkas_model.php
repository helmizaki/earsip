<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Berkas_model extends CI_Model
{


    public function get_data()
    {
        $this->db2 = $this->load->database('dbsipp', TRUE);

        $query = $this->db2->query("SELECT a.`perkara_id`, a.`nomor_perkara`, a.`tanggal_bht`,
        CASE a.`status_putusan_id` 
        WHEN 7 THEN 'Dicabut'
        WHEN 62 THEN 'Dikabulkan'
        WHEN 63 THEN 'Ditolak'
        WHEN 64 THEN 'Tidak Dapat Diterima'
        WHEN 65 THEN 'Digugurkan'
        WHEN 66 THEN 'Dicoret dari Register'
        WHEN 67 THEN 'Dicabut'
        WHEN 85 THEN 'Perdamaian'
        WHEN 93 THEN 'Gugur' 
        END AS status_putusan,
        b.`status_id` FROM sipp.`v_perkara` AS a INNER JOIN earsip.`status_berkas` AS b ON a.`perkara_id` = b.`perkara_id`");

        return $query->result();
    }
}
