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

		public function get_BAP(){

            $value = $this->input->post('value'); // Mendapatkan nilai dari tombol

            
			$data = $this->List_minutasi->get_list_BAP($value); // Memanggil model untuk mengambil data dari database

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

	public function CetakKeWord(){
        require APPPATH .'third_party/PhpExcel/PhpExcel.php';
        

		$selected_items= $this->input->post('selected_items');
         // Panggil class PHPExcel nya
        $objPHPExcel = new PHPExcel();
		// Membaca file Excel yang sudah ada
        $objPHPExcel = PHPExcel_IOFactory::load('template/konsep.xlsx');
        $worksheet = $objPHPExcel->getActiveSheet();
        
        // Menggunakan variabel row untuk mengawasi baris saat mengisi data
        $row = 17;
        $no = 1;
        // Mengatur format tanggal "d/m/Y" untuk kolom tanggal (kolom C)
        $worksheet->getStyle('C')->getNumberFormat()->setFormatCode('dd/mm/yyyy');
        $worksheet->getStyle('D')->getNumberFormat()->setFormatCode('dd/mm/yyyy');
        foreach ($selected_items as $item) {
        $worksheet->setCellValue('A' . $row, $no);
        $worksheet->setCellValue('B' . $row, $item['nomor_perkara']);
        // Mengganti format tanggal ke format Excel
        $tgl_put = PHPExcel_Shared_Date::PHPToExcel(strtotime($item['tanggal_putusan']));
        $worksheet->setCellValue('C' . $row, $tgl_put);
        $tgl_min = PHPExcel_Shared_Date::PHPToExcel(strtotime($item['tanggal_minutasi']));
        $worksheet->setCellValue('D' . $row, $tgl_min);

        // Mengatur garis tepi untuk sel-sel B, C, dan D di baris saat ini
    $cellRange = 'A' . $row . ':E' . $row;
    $styleArray = array(
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN, // Ganti dengan style yang sesuai
            ),
        ),
    );
    $worksheet->getStyle($cellRange)->applyFromArray($styleArray);
        // Anda dapat menambahkan lebih banyak kolom sesuai kebutuhan
        $row++;
        $no++;
    }
   
        
        $roww = $row+2;
        $newrow = $roww+4;
        $worksheet->setCellValue('A' . $roww, 'Panitera Muda Gugatan,');
        $worksheet->getStyle('A' . $roww)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $worksheet->setCellValue('A' . $newrow, 'Hidayat Mursito,S.H.');
        $worksheet->getStyle('A' . $newrow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $worksheet->setCellValue('D' . $roww, 'Panitera Muda Hukum,');
        $worksheet->setCellValue('D' . $newrow, 'Lucky Aziz Hakim,S.H.I M.H.');       

    

       $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
       $objWriter->save('template/hasil.xlsx');

	}

    
    

}