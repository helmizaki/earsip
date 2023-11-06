<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Putusan_model extends CI_Model
{

	public function get_data()
	{
		$this->db2 = $this->load->database('dbsipp', TRUE);

		$query = $this->db2->query(
			"SELECT 
				b.`perkara_id`,
				a.`id` AS arsip_id,
				a.`nomor_arsip`,
				a.`no_ruang`,
				a.`no_lemari`,
				a.`no_rak`,
				a.`no_berkas`,
				b.`nomor_perkara`,
				b.`jenis_perkara_nama`, 
				b.`status_putusan_id`,
				c.`nama`,
				a.`tanggal_masuk_arsip`,
				d.`nomor_akta_cerai`,
				a.`nama_penerima`,
				a.`nama_penyerah`,
				a.`lengkap`,
				z.`tanggal_box`
				FROM sipp.`v_perkara` AS b 
				LEFT JOIN sipp.`arsip` AS a ON a.`perkara_id` = b.`perkara_id` 
				LEFT JOIN sipp.`status_putusan` AS c ON c.`id` = b.`status_putusan_id`
				LEFT JOIN sipp.`perkara_akta_cerai` AS d ON d.`perkara_id` = a.`perkara_id`
				LEFT JOIN earsip.`box_real` AS z ON b.`perkara_id` = z.`perkara_id`
				WHERE b.`perkara_id` IS NOT NULL"
		);

		return $query->result();
	}
}