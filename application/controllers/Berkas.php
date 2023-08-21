<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Berkas extends CI_Controller {

	public function __construct(){
		parent::__construct();
		if($this->session->userdata('is_logged_in')==FALSE){
			redirect('login');
		}
        $this->load->model('Berkas_model');
	}
	
    
	public function index()
	{		
        
        $this->load->view('header');
		$this->load->view('sidebar');
		$this->load->view('footer');
		$this->load->view('lacak_berkas');		
	}

    public function get_data() {
        $data = $this->Berkas_model->get_data(); // Ganti dengan metode yang sesuai dari model Anda

        $response = array(
            'data' => $data
        );

        echo json_encode($response);
    }
}