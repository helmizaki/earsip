<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Serah_Berkas_PPPANMUD_model extends CI_Model
{
    public function get_data()
    {
        $this->db2 = $this->load->database('dbsipp', TRUE);

        $query = $this->db2->query("SELECT a.`tanggal_putusan`, a.`tanggal_minutasi`
                FROM v_perkara AS a LEFT JOIN arsip AS b ON a.`perkara_id` = b.`perkara_id`
                WHERE b.`perkara_id` IS NULL AND a.`tanggal_bht` IS NULL GROUP BY a.`tanggal_putusan`
                ORDER BY a.`tanggal_putusan`");

        return $query->result_array();
    }

    public function get_list_minutasi($value)
    {
        $this->db2 = $this->load->database('dbsipp', TRUE);

        $query = $this->db2->query(
            "SELECT a.`perkara_id`,a.`nomor_perkara`,a.`jenis_perkara_nama`,a.`panitera_pengganti_text`, a.`tanggal_putusan`, b.`tanggal_minutasi`
        FROM sipp.`v_perkara` AS a LEFT JOIN earsip.`validasi_minutasi` AS b ON a.`perkara_id` = b.`perkara_id` WHERE a.`tanggal_putusan` = '" . $value . "' AND b.`perkara_id` IS NULL "
        );
        return $query->result();
    }

    public function get_list_BAP($value)
    {

        $query = $this->db->query(
            "SELECT a.`perkara_id`,a.`nomor_perkara`,a.`jenis_perkara_nama`,a.`panitera_pengganti_text`, a.`tanggal_putusan`, b.`tanggal_minutasi`, c.`nama`
				FROM sipp.`v_perkara` AS a 
				LEFT JOIN earsip.`validasi_minutasi` AS b ON a.`perkara_id` = b.`perkara_id` 
				JOIN sipp.`status_putusan` AS c ON c.`id` = a.`status_putusan_id`
				WHERE b.`tanggal_minutasi` = '" . $value . "' AND b.`perkara_id` IS NOT NULL "
        );
        return $query->result();
    }

    public function data_pp()
    {
        $this->db2 = $this->load->database('dbsipp', TRUE);
        $query = $this->db2->query(
            "SELECT nama_gelar FROM panitera_pn WHERE aktif = 'Y' AND id != 0"
        );
        return $query->result();
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
