<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('login_model');
		$this->load->model('login/validation_user');
	}
	public function index($err = FALSE)
	{
		if ($err == FALSE) {
			$err = FALSE;
		} else {
			$err = TRUE;
		}
		if ($this->session->userdata('is_logged_in')) {
			redirect('');
		} else {
			$this->doLogin($err);
		}
	}

	function doLogin($err = FALSE)
	{
		$data['error'] = $err;
		$this->load->vars($data);
		$this->load->view('login');
	}

	public function validation_credential()
	{
		$this->form_validation->set_rules('username', 'username', 'trim|required');
		$this->form_validation->set_rules('password', 'password', 'trim|required');
		if ($this->form_validation->run() === TRUE) {
			if ($this->validation_user->validate() == TRUE) {
				redirect('Dashboard');
			} else {
				redirect('Dashboard?login=gagal');
			}
		} else {
			redirect('Dashboard?login=gagal');
		}
	}

	public function logout()
	{
		// Hapus data user dari session saat logout
		$this->session->unset_userdata('user_id');
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('logged_in');
		redirect('login');
	}
}
