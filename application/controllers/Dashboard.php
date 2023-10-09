<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct(){
		parent::__construct();
		if(!$this->session->userdata('is_logged_in')){
			redirect('login');}
		
	}
	
    
	public function index()
	{

		$this->load->model('dashboard_modal');
		$data['arsip'] = $this->dashboard_modal->get_arsip();
		$data['sipp'] = $this->dashboard_modal->get_sipp();		
        $this->load->view('header');
		$this->load->view('sidebar');
		$this->load->view('footer');
		$this->load->view('dashboard',$data);	
		
	}

	 public function get_data() {
		$this->load->model('Putusan_model');
        $data = $this->Putusan_model->get_data(); // Ganti dengan metode yang sesuai dari model Anda

        echo json_encode($data);
    }
}