<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('is_logged_in')) {
			redirect('login');
		}
	}


	public function index()
	{

		$this->load->model('dashboard_modal');
		$data['arsip'] = $this->dashboard_modal->get_arsip();
		$data['sipp'] = $this->dashboard_modal->get_sipp();
		$this->load->view('header');
		$this->load->view('sidebar');
		$this->load->view('footer');
		$this->load->view('dashboard', $data);
	}

	public function get_data()
	{
		$this->load->model('Putusan_model');
		$data = $this->Putusan_model->get_data(); // Ganti dengan metode yang sesuai dari model Anda

		echo json_encode($data);
	}

	public function get_kolom()
	{
		$this->load->model('dashboard_modal');

		$value = $this->input->post('value'); // Mendapatkan nilai dari tombol


		$data = $this->dashboard_modal->get_kolom($value); // Memanggil model untuk mengambil data dari database

		echo json_encode($data);
	}

	public function simpankedb()
	{
		$this->load->model('dashboard_modal');

		$data = array(
			'perkara_id' => $this->input->post('perkara_id'),
			'tanggal_box' => $this->input->post('tanggal_box')
		);

		$saved = $this->dashboard_modal->simpan_box($data);

		if ($saved['status'] === 'success') {
			$response = array('status' => 'success', 'message' => 'Data berhasil disimpan.');
		} else {
			$response = array('status' => 'error', 'message' => $saved['message']);
		}

		echo json_encode($response);
	}
}