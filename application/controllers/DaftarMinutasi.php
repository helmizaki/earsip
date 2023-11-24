<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DaftarMinutasi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('is_logged_in') == FALSE) {
            redirect('login');
        }
        $this->load->model('Daftar_minutasi_mod');
    }


    public function index()
    {
        $this->load->view('header');
        $this->load->view('sidebar');
        $this->load->view('footer');
        $this->load->view('daftar_minutasi');
    }

    public function get_data()
    {
        $data = $this->Daftar_minutasi_mod->get_data(); // Ganti dengan metode yang sesuai dari model Anda

        echo json_encode($data);
    }
}
