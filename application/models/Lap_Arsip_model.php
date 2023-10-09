<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lap_Arsip_model extends CI_Model {

    public function get_sisa_blm_box($bulan, $tahun){
        $this->db2 = $this->load->database('dbsipp', TRUE);
        $query = $this->db2->query("SELECT COUNT(*) AS data FROM v_perkara AS a WHERE MONTH(a.`tanggal_putusan`) = $bulan AND YEAR(a.`tanggal_putusan`) = $tahun");
        return $query->row();
    }

    public function get_masuk_box_sudah_putus($bulan, $tahun){
        $this->db2 = $this->load->database('dbsipp', TRUE);
        $query = $this->db2->query("SELECT COUNT(*) AS data
            FROM v_perkara AS a
            WHERE a.`perkara_id`  IN (
                SELECT b.`perkara_id`
                FROM arsip AS b
                WHERE MONTH(b.`tanggal_masuk_arsip`) = $bulan AND YEAR(b.`tanggal_masuk_arsip`) = $tahun
            ) AND a.`tanggal_putusan` IS NOT NULL;");
        return $query->row();
    }

    public function get_sisa_bln_lalu($bulan, $tahun){
        $this->db2 = $this->load->database('dbsipp', TRUE);
        $query = $this->db2->query("SELECT COUNT(a.`nomor_perkara`) as data
            FROM v_perkara AS a 
            WHERE a.`perkara_id` NOT IN (
                SELECT b.`perkara_id`
                FROM arsip AS b
                WHERE MONTH(b.`tanggal_masuk_arsip`) < $bulan AND YEAR(b.`tanggal_masuk_arsip`) <= $tahun 
            ) ");
        return $query->row();

    }

    public function get_putus_masuk_box($bulan, $tahun){
        $this->db2 = $this->load->database('dbsipp', TRUE);
        $query = $this->db2->query("SELECT COUNT(a.`nomor_perkara`) as data
            FROM v_perkara AS a 
            WHERE a.`perkara_id`  IN (
                SELECT b.`perkara_id`
                FROM arsip AS b
                WHERE MONTH(b.`tanggal_masuk_arsip`) = $bulan AND YEAR(b.`tanggal_masuk_arsip`) = $tahun 
            AND MONTH(a.`tanggal_putusan`) = $bulan AND YEAR(a.`tanggal_putusan`) = $tahun
            ) ");
        return $query->row();

    }

     public function get_blm_bht($bulan, $tahun){
        $this->db2 = $this->load->database('dbsipp', TRUE);
        $query = $this->db2->query("SELECT COUNT(*) AS data FROM v_perkara AS a 
        WHERE MONTH(a.`tanggal_putusan`) = $bulan AND YEAR(a.`tanggal_putusan`) = $tahun AND a.`tanggal_bht` IS NULL");
        return $query->row();

    }

    public function get_minutasi($bulan, $tahun){
        $this->db2 = $this->load->database('dbsipp', TRUE);
        $query = $this->db2->query("SELECT COUNT(*) AS data FROM v_perkara AS a 
        WHERE MONTH(a.`tanggal_putusan`) = $bulan AND YEAR(a.`tanggal_putusan`) = $tahun AND a.`tanggal_minutasi` IS NULL");
        return $query->row();
    }

    public function get_banding($bulan, $tahun){
        $this->db2 = $this->load->database('dbsipp', TRUE);
        $query = $this->db2->query("SELECT COUNT(*) AS data FROM v_perkara AS a JOIN `perkara_banding` AS b ON a.`perkara_id` = b.`perkara_id`
            WHERE MONTH(a.`tanggal_putusan`) = $bulan AND YEAR(a.`tanggal_putusan`) = $tahun AND (b.`putusan_banding` IS NULL OR MONTH(b.`putusan_banding`) < $bulan AND YEAR(b.`putusan_banding`) = $tahun)");
        return $query->row();
    }

     public function get_ikrar($bulan, $tahun){
        $this->db2 = $this->load->database('dbsipp', TRUE);
        $query = $this->db2->query("SELECT COUNT(*) AS data FROM v_perkara AS a JOIN perkara_ikrar_talak AS b ON a.`perkara_id` = b.`perkara_id`
        WHERE a.`tanggal_putusan` IS NOT NULL AND a.`jenis_perkara_id` = 346 AND a.`tanggal_putusan` > '2020-01-01'
        AND b.`tgl_ikrar_talak` IS NULL");
        return $query->row();
    }

     


}