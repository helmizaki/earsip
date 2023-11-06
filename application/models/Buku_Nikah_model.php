<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Buku_Nikah_model extends CI_Model
{


    public function get_data()
    {
        $this->db2 = $this->load->database('dbsipp', TRUE);

        $query = $this->db2->query("SELECT a.`perkara_id`, a.`nomor_perkara`, a.`tanggal_putusan`, b.`url` FROM sipp.`v_perkara` AS a LEFT JOIN earsip.`buku_nikah` AS b ON a.`perkara_id` = b.`perkara_id`
WHERE a.`tanggal_putusan` IS NOT NULL AND a.`status_putusan_id` = 62 AND (a.`jenis_perkara_id` = 347 OR a.`jenis_perkara_id` = 346)");

        return $query->result();
    }

    public function get_kolom_buku_nikah($value)
    {
        // $this->db2 = $this->load->database('dbsipp', TRUE);

        $query = $this->db->query("SELECT a.`perkara_id`, a.`nomor_perkara`,b.`nama_peminjam`,b.`keperluan`, b.`tanggal_kembali`, b.`tanggal_pinjam` FROM sipp.`v_perkara` AS a LEFT JOIN earsip.`pinjam_berkas` AS b ON a.`perkara_id` = b.`perkara_id` WHERE a.`perkara_id` = '" . $value . "' ");
        return $query->row();
    }


    public function simpan_data($data)
    {
        $item = array(
            'perkara_id' => $data['perkara_id'],
            'akta_nikah' => $data['akta_nikah'],
            'file_name' => $data['file_name']
        );


        $query = $this->db->query("INSERT INTO buku_nikah (perkara_id, url, pihak, jenis_buku_nikah) VALUES (?, ?, ?, ?)", array($item['perkara_id'], $item['file_name'], 'Penggugat / Pemohon', $item['akta_nikah']));

        if (!$query) {
            $error_message = $this->db->error();
            return array('status' => 'error', 'message' => 'Terjadi kesalahan saat menyimpan data: ' . $error_message['message']);
        }

        return array('status' => 'success', 'message' => 'Data berhasil disimpan.');
    }
}
