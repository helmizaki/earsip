<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Minutasi_mod extends CI_Model
{

    public function minutasi_list()
    {
        $this->db2 = $this->load->database('dbsipp', TRUE);

        $result = $this->db2->query(
            "SELECT a.`nomor_perkara`,a.`tanggal_putusan`,a.`tanggal_minutasi` FROM v_perkara AS a 
        WHERE a.`tanggal_putusan` IS NOT NULL AND a.`tanggal_putusan` > '2021-12-31' ORDER BY a.`tanggal_putusan` DESC"
        );


        if ($result) {
            // Mengambil hasil query dalam bentuk array
            $data = $result->result_array();

            return $data;
        } else {
            return null;
        }
    }

    public function get_data()
    {
        $this->db2 = $this->load->database('dbsipp', TRUE);

        $query = $this->db2->query("SELECT a.`tanggal_putusan`, a.`tanggal_minutasi`
FROM v_perkara AS a LEFT JOIN arsip AS b ON a.`perkara_id` = b.`perkara_id`
WHERE b.`perkara_id` IS NULL AND a.`tanggal_bht` IS NULL GROUP BY a.`tanggal_putusan` ORDER BY a.`tanggal_putusan`");

        return $query->result_array();
    }

    public function check_matching_by_tanggal_minutasi($tanggal_minutasi)
    {
        $this->db->where('perkara_id', $tanggal_minutasi);
        $query = $this->db->get('validasi_minutasi');

        return $query->num_rows() > 0;
    }

    public function insertSelected($item, $user_id)
    {
        $data = [
            'perkara_id' => $item['perkara_id'],
            'nomor_perkara' => $item['nomor_perkara'],
            'tanggal_putusan' => $item['tanggal_putusan'],
            'tanggal_minutasi' => $item['tanggal_minutasi'],
            'tanggal_masuk' => date('Y-m-d'),
            'user_id' => $user_id
        ];

        // Using INSERT IGNORE to avoid duplicates
        $this->db->query("INSERT IGNORE INTO validasi_minutasi (perkara_id, nomor_perkara, tanggal_putusan, tanggal_minutasi,tanggal_masuk, validasi_oleh) VALUES (?, ?, ?, ?,?,?)", array($data['perkara_id'], $data['nomor_perkara'], $data['tanggal_putusan'], $data['tanggal_putusan'], $data['tanggal_masuk'], $data['user_id']));
    }

    public function get_v_perkara($item)
    {
        $perkara_id = $item['perkara_id'];
        $this->db2 = $this->load->database('dbsipp', TRUE);

        $query = "SELECT a.`perkara_id`, a.`nomor_perkara`,a.`tanggal_putusan`,a.`tanggal_bht`,'3' AS status_id, a.`status_putusan_id`, a.`tanggal_pendaftaran` FROM v_perkara AS a WHERE a.`perkara_id` = ?";

        $result = $this->db2->query($query, array($perkara_id)); // Eksekusi query untuk mengambil data dari Tabel A
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }

    public function insertkeberkas($data)
    {
        $perkara_id = $data['perkara_id'];
        $nomor_perkara = $data['nomor_perkara'];
        $tanggal_putusan = $data['tanggal_putusan'];
        $status = $data['status_id'];
        $status_putusan_id = $data['status_putusan_id'];
        $insertQuery = "INSERT IGNORE INTO status_berkas (perkara_id, nomor_perkara, tanggal_putusan,  status_id, status_putusan)
                    VALUES ('$perkara_id', '$nomor_perkara', '$tanggal_putusan', '$status', '$status_putusan_id')";

        $this->db->query($insertQuery);
        return $this->db->affected_rows() > 0;
    }

    public function checkExistingData($item_id)
    {
        $query = $this->db->get_where('validasi_minutasi', ['perkara_id' => $item_id]);
        return $query->row();
    }
}