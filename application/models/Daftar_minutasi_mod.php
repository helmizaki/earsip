<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Daftar_minutasi_mod extends CI_Model
{

    public function get_data()
    {


        $query = $this->db->query(
            "SELECT 
                b.`perkara_id`,
                b.`nomor_perkara`,
                b.`jenis_perkara_nama`, 
                b.`status_putusan_id`,
                a.`tanggal_masuk_arsip`,
                z.`tanggal_box`,
                zz.`tanggal_validasi`
                FROM sipp.`v_perkara` AS b 
                LEFT JOIN sipp.`arsip` AS a ON a.`perkara_id` = b.`perkara_id` 
                LEFT JOIN earsip.`box_real` AS z ON b.`perkara_id` = z.`perkara_id`
                LEFT JOIN earsip.`validasi_minutasi` AS zz ON b.`perkara_id` = zz.`perkara_id`
                WHERE zz.`perkara_id` IS NOT NULL AND a.`tanggal_masuk_arsip` > '2021-12-31'"
        );

        return $query->result();
    }
}
