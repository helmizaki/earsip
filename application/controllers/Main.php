<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Login');
    }
    public function index()
    {
        if ($this->session->userdata('logged') != TRUE) {
            $this->load->view('Login');
        } else {
            $url = base_url('dashboard');
            redirect($url);
        };
    }

    public function process_login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        // Validasi user di database menggunakan model
        $user = $this->login_model-- > get_user($username, $password);

        if ($user) {
            // Jika user ditemukan, simpan data user ke session
            $user_data = array(
                'user_id' => $user->id,
                'username' => $user->username,
                'jabatan' => $user->jabatan,
                'level' => $user->level,
                'logged_in' => true
            );
            $this->session->set_userdata($user_data);
            // Redirect ke halaman dashboard
            redirect('dashboard');
        } else {
            // Jika user tidak ditemukan, kembali ke halaman login dengan pesan error
            $this->session->set_flashdata('error_msg', 'Username atau Password salah.');
            redirect('login');
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
