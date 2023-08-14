<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Minutasi extends CI_Controller {

	public function __construct(){
		parent::__construct();

		$this->load->model('Minutasi_mod');
		$this->load->model('List_minutasi');
		
	}
	
    
	function is_login()
		{
			if($this->session->userdata('is_logged_in') == NULL OR $this->session->userdata('is_logged_in') == ""){
				$this->session->sess_destroy();
				redirect('login');
			}
		}

     public function index(){
        $this->is_login();
        $this->load->model('minutasi_mod');
        $data['list_minutasi'] = $this->minutasi_mod->minutasi_list();
        $this->load->view('header');
		$this->load->view('sidebar');
		$this->load->view('footer');
		$this->load->view('minutasi',$data);
        }


		public function list_minutasi(){

            $value = $this->input->post('value'); // Mendapatkan nilai dari tombol

            
			$data = $this->List_minutasi->get_list_minutasi($value); // Memanggil model untuk mengambil data dari database

			echo json_encode($data); // Mengembalikan data dalam format JSON
        }
		


		public function get_data() {
        $data = $this->Minutasi_mod->get_data(); // Ganti dengan metode yang sesuai dari model Anda

        echo json_encode($data);
    }

	public function insertToDatabase(){
		if ($this->input->is_ajax_request()) {
            $selected_items= $this->input->post('selected_items');

            if (!empty($selected_items)) {
				$sql = "INSERT IGNORE INTO validasi_minutasi (perkara_id, nomor_perkara, tanggal_putusan, tanggal_minutasi, tanggal_validasi) VALUES";
                foreach ($selected_items as $item) {
					
					 $sql .= "(" . $this->db->escape($item['perkara_id']) . ", " . $this->db->escape($item['nomor_perkara']) . ", " . $this->db->escape($item['tanggal_putusan']) . ", "  . $this->db->escape($item['tanggal_minutasi']) . ", ". $this->db->escape(date('Y-m-d H:i:s')) . "), ";

                }
				$sql = rtrim($sql, ', '); // Remove trailing comma and space
           		$this->db->query($sql);
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false]);
            }

        }
	}

    
    

}