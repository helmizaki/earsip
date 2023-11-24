<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    public function get_users()
    {
        // Query untuk mendapatkan data pengguna dari database
        $query = $this->db->query("SELECT d.`nama_gelar`,d.`id`, e.`nohp`,e.`panitera_id`  FROM sipp.`sys_users` AS a 
LEFT JOIN sipp.`panitera_pn` AS d ON d.`id` = a.`userid`
LEFT JOIN earsip.`users` AS e ON e.`panitera_id` = d.`id`
WHERE d.`aktif` = 'Y'");
        return $query->result();
    }

    public function get_kolom_user($value)
    {
        // $this->db2 = $this->load->database('dbsipp', TRUE);

        $query = $this->db->query("SELECT d.`nama_gelar`, e.`nohp`,d.`id`  FROM sipp.`sys_users` AS a 
        LEFT JOIN sipp.`panitera_pn` AS d ON d.`id` = a.`userid`
        LEFT JOIN earsip.`users` AS e ON e.`panitera_id` = d.`id`
        WHERE d.`aktif` = 'Y' AND d.`id` =  '" . $value . "' ");
        return $query->row();
    }

    public function simpan_data($data)
    {
        $item = array(
            'panitera_id' => $data['panitera_id'],
            'nohp' => $data['nohp']
        );


        $query = $this->db->query("INSERT IGNORE INTO earsip.users (panitera_id, nohp) VALUES (?, ?)", array($item['panitera_id'], $item['nohp']));

        if (!$query) {
            $error_message = $this->db->error();
            return array('status' => 'error', 'message' => 'Terjadi kesalahan saat menyimpan data: ' . $error_message['message']);
        }

        return array('status' => 'success', 'message' => 'Data berhasil disimpan.');
    }

    public function edit_user($id, $data)
    {
        // Query untuk mengedit data pengguna berdasarkan ID
        $this->db->where('id', $id);
        $this->db->update('users', $data);
    }

    public function delete_user($id)
    {
        // Query untuk menghapus pengguna berdasarkan ID
        $this->db->where('id', $id);
        $this->db->delete('users');
    }

    public function data_pp()
    {
        $query = $this->db->query(
            "SELECT d.`nama_gelar`  FROM sipp.`sys_users` AS a 
            LEFT JOIN sipp.`panitera_pn` AS d ON d.`id` = a.`userid`
            WHERE d.`aktif` = 'Y'"
        );
        return $query->result();
    }
}
