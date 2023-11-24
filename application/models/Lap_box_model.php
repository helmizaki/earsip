<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lap_box_model extends CI_Model
{
    public function get_data($tgl_start, $tgl_finish)
    {

        $query = $this->db->query("SELECT b.`nomor_perkara`,b.`jenis_perkara_nama`,d.`tanggal_masuk`,a.`tanggal_box`
                                    FROM earsip.`box_real` AS a 
                                    LEFT JOIN sipp.`v_perkara` AS b ON a.`perkara_id` = b.`perkara_id`
                                    LEFT JOIN earsip.`validasi_minutasi` AS d ON d.`tanggal_masuk` = b.`perkara_id`
                                    LEFT JOIN sipp.`arsip` AS c ON b.`perkara_id` = c.`perkara_id`
                                    WHERE a.`tanggal_box` >= '" . $tgl_start . "' AND a.`tanggal_box` <= '" . $tgl_finish . "'");
        $html = '<table class="table table-bordered table-striped">';
        $html .= '<th>Nomor</th><th>Nomor Perkara</th><th>Jenis Perkara</th><th>Tanggal Minutasi</th><th>Tanggal BOX</th>';
        $no = 1;
        foreach ($query->result() as $row) {

            $html .= '<tr>';
            $html .= '<td>' . $no . '</td>';
            $html .= '<td>' . $row->nomor_perkara . '</td>';
            $html .= '<td>' . $row->jenis_perkara_nama  . '</td>';
            $html .= '<td>' . date("d/m/Y", strtotime($row->tanggal_masuk)) . '</td>';
            $html .= '<td>' . date("d/m/Y", strtotime($row->tanggal_box)) . '</td>';
            $html .= '</tr>';
            $no++;
        }
        $html .= '</table>';

        echo $html;
    }

    public function data_laporan($tgl_start, $tgl_finish)
    {
        $query = $this->db->query("SELECT a.`nomor_perkara`,a.`tanggal_putusan`,a.`tanggal_minutasi`,a.`tanggal_masuk`, b.`jenis_perkara_nama`, c.`nama_gelar`, d.`nama`, e.`tanggal_box`, a.`tanggal_validasi`
                                    FROM earsip.`validasi_minutasi` AS a 
                                    LEFT JOIN sipp.`v_perkara` AS b ON a.`perkara_id` = b.`perkara_id`
                                    LEFT JOIN sipp.`panitera_pn` AS c ON b.`panitera_pengganti_id` = c.`id`
                                    LEFT JOIN sipp.`status_putusan` AS d ON d.`id` = b.`status_putusan_id` 
                                    LEFT JOIN earsip.`box_real` AS e ON e.`perkara_id` = a.`perkara_id` 
                                    WHERE a.`tanggal_masuk` >= '" . $tgl_start . "' AND a.`tanggal_masuk` <= '" . $tgl_finish . "'");

        return $query->result();
    }
}
