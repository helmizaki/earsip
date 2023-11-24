<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('is_logged_in') == FALSE) {
            redirect('login');
        }
        $this->load->model('User_model');
    }

    public function index()
    {
        $data['list_pp'] = $this->User_model->data_pp();
        $this->load->view('header');
        $this->load->view('sidebar');
        $this->load->view('footer');
        $this->load->view('user', $data);
    }

    public function get_users()
    {
        $data = $this->User_model->get_users();
        $response = array(
            'data' => $data
        );
        echo json_encode($response);
    }

    public function get_kolom()
    {
        $value = $this->input->post('value'); // Mendapatkan nilai dari tombol


        $data = $this->User_model->get_kolom_user($value); // Memanggil model untuk mengambil data dari database

        echo json_encode($data);
    }

    public function update_nohp()
    {
        $panitera_id = $this->input->post('panitera_id');
        $nohp = $this->input->post('nohp');

        $data_user = array(
            'panitera_id' => $panitera_id,
            'nohp' => $nohp
        );

        $eksekusi = $this->User_model->simpan_data($data_user);

        if ($eksekusi) {
            $response = array('status' => 'success', 'message' => 'Data berhasil diperbarui.');
            echo json_encode($response);
        } else {
            $error_message = $this->upload->display_errors();
            $error = array('status' => 'error', 'message' => 'Terjadi kesalahan saat mengunggah data: ' . $error_message);
            echo json_encode($error);
        }
    }

    public function edit_user()
    {
        $id = $this->input->post('id');
        $data = $this->input->post();
        $this->User_model->edit_user($id, $data);
        echo json_encode(['success' => true]);
    }

    public function delete_user()
    {
        $id = $this->input->post('id');
        $this->User_model->delete_user($id);
        echo json_encode(['success' => true]);
    }
}
