<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BukuNikah extends CI_Controller {

	public function __construct(){
		parent::__construct();
		if($this->session->userdata('is_logged_in')==FALSE){
			redirect('login');
		}
        $this->load->model('Buku_Nikah_model');
	}
	
    
	public function index()
	{		
        
        $this->load->view('header');
		$this->load->view('sidebar');
		$this->load->view('footer');
		$this->load->view('upload_bukunikah');		
	}

    public function get_data() {
        $data = $this->Buku_Nikah_model->get_data(); // Ganti dengan metode yang sesuai dari model Anda

        $response = array(
            'data' => $data
        );

        echo json_encode($response);
    }

    public function upload() {
    $perkara_id = $this->input->post('perkara_id');
    $akta_nikah = $this->input->post('akta_nikah');

    // Konfigurasi untuk mengunggah gambar
    $config['upload_path'] = 'buku_nikah/';
    $config['allowed_types'] = 'gif|jpg|jpeg|png';
    $config['max_size'] = 2048; // 2MB
    $this->load->library('upload', $config);

    if ($this->upload->do_upload('image')) {
        $data = $this->upload->data();
        $original_file_name  = $data['file_name'];
        $file_extension = pathinfo($original_file_name, PATHINFO_EXTENSION); // Ekstensi file
        // Generate nama file yang baru (direname)
    $new_file_name = 'Buku_Nikah_' . $perkara_id . '_' . time() . '.' . $file_extension; // Anda dapat mengganti "prefix_" sesuai dengan kebutuhan

    // Path lengkap baru (folder path + nama file yang direname)
    $new_file_path = $config['upload_path'] . $new_file_name;

    // Pindahkan file yang diunggah ke path baru
    rename($data['full_path'], $new_file_path);

    // Sekarang, $new_file_path berisi path lengkap file yang direname


        // Simpan informasi gambar dan data lainnya ke dalam database
        $gambar_data = array(
            'perkara_id' => $perkara_id,
            'akta_nikah' => $akta_nikah,
            'file_name' => $new_file_path
        );

        $this->Buku_Nikah_model->simpan_data($gambar_data);

        $response = array('status' => 'success', 'message' => 'Data berhasil diperbarui.');
        echo json_encode($response);
    } else {
        $error_message = $this->upload->display_errors();
        $error = array('status' => 'error', 'message' => 'Terjadi kesalahan saat mengunggah data: ' . $error_message);
        echo json_encode($error);
    }
}


    public function get_kolom()
	{
		$value = $this->input->post('value'); // Mendapatkan nilai dari tombol

            
		$data = $this->Buku_Nikah_model->get_kolom_buku_nikah($value); // Memanggil model untuk mengambil data dari database

		echo json_encode($data);
	}
}