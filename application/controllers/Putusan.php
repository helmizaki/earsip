<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Putusan extends CI_Controller {

	public function __construct(){
		parent::__construct();
		if($this->session->userdata('is_logged_in')==FALSE){
			redirect('login');
		}
        $this->load->model('Putusan_model');
	}
	
    
	public function index()
	{

		
        $this->load->view('header');
		$this->load->view('sidebar');
		$this->load->view('footer');
		$this->load->view('putusan');
		
	}

    public function get_data() {
        $data = $this->Putusan_model->get_data(); // Ganti dengan metode yang sesuai dari model Anda

        echo json_encode($data);
    }
}