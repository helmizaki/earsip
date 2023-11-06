<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Arsip_model extends CI_Model
{
	public function arsip_list()
	{
		$this->db2 = $this->load->database('dbsipp', TRUE);

		$result = $this->db2->query(
		"SELECT SQL_CALC_FOUND_ROWS 
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

		// Memeriksa apakah query berhasil dieksekusi
		if ($result) {
			// Mengambil hasil query dalam bentuk array
			$data = $result->result_array();

			return $data;
		} else {
			return null;
		}
	}
}
