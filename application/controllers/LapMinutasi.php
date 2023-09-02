<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LapMinutasi extends CI_Controller {

	public function __construct(){
		parent::__construct();
		if($this->session->userdata('is_logged_in')==FALSE){
			redirect('login');
		}
		$this->load->model('Laporan_minutasi_mod');
	}
	
    
	public function index()
	{		
        $this->load->view('header');
		$this->load->view('sidebar');
		$this->load->view('footer');
		$this->load->view('laporan_minutasi');
		
	}

	public function show_list(){
		$tgl_start = $this->input->post('tgl_start');
		$tgl_finish =  $this->input->post('tgl_finish');

		// Panggil method dari model untuk mengambil data
        $data['result'] = $this->Laporan_minutasi_mod->get_data($tgl_start, $tgl_finish);

		$json_data = json_encode($data['result']);

    // Mengirimkan data sebagai respons JSON
    header('Content-Type: application/json');
    echo $json_data;
		
		
	}

}