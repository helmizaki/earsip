<?php
defined('BASEPATH') or exit('No direct script access allowed');

class List_minutasi extends CI_Model
{

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
            "SELECT a.`perkara_id`,a.`nomor_perkara`, a.`tanggal_putusan`, b.`tanggal_minutasi` , a.`jenis_perkara_nama`, c.`nama_gelar`, d.`nama`
            FROM sipp.`v_perkara` AS a 
            LEFT JOIN earsip.`validasi_minutasi` AS b ON a.`perkara_id` = b.`perkara_id` 
            LEFT JOIN sipp.`panitera_pn` AS c ON c.`id` = a.`panitera_pengganti_id`
            LEFT JOIN sipp.`status_putusan` AS d ON d.`id` = a.`status_putusan_id`
            WHERE b.`tanggal_minutasi` = '" . $value . "' AND b.`perkara_id` IS NOT NULL "
        );
        return $query->result();
    }


    public function compare_table_rows($tanggal_minutasi)
    {

        // Query SQL untuk menghitung jumlah baris pada tabel berdasarkan tanggal_minutasi
        $query = $this->db->query("SELECT COUNT(*) as total_rows FROM earsip.`validasi_minutasi` as a WHERE a.`tanggal_minutasi` = '" . $tanggal_minutasi . "'");
        $query2 = $this->db->query("SELECT COUNT(*) as total_rows FROM sipp.`v_perkara` as a WHERE a.`tanggal_putusan` = '" . $tanggal_minutasi . "'");
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

    public function hapus_validasi($perkaraId)
    {
        // Assuming your table is named 'your_table_name'
        $this->db->where('perkara_id', $perkaraId);
        $this->db->delete('validasi_minutasi');

        // Check if the delete operation was successful
        return $this->db->affected_rows() > 0;
    }
}