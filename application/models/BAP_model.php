<?php
defined('BASEPATH') or exit('No direct script access allowed');

class BAP_model extends CI_Model
{
    public function get_list_BAP($value)
    {

        $query = $this->db->query(
            "SELECT a.`perkara_id`,a.`nomor_perkara`, a.`tanggal_putusan`, b.`tanggal_minutasi` , a.`jenis_perkara_nama`, c.`nama_gelar`, d.`nama`
            FROM sipp.`v_perkara` AS a 
            LEFT JOIN earsip.`validasi_minutasi` AS b ON a.`perkara_id` = b.`perkara_id` 
            LEFT JOIN sipp.`panitera_pn` AS c ON c.`id` = a.`panitera_pengganti_id`
            LEFT JOIN sipp.`status_putusan` AS d ON d.`id` = a.`status_putusan_id`
            WHERE b.`tanggal_minutasi` = '" . $value . "' AND b.`perkara_id` IS NOT NULL "
        );
        return $query->result();
    }
    public function get_data()
    {
        $this->db2 = $this->load->database('dbsipp', TRUE);

        $query = $this->db2->query("SELECT a.`tanggal_putusan`, a.`tanggal_minutasi`, a.`jenis_perkara_nama`
FROM sipp.`v_perkara` AS a JOIN earsip.`validasi_minutasi` AS b ON a.`perkara_id` = b.`perkara_id`
WHERE b.`perkara_id` IS NOT NULL GROUP BY a.`tanggal_putusan` ORDER BY a.`tanggal_putusan` ");

        return $query->result_array();
    }

    public function get_panmudGut()
    {
        $query = $this->db->query("SELECT * FROM users WHERE jabatan = 'Panitera Muda Gugatan'");
        return $query->result();
    }
    public function get_panmudHuk()
    {
        $query = $this->db->query("SELECT * from users where jabatan = 'Panitera Muda Hukum'");
        return $query->result();
    }

    public function get_panmudPer()
    {
        $query = $this->db->query("SELECT * FROM users WHERE jabatan = 'Panitera Muda Permohonan'");
        return $query->result();
    }
}