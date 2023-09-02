<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pinjam extends CI_Controller {

	public function __construct(){
		parent::__construct();
		if($this->session->userdata('is_logged_in')==FALSE){
			redirect('login');
		}
        $this->load->model('Pinjam_model');
	}
	
    
	public function index()
	{		
        
        $this->load->view('header');
		$this->load->view('sidebar');
		$this->load->view('footer');
		$this->load->view('pinjam_berkas');		
	}

    public function get_data() {
        $data = $this->Pinjam_model->get_data(); // Ganti dengan metode yang sesuai dari model Anda

        $response = array(
            'data' => $data
        );

        echo json_encode($response);
    }

	public function get_kolom()
	{
		$value = $this->input->post('value'); // Mendapatkan nilai dari tombol

            
		$data = $this->Pinjam_model->get_kolom_pinjam($value); // Memanggil model untuk mengambil data dari database

		echo json_encode($data);
	}

	public function simpankedb() {
    $this->load->model('Pinjam_model'); // Load model

    $data = array(
        'perkara_id' => $this->input->post('perkara_id'),
        'nomor_perkara' => $this->input->post('nomor_perkara'),
        'nama_peminjam' => $this->input->post('nama_peminjam'),
        'tanggal_pinjam' => $this->input->post('tanggal_pinjam'),
        'tanggal_kembali' => $this->input->post('tanggal_kembali'),
        'keperluan' => $this->input->post('keperluan')
    );

    // Identifikasi data yang akan diperbarui (misalnya berdasarkan perkara_id)
    $identifikasi = array('perkara_id' => $data['perkara_id']);

    // Cek apakah data sudah ada
    if ($this->Pinjam_model->isDataExists($identifikasi)) {
        // Lakukan update data
        $is_updated = $this->Pinjam_model->update_pinjaman($identifikasi, $data);

        if ($is_updated['status'] === 'success') {
            $response = array('status' => 'success', 'message' => 'Data berhasil diperbarui.');
        } else {
            $response = array('status' => 'error', 'message' => $is_updated['message']);
        }
    } else {
        // Lakukan penyimpanan data baru
        $is_saved = $this->Pinjam_model->simpan_pinjaman($data);

        if ($is_saved['status'] === 'success') {
            $response = array('status' => 'success', 'message' => 'Data berhasil disimpan.');
        } else {
            $response = array('status' => 'error', 'message' => $is_saved['message']);
        }
    }

    echo json_encode($response);
}

}