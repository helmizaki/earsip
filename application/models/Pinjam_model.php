<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pinjam_model extends CI_Model {
    
    public function get_data() {
        $this->db2 = $this->load->database('dbsipp', TRUE);
                
        $query = $this->db2->query("SELECT a.`perkara_id`,a.`nomor_perkara`, a.`jenis_perkara_nama`, a.`tanggal_putusan`, CASE a.`status_putusan_id` 
        WHEN 7 THEN 'Dicabut'
        WHEN 62 THEN 'Dikabulkan'
        WHEN 63 THEN 'Ditolak'
        WHEN 64 THEN 'Tidak Dapat Diterima'
        WHEN 65 THEN 'Digugurkan'
        WHEN 66 THEN 'Dicoret dari Register'
        WHEN 67 THEN 'Dicabut'
        WHEN 85 THEN 'Perdamaian'
        WHEN 93 THEN 'Gugur' 
        END AS status_putusan, b.`tanggal_pinjam`, b.`tanggal_kembali` FROM sipp.`v_perkara` AS a LEFT JOIN earsip.`pinjam_berkas` AS b ON a.`perkara_id` = b.`perkara_id` WHERE a.`tanggal_putusan` IS NOT NULL");        
        return $query->result();
        

    }

    public function get_kolom_pinjam($value){
       // $this->db2 = $this->load->database('dbsipp', TRUE);
                
        $query = $this->db->query("SELECT a.`perkara_id`, a.`nomor_perkara`,b.`nama_peminjam`,b.`keperluan`, b.`tanggal_kembali`, b.`tanggal_pinjam` FROM sipp.`v_perkara` AS a LEFT JOIN earsip.`pinjam_berkas` AS b ON a.`perkara_id` = b.`perkara_id` WHERE a.`perkara_id` = '".$value."' ");        
        return $query->row();
        
    }

   public function simpan_pinjaman($data) {
        $item = array(
            'perkara_id' => $data['perkara_id'],
            'nomor_perkara' => $data['nomor_perkara'],
            'nama_peminjam' => $data['nama_peminjam'],
            'tanggal_pinjam' => $data['tanggal_pinjam'],
            'keperluan' => $data['keperluan']
        );

        if (isset($data['tanggal_kembali'])) {
            $item['tanggal_kembali'] = $data['tanggal_kembali'];
        }

        $query = $this->db->query("INSERT INTO pinjam_berkas (perkara_id, nomor_perkara, nama_peminjam, tanggal_pinjam, tanggal_kembali, keperluan) VALUES (?, ?, ?, ?, ?, ?)", array($item['perkara_id'], $item['nomor_perkara'], $item['nama_peminjam'], $item['tanggal_pinjam'], $item['tanggal_kembali'], $item['keperluan']));

        if (!$query) {
            $error_message = $this->db->error();
            return array('status' => 'error', 'message' => 'Terjadi kesalahan saat menyimpan data: ' . $error_message['message']);
        }

        return array('status' => 'success', 'message' => 'Data berhasil disimpan.');
    }

    public function isDataExists($identifikasi) {
        // Contoh: Cek apakah data dengan perkara_id tertentu sudah ada
        $query = $this->db->get_where('pinjam_berkas', $identifikasi);
        return $query->num_rows() > 0;
    }

    public function update_pinjaman($identifikasi, $data) {
        // Contoh: Update data berdasarkan perkara_id
        $this->db->where($identifikasi);
        $is_updated = $this->db->update('pinjam_berkas', $data);

        if ($is_updated) {
            return array('status' => 'success', 'message' => 'Data berhasil diperbarui.');
        } else {
            return array('status' => 'error', 'message' => 'Gagal memperbarui data.');
        }
    }

   

}