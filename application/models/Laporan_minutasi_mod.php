<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_minutasi_mod extends CI_Model {

     public function get_data($tgl_start, $tgl_finish) {

        $query = $this->db->query("SELECT a.`nomor_perkara`,a.`tanggal_putusan`,a.`tanggal_minutasi`,a.`tanggal_masuk` FROM validasi_minutasi as a WHERE a.`tanggal_masuk` >= '".$tgl_start."' AND a.`tanggal_masuk` <= '".$tgl_finish."'");        
        $html = '<table class="table table-bordered table-striped">';
        $html .='<th>Nomor</th><th>Nomor Perkara</th><th>Tanggal Putusan</th><th>Tanggal Minutasi</th><th>Tanggal Masuk</th>';
        $no = 1;
        foreach ($query->result() as $row) {            
            
            $html .= '<tr>';
            $html .= '<td>'.$no.'</td>';
            $html .= '<td>'. $row->nomor_perkara.'</td>';
            $html .= '<td>'.date("d/m/Y", strtotime($row->tanggal_putusan)).'</td>';
            $html .= '<td>'.date("d/m/Y", strtotime($row->tanggal_minutasi)).'</td>';
            $html .= '<td>'.date("d/m/Y", strtotime($row->tanggal_masuk)).'</td>';
            $html .= '</tr>';
            $no++;
        }
        $html .= '</table>';
        
        echo $html;
}



}