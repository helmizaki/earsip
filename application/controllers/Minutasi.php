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
         $data = $this->Minutasi_mod->get_data();
         $response_data = [];

        foreach ($data as $row) {
            $tanggal_minutasi = $row['tanggal_minutasi'];
            //$matched = $this->Minutasi_mod->check_matching_by_tanggal_minutasi($tanggal_minutasi);
			$comparison_status = $this->List_minutasi->compare_table_rows($tanggal_minutasi);
            $row['matched'] = $comparison_status;
			$response_data[] = $row;
			
        }

       // Send the JSON response with data and matched information
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['data' => $response_data]));
    }



	public function insertToDatabase(){
		if ($this->input->is_ajax_request()) {
            $selected_items= $this->input->post('selected_items');

            if (!empty($selected_items)) {
				$response = [];

				$user_id = $this->session->userdata('username');
				
                foreach ($selected_items as $item) {
					$existingData = $this->Minutasi_mod->checkExistingData($item['perkara_id']);

					if (!$existingData) {

                    $this->Minutasi_mod->insertSelected($item,$user_id) ;

					$response[] = ['nomor_perkara' => $item['nomor_perkara'], 'status' => 'success'];

					$datadariselect= $this->Minutasi_mod->get_v_perkara($item);
					$this->Minutasi_mod->insertkeberkas($datadariselect[0]);

					}
					else {
						$response[] = ['nomor_perkara' => $item['nomor_perkara'], 'status' => 'exists'];
						
					}
                }
                echo json_encode($response);
            } else {
				echo json_encode(['success' => false]);
                
            }
        }
	}

    
    

}