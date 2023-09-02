<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_minutasi_mod extends CI_Model {

     public function get_data($tgl_start, $tgl_finish) {

        $query = $this->db->query("SELECT a.`nomor_perkara`,a.`tanggal_putusan`,a.`tanggal_minutasi`,a.`tanggal_masuk` FROM validasi_minutasi as a WHERE a.`tanggal_masuk` >= '".$tgl_start."' AND a.`tanggal_masuk` <= '".$tgl_finish."'");        
        $html = '<table>';
        foreach ($query->result() as $row) {
            $html .= '<tr>';
            $html .= '<td>' . $row->nomor_perkara . '</td>';
            $html .= '<td>' . $row->tanggal_putusan . '</td>';
            $html .= '<td>' . $row->tanggal_minutasi. '</td>';
            $html .= '<td>' . $row->tanggal_masuk. '</td>';
            // Tambahkan kolom lain sesuai kebutuhan
            $html .= '</tr>';
        }
        $html .= '</table>';
        
        return $html;
}



}