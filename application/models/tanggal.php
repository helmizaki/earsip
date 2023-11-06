<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tanggal extends CI_Model
{
	function getIDAlurPerkara($idperkara)
	{
		try {
			$result = $this->db->query('SELECT alur_perkara_id FROM perkara WHERE perkara_id =' . $idperkara);
			if ($result->num_rows > 0) {
				return $result->row()->alur_perkara_id;
			} else {
				return '';
			}
		} catch (Exception $e) {
			return '';
		}
	}

	function getIDAJenisPerkara($idperkara)
	{
		try {
			$result = $this->db->query('SELECT jenis_perkara_id FROM perkara WHERE perkara_id =' . $idperkara);
			if ($result->num_rows > 0) {
				return $result->row()->jenis_perkara_id;
			} else {
				return '';
			}
		} catch (Exception $e) {
			return '';
		}
	}

	function getNomorPerkara($idperkara)
	{
		try {
			$result = $this->db->query('SELECT nomor_perkara FROM perkara WHERE perkara_id =' . $idperkara);
			if ($result->num_rows > 0) {
				return $result->row()->nomor_perkara;
			} else {
				return '';
			}
		} catch (Exception $e) {
			return '';
		}
	}

	function getTanggalPutusan($idperkara)
	{
		try {
			$result = $this->db->query('SELECT tanggal_putusan FROM perkara_putusan WHERE perkara_id =' . $idperkara);
			if ($result->num_rows > 0) {
				return $result->row()->tanggal_putusan;
			} else {
				return '';
			}
		} catch (Exception $e) {
			return '';
		}
	}

	function getTanggalPendaftaran($idperkara)
	{
		try {
			$result = $this->db->query('SELECT tanggal_pendaftaran FROM perkara WHERE perkara_id =' . $idperkara);
			if ($result->num_rows > 0) {
				return $result->row()->tanggal_pendaftaran;
			} else {
				return '';
			}
		} catch (Exception $e) {
			return '';
		}
	}

	function getTanggalPenetapanSidangPertama($idperkara)
	{
		try {
			$result = $this->db->query('SELECT penetapan_hari_sidang FROM perkara_penetapan WHERE perkara_id =' . $idperkara);
			if ($result->num_rows > 0) {
				return $result->row()->penetapan_hari_sidang;
			} else {
				return '';
			}
		} catch (Exception $e) {
			return '';
		}
	}

	function getTanggalSidangPertama($idperkara)
	{
		try {
			$result = $this->db->query('SELECT sidang_pertama FROM perkara_penetapan WHERE perkara_id =' . $idperkara);
			if ($result->num_rows > 0) {
				return $result->row()->sidang_pertama;
			} else {
				return '';
			}
		} catch (Exception $e) {
			return '';
		}
	}

	function getIDProsesTerakhir($idperkara)
	{
		try {
			$result = $this->db->query('SELECT proses_terakhir_id FROM perkara WHERE perkara_id =' . $idperkara);
			if ($result->num_rows > 0) {
				return $result->row()->proses_terakhir_id;
			} else {
				return '';
			}
		} catch (Exception $e) {
			return '';
		}
	}

	function getPerkaraJuncto($perkara_pailit_id)
	{
		try {
			$result = $this->db->query('SELECT perkara_id FROM perkara_juncto WHERE perkara_pailit_id =' . $perkara_pailit_id);
			if ($result->num_rows > 0) {
				return $result->row()->perkara_id;
			} else {
				return '';
			}
		} catch (Exception $e) {
			return '';
		}
	}
}
