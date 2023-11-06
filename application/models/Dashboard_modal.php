<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_modal extends CI_Model
{

    public function get_arsip()
    {
        $this->db2 = $this->load->database('dbsipp', TRUE);

        $result = $this->db2->query('SELECT COUNT(*) as arsip FROM arsip ');

        // Memeriksa apakah query berhasil dieksekusi
        if ($result) {
            // Mengambil hasil query dalam bentuk array
            $data = $result->result_array();

            return $data;
        } else {
            return null;
        }
    }

    public function get_sipp()
    {
        $this->db2 = $this->load->database('dbsipp', TRUE);

        $result = $this->db2->query('SELECT COUNT(*) as sipp FROM perkara ');

        // Memeriksa apakah query berhasil dieksekusi
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

        $query = $this->db2->query("SELECT SQL_CALC_FOUND_ROWS 
					perkara_id,
                    id as arsip_id,
					nomor_arsip,
					no_ruang,
					no_lemari,
					no_rak,
					no_berkas,
					nomor_perkara,
					tanggal_masuk_arsip,
					nama_penerima,
					nama_penyerah,
					lengkap,
					status as status_id,
					IF (status=1,'Ada',if(status=2,'Dipinjam','Pemusnahan')) as status
				from arsip ORDER BY arsip_id DESC");

        return $query->result();
    }

    public function get_kolom($value)
    {
        $this->db2 = $this->load->database('dbsipp', TRUE);

        $query = $this->db2->query("SELECT a.`perkara_id`, a.`nomor_perkara`,a.`tanggal_putusan`, b.`nomor_akta_cerai`
        FROM sipp.`v_perkara` AS a LEFT JOIN sipp.`perkara_akta_cerai` AS b ON a.`perkara_id` = b.`perkara_id` WHERE a.`perkara_id` = '" . $value . "' ");
        return $query->row();
    }

    public function simpan_box($data)
    {

        $item = array(
            'perkara_id' => $data['perkara_id'],
            'tanggal_box' => $data['tanggal_box']
        );

        $query = $this->db->query(
            "INSERT INTO box_real (perkara_id, tanggal_box) VALUES (?, ?)",
            array($item['perkara_id'], $item['tanggal_box'])
        );

        if (!$query) {
            $error_message = $this->db->error();
            return array('status' => 'error', 'message' => 'Terjadi kesalahan saat menyimpan data: ' . $error_message['message']);
        }

        return array('status' => 'success', 'message' => 'Data berhasil disimpan.');
    }
}